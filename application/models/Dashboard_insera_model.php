<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_insera_model extends CI_Model {
    private $db_lama;
    private $open_statuses = array('NEW', 'DRAFT', 'ANALYSIS', 'PENDING', 'BACKEND');

    public function __construct() {
        parent::__construct();
        // Load secondary database
        $this->db_lama = $this->load->database('db_lama', TRUE);
    }

    private function _apply_workzone_filter() {
        if ($this->session->userdata('is_superadmin')) return;
        
        $workzone_group = $this->session->userdata('workzone');
        if (!$workzone_group) return;

        $mapping = array(
            '1' => array('TRK', 'TAJ', 'JWT'),
            '2' => array('MLN', 'TPE', 'NNK', 'SNY'),
            '3' => array('TRD', 'TBY', 'LNN', 'TSL', 'TLA'),
            '4' => array('MLN', 'TPE'),
            '5' => array('NNK', 'SNY'),
            '6' => array('TSL', 'TLA'),
            '7' => array('TRD', 'TBY', 'LNN')
        );

        if (isset($mapping[$workzone_group])) {
            $this->db_lama->where_in('work_zone', $mapping[$workzone_group]);
        }
    }

    public function get_stats() {
        $this->_apply_workzone_filter();
        $total = $this->db_lama->count_all_results('insera');
        
        $this->_apply_workzone_filter();
        $this->db_lama->where_in('ticket_status', $this->open_statuses);
        $open = $this->db_lama->count_all_results('insera');
        
        $this->_apply_workzone_filter();
        $this->db_lama->where_not_in('ticket_status', $this->open_statuses);
        $closed = $this->db_lama->count_all_results('insera');
        
        return array(
            'total' => $total,
            'open' => $open,
            'closed' => $closed
        );
    }

    public function get_pivot_by_category($status_type = 'OPEN', $categories = array(), $resolve_date_from = '', $resolve_date_to = '') {
        if ($status_type === 'OPEN') {
            $aging_expr = "TIMESTAMPDIFF(HOUR, reported_date, NOW())";
        } else {
            $aging_expr = "TIMESTAMPDIFF(HOUR, reported_date, resolve_date)";
        }

        $sql = "SELECT scrape_category, work_zone,
                   CASE 
                       WHEN work_zone IN ('NNK', 'SNY', 'MLN', 'TPE') THEN 'Nunukan'
                       WHEN work_zone IN ('JWT', 'TAJ', 'TRK') THEN 'Tarakan'
                       WHEN work_zone IN ('TSL', 'TLA', 'TRD', 'LNN', 'TBY') THEN 'Tanjung Redeb'
                       ELSE 'Other'
                   END AS service_area,
                   CASE
                       WHEN work_zone IN ('NNK', 'SNY') THEN 'Nunukan'
                       WHEN work_zone IN ('MLN', 'TPE') THEN 'Malinau'
                       WHEN work_zone IN ('JWT', 'TAJ') THEN 'Tarakan 1'
                       WHEN work_zone IN ('TRK') THEN 'Tarakan 2'
                       WHEN work_zone IN ('TSL', 'TLA') THEN 'Tanjung Selor'
                       WHEN work_zone IN ('TRD', 'LNN', 'TBY') THEN 'Tanjung Redeb'
                       ELSE 'Other'
                   END AS sektor,
                   SUM(CASE WHEN $aging_expr < 1 THEN 1 ELSE 0 END) AS `< 1 jam`,
                   SUM(CASE WHEN $aging_expr >= 1 AND $aging_expr < 2 THEN 1 ELSE 0 END) AS `1-2 jam`,
                   SUM(CASE WHEN $aging_expr >= 2 AND $aging_expr < 3 THEN 1 ELSE 0 END) AS `2-3 jam`,
                   SUM(CASE WHEN $aging_expr >= 3 AND $aging_expr < 6 THEN 1 ELSE 0 END) AS `3-6 jam`,
                   SUM(CASE WHEN $aging_expr >= 6 AND $aging_expr < 12 THEN 1 ELSE 0 END) AS `6-12 jam`,
                   SUM(CASE WHEN $aging_expr >= 12 AND $aging_expr < 36 THEN 1 ELSE 0 END) AS `12-36 jam`,
                   SUM(CASE WHEN $aging_expr >= 36 AND $aging_expr < 72 THEN 1 ELSE 0 END) AS `36-72 jam`,
                   SUM(CASE WHEN $aging_expr >= 72 THEN 1 ELSE 0 END) AS `> 72 jam`
                FROM insera
                WHERE scrape_category IS NOT NULL AND scrape_category != ''";

        if (!empty($categories)) {
            $cat_list = "'" . implode("','", $categories) . "'";
            $sql .= " AND scrape_category IN ($cat_list)";
        }

        $workzone_group = $this->session->userdata('workzone');
        if (!$this->session->userdata('is_superadmin') && $workzone_group) {
            $mapping = array(
                '1' => "'TRK', 'TAJ', 'JWT'",
                '2' => "'MLN', 'TPE', 'NNK', 'SNY'",
                '3' => "'TRD', 'TBY', 'LNN', 'TSL', 'TLA'",
                '4' => "'MLN', 'TPE'",
                '5' => "'NNK', 'SNY'",
                '6' => "'TSL', 'TLA'",
                '7' => "'TRD', 'TBY', 'LNN'"
            );
            if (isset($mapping[$workzone_group])) {
                $sql .= " AND work_zone IN (" . $mapping[$workzone_group] . ")";
            }
        }

        $status_list = "'" . implode("','", $this->open_statuses) . "'";
        if ($status_type === 'OPEN') {
            $sql .= " AND ticket_status IN ($status_list)";
        } else {
            $sql .= " AND ticket_status NOT IN ($status_list)";
            if (!empty($resolve_date_from)) {
                $safe_from = $this->db_lama->escape($resolve_date_from . ' 00:00:00');
                $sql .= " AND resolve_date >= $safe_from";
            }
            if (!empty($resolve_date_to)) {
                $safe_to = $this->db_lama->escape($resolve_date_to . ' 23:59:59');
                $sql .= " AND resolve_date <= $safe_to";
            }
        }

        $sql .= " GROUP BY scrape_category, service_area, sektor, work_zone";

        $query = $this->db_lama->query($sql);
        $result = $query->result_array();

        $pivot = array();
        foreach ($result as $row) {
            $cat = $row['scrape_category'];
            if (!isset($pivot[$cat])) {
                $pivot[$cat] = array();
            }
            $pivot[$cat][] = $row;
        }

        return $pivot;
    }

    public function get_detail_tickets($params) {
        $category = $params['scrape_category'];
        $work_zone = $params['work_zone'];
        $status_type = $params['status_type'];
        $bucket = $params['bucket'];
        $resolve_date_from = isset($params['resolve_date_from']) ? $params['resolve_date_from'] : '';
        $resolve_date_to = isset($params['resolve_date_to']) ? $params['resolve_date_to'] : '';

        $this->db_lama->where('scrape_category', $category);
        if ($work_zone !== 'ALL') {
            $this->db_lama->where('work_zone', $work_zone);
        } else {
            $this->_apply_workzone_filter();
        }

        if ($status_type === 'OPEN') {
            $this->db_lama->where_in('ticket_status', $this->open_statuses);
            $aging_expr = "TIMESTAMPDIFF(HOUR, reported_date, NOW())";
        } else {
            $this->db_lama->where_not_in('ticket_status', $this->open_statuses);
            $aging_expr = "TIMESTAMPDIFF(HOUR, reported_date, resolve_date)";
            if (!empty($resolve_date_from)) {
                $this->db_lama->where('resolve_date >=', $resolve_date_from . ' 00:00:00');
            }
            if (!empty($resolve_date_to)) {
                $this->db_lama->where('resolve_date <=', $resolve_date_to . ' 23:59:59');
            }
        }

        if ($bucket === '< 1 jam') {
            $this->db_lama->where("$aging_expr < 1", NULL, FALSE);
        } elseif ($bucket === '1-2 jam') {
            $this->db_lama->where("$aging_expr >= 1 AND $aging_expr < 2", NULL, FALSE);
        } elseif ($bucket === '2-3 jam') {
            $this->db_lama->where("$aging_expr >= 2 AND $aging_expr < 3", NULL, FALSE);
        } elseif ($bucket === '3-6 jam') {
            $this->db_lama->where("$aging_expr >= 3 AND $aging_expr < 6", NULL, FALSE);
        } elseif ($bucket === '6-12 jam') {
            $this->db_lama->where("$aging_expr >= 6 AND $aging_expr < 12", NULL, FALSE);
        } elseif ($bucket === '12-36 jam') {
            $this->db_lama->where("$aging_expr >= 12 AND $aging_expr < 36", NULL, FALSE);
        } elseif ($bucket === '36-72 jam') {
            $this->db_lama->where("$aging_expr >= 36 AND $aging_expr < 72", NULL, FALSE);
        } elseif ($bucket === '> 72 jam') {
            $this->db_lama->where("$aging_expr >= 72", NULL, FALSE);
        }

        if (isset($params['customer_type']) && $params['customer_type'] !== 'ALL' && !empty($params['customer_type'])) {
            $ct = $params['customer_type'];
            if ($ct === 'REGULER / BLANK') {
                $this->db_lama->group_start();
                    $this->db_lama->where('customer_type', 'REGULER');
                    $this->db_lama->or_where('customer_type', '');
                    $this->db_lama->or_where('customer_type', NULL);
                $this->db_lama->group_end();
            } else {
                $this->db_lama->where('customer_type', $ct);
            }
        }

        $this->db_lama->order_by('reported_date', 'ASC');
        return $this->db_lama->get('insera')->result();
    }

    public function get_closed_export_tickets_by_category($category, $resolve_date_from = '', $resolve_date_to = '') {
        $this->db_lama->select('ticket_id, service_no, rk_information, pipe_name, work_zone, customer_type, reported_date, resolve_date, ticket_status, ttr_customer, summary');
        $this->db_lama->from('insera');
        $this->db_lama->where('scrape_category', $category);
        $this->db_lama->where_not_in('ticket_status', $this->open_statuses);
        $this->_apply_workzone_filter();

        if (!empty($resolve_date_from)) {
            $this->db_lama->where('resolve_date >=', $resolve_date_from . ' 00:00:00');
        }
        if (!empty($resolve_date_to)) {
            $this->db_lama->where('resolve_date <=', $resolve_date_to . ' 23:59:59');
        }

        $this->db_lama->order_by('resolve_date', 'ASC');
        $this->db_lama->order_by('reported_date', 'ASC');
        return $this->db_lama->get()->result_array();
    }

    public function get_last_update() {
        $row = $this->db_lama->select('scraped_at')
                             ->order_by('scraped_at', 'DESC')
                             ->limit(1)
                             ->get('insera')
                             ->row();
        return $row ? $row->scraped_at : null;
    }

    public function get_pivot_pltsel_by_cust_group($cust_group = 'HVC_DIAMOND') {
        $aging_expr = "TIMESTAMPDIFF(HOUR, reported_date, NOW())";

        // Build customer_type condition per group
        if ($cust_group === 'REGULER / BLANK') {
            $cust_condition = "(customer_type = 'REGULER' OR customer_type = '' OR customer_type IS NULL)";
        } else {
            $safe = $this->db_lama->escape_str($cust_group);
            $cust_condition = "customer_type = '$safe'";
        }

        $status_list = "'" . implode("','", $this->open_statuses) . "'";

        $sql = "SELECT work_zone,
                   CASE 
                       WHEN work_zone IN ('NNK', 'SNY', 'MLN', 'TPE') THEN 'Nunukan'
                       WHEN work_zone IN ('JWT', 'TAJ', 'TRK') THEN 'Tarakan'
                       WHEN work_zone IN ('TSL', 'TLA', 'TRD', 'LNN', 'TBY') THEN 'Tanjung Redeb'
                       ELSE 'Other'
                   END AS service_area,
                   CASE
                       WHEN work_zone IN ('NNK', 'SNY') THEN 'Nunukan'
                       WHEN work_zone IN ('MLN', 'TPE') THEN 'Malinau'
                       WHEN work_zone IN ('JWT', 'TAJ') THEN 'Tarakan 1'
                       WHEN work_zone IN ('TRK') THEN 'Tarakan 2'
                       WHEN work_zone IN ('TSL', 'TLA') THEN 'Tanjung Selor'
                       WHEN work_zone IN ('TRD', 'LNN', 'TBY') THEN 'Tanjung Redeb'
                       ELSE 'Other'
                   END AS sektor,
                   SUM(CASE WHEN $aging_expr < 1 THEN 1 ELSE 0 END) AS `< 1 jam`,
                   SUM(CASE WHEN $aging_expr >= 1 AND $aging_expr < 2 THEN 1 ELSE 0 END) AS `1-2 jam`,
                   SUM(CASE WHEN $aging_expr >= 2 AND $aging_expr < 3 THEN 1 ELSE 0 END) AS `2-3 jam`,
                   SUM(CASE WHEN $aging_expr >= 3 AND $aging_expr < 6 THEN 1 ELSE 0 END) AS `3-6 jam`,
                   SUM(CASE WHEN $aging_expr >= 6 AND $aging_expr < 12 THEN 1 ELSE 0 END) AS `6-12 jam`,
                   SUM(CASE WHEN $aging_expr >= 12 AND $aging_expr < 36 THEN 1 ELSE 0 END) AS `12-36 jam`,
                   SUM(CASE WHEN $aging_expr >= 36 AND $aging_expr < 72 THEN 1 ELSE 0 END) AS `36-72 jam`,
                   SUM(CASE WHEN $aging_expr >= 72 THEN 1 ELSE 0 END) AS `> 72 jam`
                FROM insera
                WHERE scrape_category = 'PL-TSEL'
                AND ticket_status IN ($status_list)
                AND $cust_condition";

        // Workzone filter for sectoral users
        $workzone_group = $this->session->userdata('workzone');
        if (!$this->session->userdata('is_superadmin') && $workzone_group) {
            $mapping = array(
                '1' => "'TRK', 'TAJ', 'JWT'",
                '2' => "'MLN', 'TPE', 'NNK', 'SNY'",
                '3' => "'TRD', 'TBY', 'LNN', 'TSL', 'TLA'",
                '4' => "'MLN', 'TPE'",
                '5' => "'NNK', 'SNY'",
                '6' => "'TSL', 'TLA'",
                '7' => "'TRD', 'TBY', 'LNN'"
            );
            if (isset($mapping[$workzone_group])) {
                $sql .= " AND work_zone IN (" . $mapping[$workzone_group] . ")";
            }
        }

        $sql .= " GROUP BY service_area, sektor, work_zone ORDER BY service_area, sektor, work_zone";

        return $this->db_lama->query($sql)->result_array();
    }
    public function get_pivot_by_customer_type($category = 'PL-TSEL', $status_type = 'OPEN') {
        if ($status_type === 'OPEN') {
            $aging_expr = "TIMESTAMPDIFF(HOUR, reported_date, NOW())";
        } else {
            $aging_expr = "TIMESTAMPDIFF(HOUR, reported_date, resolve_date)";
        }

        $sql = "SELECT 
                   CASE 
                       WHEN customer_type = 'HVC_DIAMOND' THEN 'HVC_DIAMOND'
                       WHEN customer_type = 'HVC_PLATINUM' THEN 'HVC_PLATINUM'
                       WHEN customer_type = 'HVC_GOLD' THEN 'HVC_GOLD'
                       ELSE 'REGULER / BLANK'
                   END AS display_cust_type,
                   SUM(CASE WHEN $aging_expr < 1 THEN 1 ELSE 0 END) AS `< 1 jam`,
                   SUM(CASE WHEN $aging_expr >= 1 AND $aging_expr < 2 THEN 1 ELSE 0 END) AS `1-2 jam`,
                   SUM(CASE WHEN $aging_expr >= 2 AND $aging_expr < 3 THEN 1 ELSE 0 END) AS `2-3 jam`,
                   SUM(CASE WHEN $aging_expr >= 3 AND $aging_expr < 6 THEN 1 ELSE 0 END) AS `3-6 jam`,
                   SUM(CASE WHEN $aging_expr >= 6 AND $aging_expr < 12 THEN 1 ELSE 0 END) AS `6-12 jam`,
                   SUM(CASE WHEN $aging_expr >= 12 AND $aging_expr < 36 THEN 1 ELSE 0 END) AS `12-36 jam`,
                   SUM(CASE WHEN $aging_expr >= 36 AND $aging_expr < 72 THEN 1 ELSE 0 END) AS `36-72 jam`,
                   SUM(CASE WHEN $aging_expr >= 72 THEN 1 ELSE 0 END) AS `> 72 jam`
                FROM insera
                WHERE scrape_category = ?
                AND ticket_status IN ('NEW', 'DRAFT', 'ANALYSIS', 'PENDING', 'BACKEND') ";

        // Workzone filter
        $workzone_group = $this->session->userdata('workzone');
        if (!$this->session->userdata('is_superadmin') && $workzone_group) {
            $mapping = array(
                '1' => "'TRK', 'TAJ', 'JWT'",
                '2' => "'MLN', 'TPE', 'NNK', 'SNY'",
                '3' => "'TRD', 'TBY', 'LNN', 'TSL', 'TLA'",
                '4' => "'MLN', 'TPE'",
                '5' => "'NNK', 'SNY'",
                '6' => "'TSL', 'TLA'",
                '7' => "'TRD', 'TBY', 'LNN'"
            );
            if (isset($mapping[$workzone_group])) {
                $sql .= " AND work_zone IN (" . $mapping[$workzone_group] . ")";
            }
        }

        $sql .= " GROUP BY display_cust_type 
                  ORDER BY FIELD(display_cust_type, 'HVC_DIAMOND', 'HVC_PLATINUM', 'HVC_GOLD', 'REGULER / BLANK')";

        return $this->db_lama->query($sql, array($category))->result_array();
    }
}
