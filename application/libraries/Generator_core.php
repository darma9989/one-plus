<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generator_core {
    
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    protected function _get_pk_name($fields) {
        if (!empty($fields)) {
            foreach ($fields as $f) {
                if (isset($f->primary_key) && $f->primary_key == 1) {
                    return $f->name;
                }
            }
            foreach ($fields as $f) {
                if (strtolower($f->name) === 'id') return $f->name;
            }
            return $fields[0]->name; // Fallback ke kolom pertama jika tidak ditemukan
        }
        return 'id';
    }

    public function generate_model($table, $module_upper, $module_lower, $fields, $enable_excel = FALSE, $db_group = 'default') {
        $pk_name = $this->_get_pk_name($fields);
        
        $str = "<?php\n";
        $str .= "defined('BASEPATH') OR exit('No direct script access allowed');\n\n";
        $str .= "class {$module_upper}_model extends CI_Model {\n\n";

        $str .= "    public function get_all() {\n";
        $str .= "        \$this->db->where('deleted_at IS NULL');\n";
        $str .= "        return \$this->db->get('{$table}')->result_array();\n";
        $str .= "    }\n\n";

        $str .= "    public function get_deleted() {\n";
        $str .= "        \$this->db->where('deleted_at IS NOT NULL');\n";
        $str .= "        \$this->db->order_by('deleted_at', 'DESC');\n";
        $str .= "        return \$this->db->get('{$table}')->result_array();\n";
        $str .= "    }\n\n";

        $str .= "    public function get_{$module_lower}(\$id) {\n";
        $str .= "        \$this->db->where('{$pk_name}', \$id);\n";
        $str .= "        \$this->db->where('deleted_at IS NULL');\n";
        $str .= "        return \$this->db->get('{$table}')->row_array();\n";
        $str .= "    }\n\n";

        $str .= "    public function get_{$module_lower}_deleted(\$id) {\n";
        $str .= "        \$this->db->where('{$pk_name}', \$id);\n";
        $str .= "        return \$this->db->get('{$table}')->row_array();\n";
        $str .= "    }\n\n";

        $str .= "    public function insert(\$data) {\n";
        $str .= "        \$data['created_at'] = date('Y-m-d H:i:s');\n";
        $str .= "        \$result = \$this->db->insert('{$table}', \$data);\n";
        $str .= "        if (\$result) {\n";
        $str .= "            \$insert_id = \$this->db->insert_id();\n";
        $str .= "            \$this->load->model('Log_model');\n";
        $str .= "            \$this->Log_model->write(array(\n";
        $str .= "                'module'    => 'MASTER DATA',\n";
        $str .= "                'sub_module'=> '" . strtoupper(str_replace('_', ' ', $module_upper)) . "',\n";
        $str .= "                'item_id'   => \$insert_id,\n";
        $str .= "                'item_name' => json_encode(\$data),\n";
        $str .= "                'action'    => 'INSERT'\n";
        $str .= "            ));\n";
        $str .= "        }\n";
        $str .= "        return \$result;\n";
        $str .= "    }\n\n";

        $str .= "    public function update(\$id, \$data) {\n";
        $str .= "        \$old_data = \$this->get_{$module_lower}(\$id);\n";
        $str .= "        if (!\$old_data) return FALSE;\n";
        $str .= "        \$data['updated_at'] = date('Y-m-d H:i:s');\n";
        $str .= "        \$this->db->where('{$pk_name}', \$id);\n";
        $str .= "        \$result = \$this->db->update('{$table}', \$data);\n";
        $str .= "        if (\$result) {\n";
        $str .= "            \$this->load->model('Log_model');\n";
        $str .= "            \$this->Log_model->write(array(\n";
        $str .= "                'module'    => 'MASTER DATA',\n";
        $str .= "                'sub_module'=> '" . strtoupper(str_replace('_', ' ', $module_upper)) . "',\n";
        $str .= "                'item_id'   => \$id,\n";
        $str .= "                'item_name' => json_encode(\$data),\n";
        $str .= "                'action'    => 'UPDATE',\n";
        $str .= "                'before'    => \$old_data,\n";
        $str .= "                'after'     => \$data\n";
        $str .= "            ));\n";
        $str .= "        }\n";
        $str .= "        return \$result;\n";
        $str .= "    }\n\n";

        $str .= "    public function delete(\$id) {\n";
        $str .= "        \$this->db->where('{$pk_name}', \$id);\n";
        $str .= "        \$result = \$this->db->update('{$table}', array('deleted_at' => date('Y-m-d H:i:s')));\n";
        $str .= "        if (\$result) {\n";
        $str .= "            \$this->load->model('Log_model');\n";
        $str .= "            \$this->Log_model->write(array(\n";
        $str .= "                'module'    => 'MASTER DATA',\n";
        $str .= "                'sub_module'=> '" . strtoupper(str_replace('_', ' ', $module_upper)) . "',\n";
        $str .= "                'item_id'   => \$id,\n";
        $str .= "                'item_name' => 'Soft Deleted',\n";
        $str .= "                'action'    => 'DELETE'\n";
        $str .= "            ));\n";
        $str .= "        }\n";
        $str .= "        return \$result;\n";
        $str .= "    }\n\n";

        $str .= "    public function restore(\$id) {\n";
        $str .= "        \$this->db->where('{$pk_name}', \$id);\n";
        $str .= "        return \$this->db->update('{$table}', array('deleted_at' => NULL));\n";
        $str .= "    }\n\n";

        $str .= "    public function hard_delete(\$id) {\n";
        $str .= "        \$this->db->where('{$pk_name}', \$id);\n";
        $str .= "        return \$this->db->delete('{$table}');\n";
        $str .= "    }\n\n";

        if ($enable_excel) {
            $str .= "    public function insert_batch(\$data) {\n";
            $str .= "        \$result = \$this->db->insert_batch('{$table}', \$data);\n";
            $str .= "        if (\$result) {\n";
            $str .= "            \$this->load->model('Log_model');\n";
            $str .= "            \$this->Log_model->write(array(\n";
            $str .= "                'module'    => 'MASTER DATA',\n";
            $str .= "                'sub_module'=> '" . strtoupper(str_replace('_', ' ', $module_upper)) . "',\n";
            $str .= "                'action'    => 'BATCH_INSERT',\n";
            $str .= "                'item_name' => count(\$data) . ' Data Imported via Excel'\n";
            $str .= "            ));\n";
            $str .= "        }\n";
            $str .= "        return \$result;\n";
            $str .= "    }\n";
        }
        
        
        if ($db_group != 'default') {
            $str = str_replace("\$this->db->", "\$this->db_{$db_group}->", $str);
            $construct = "    protected \$db_{$db_group};\n\n";
            $construct .= "    public function __construct() {\n";
            $construct .= "        parent::__construct();\n";
            $construct .= "        \$this->db_{$db_group} = \$this->load->database('{$db_group}', TRUE);\n";
            $construct .= "    }\n\n";
            $str = str_replace("class {$module_upper}_model extends CI_Model {\n\n", "class {$module_upper}_model extends CI_Model {\n\n" . $construct, $str);
        }

        $str .= "}\n";
        return $str;
    }

    public function generate_controller($table, $module_upper, $module_lower, $fields, $enable_excel = FALSE) {
        $pk_name = $this->_get_pk_name($fields);

        $str = "<?php\n";
        $str .= "defined('BASEPATH') OR exit('No direct script access allowed');\n\n";
        $str .= "class {$module_upper} extends Admin_Controller {\n\n";
        $str .= "    public function __construct() {\n";
        $str .= "        parent::__construct();\n";
        $str .= "        \$this->load->model('{$module_upper}_model');\n";
        $str .= "    }\n\n";

        $str .= "    public function index() {\n";
        $str .= "        \$this->data['title'] = 'Manajemen {$module_upper}';\n";
        $str .= "        \$this->data['records'] = \$this->{$module_upper}_model->get_all();\n";
        $str .= "        \$this->template->load('admin/{$module_lower}/index', \$this->data);\n";
        $str .= "    }\n\n";

        $str .= "    public function get_data() {\n";
        $str .= "        \$id = \$this->input->post('id', TRUE);\n";
        $str .= "        \$data = \$this->{$module_upper}_model->get_{$module_lower}(\$id);\n";
        $str .= "        echo json_encode(\$data);\n";
        $str .= "    }\n\n";

        $str .= "    public function save() {\n";
        $str .= "        \$id = \$this->input->post('id', TRUE);\n";
        foreach ($fields as $f) {
            if (!in_array($f->name, [$pk_name, 'created_at', 'updated_at', 'deleted_at']) && $f->name != 'id') {
                $str .= "        \$this->form_validation->set_rules('{$f->name}', '" . ucfirst(str_replace('_', ' ', $f->name)) . "', 'required|trim');\n";
            }
        }
        $str .= "\n        if (\$this->form_validation->run() == FALSE) {\n";
        $str .= "            echo json_encode(['status' => 'error', 'message' => validation_errors()]);\n";
        $str .= "        } else {\n";
        $str .= "            \$data = array(\n";
        foreach ($fields as $f) {
            if (!in_array($f->name, [$pk_name, 'created_at', 'updated_at', 'deleted_at']) && $f->name != 'id') {
                if (stripos($f->name, 'deskripsi') !== false || stripos($f->name, 'keterangan') !== false) {
                    $str .= "                '{$f->name}' => ucwords(strtolower(\$this->input->post('{$f->name}', TRUE))),\n";
                } elseif (stripos($f->name, 'email') !== false) {
                    $str .= "                '{$f->name}' => strtolower(\$this->input->post('{$f->name}', TRUE)),\n";
                } elseif (stripos($f->name, 'telp') !== false || stripos($f->name, 'telepon') !== false || stripos($f->name, 'phone') !== false || stripos($f->name, 'nohp') !== false) {
                    $str .= "                '{$f->name}' => preg_replace('/[^0-9\+\-\(\)\s]/', '', \$this->input->post('{$f->name}', TRUE)),\n";
                } else {
                    $str .= "                '{$f->name}' => strtoupper(\$this->input->post('{$f->name}', TRUE)),\n";
                }
            }
        }
        $str .= "            );\n\n";
        $str .= "            if (\$id) {\n";
        $str .= "                \$res = \$this->{$module_upper}_model->update(\$id, \$data);\n";
        $str .= "                \$msg = 'Data berhasil diperbarui.';\n";
        $str .= "            } else {\n";
        $str .= "                \$res = \$this->{$module_upper}_model->insert(\$data);\n";
        $str .= "                \$msg = 'Data berhasil ditambahkan.';\n";
        $str .= "            }\n\n";
        $str .= "            if (\$res) {\n";
        $str .= "                echo json_encode(['status' => 'success', 'message' => \$msg]);\n";
        $str .= "            } else {\n";
        $str .= "                echo json_encode(['status' => 'error', 'message' => 'Gagal memproses data.']);\n";
        $str .= "            }\n";
        $str .= "        }\n";
        $str .= "    }\n\n";

        $str .= "    public function delete() {\n";
        $str .= "        \$id = \$this->input->post('id', TRUE);\n";
        $str .= "        if (\$this->{$module_upper}_model->delete(\$id)) {\n";
        $str .= "            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus.']);\n";
        $str .= "        } else {\n";
        $str .= "            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data.']);\n";
        $str .= "        }\n";
        $str .= "    }\n\n";

        if ($enable_excel) {
            $str .= "    public function import_excel() {\n";
            $str .= "        \$data_raw = \$this->input->post('data', TRUE);\n";
            $str .= "        if (empty(\$data_raw)) {\n";
            $str .= "            echo json_encode(['status' => 'error', 'message' => 'Tidak ada data untuk diimport.']);\n";
            $str .= "            return;\n";
            $str .= "        }\n\n";
            $str .= "        \$data = [];\n";
            $str .= "        foreach (\$data_raw as \$row) {\n";
            $str .= "            \$item = [\n";
            $str .= "                'created_at' => date('Y-m-d H:i:s')\n";
            $str .= "            ];\n";
            foreach ($fields as $f) {
                if (!in_array($f->name, [$pk_name, 'created_at', 'updated_at', 'deleted_at']) && $f->name != 'id') {
                    if (stripos($f->name, 'deskripsi') !== false || stripos($f->name, 'keterangan') !== false) {
                        $str .= "            \$item['{$f->name}'] = ucwords(strtolower(isset(\$row['{$f->name}']) ? \$row['{$f->name}'] : ''));\n";
                    } elseif (stripos($f->name, 'email') !== false) {
                        $str .= "            \$item['{$f->name}'] = strtolower(isset(\$row['{$f->name}']) ? \$row['{$f->name}'] : '');\n";
                    } elseif (stripos($f->name, 'telp') !== false || stripos($f->name, 'telepon') !== false || stripos($f->name, 'phone') !== false || stripos($f->name, 'nohp') !== false) {
                        $str .= "            \$item['{$f->name}'] = preg_replace('/[^0-9\+\-\(\)\s]/', '', isset(\$row['{$f->name}']) ? \$row['{$f->name}'] : '');\n";
                    } else {
                        $str .= "            \$item['{$f->name}'] = strtoupper(isset(\$row['{$f->name}']) ? \$row['{$f->name}'] : '');\n";
                    }
                }
            }
            $str .= "            \$data[] = \$item;\n";
            $str .= "        }\n\n";
            $str .= "        if (\$this->{$module_upper}_model->insert_batch(\$data)) {\n";
            $str .= "            echo json_encode(['status' => 'success', 'message' => count(\$data) . ' Data berhasil diimport.']);\n";
            $str .= "        } else {\n";
            $str .= "            echo json_encode(['status' => 'error', 'message' => 'Gagal mengimport data balance.']);\n";
            $str .= "        }\n";
            $str .= "    }\n";
        }
        $str .= "}\n";
        return $str;
    }

    public function generate_view($table, $module_upper, $module_lower, $fields, $enable_excel = FALSE) {
        $pk_name = $this->_get_pk_name($fields);
        $str = "<!-- Data Table Box -->\n";
        $str .= "<div class=\"box box-primary border-0 shadow-sm\">\n";
        $str .= "    <div class=\"box-header with-border\" style=\"padding: 15px 20px;\">\n";
        $str .= "        <h3 class=\"box-title\" style=\"font-weight: 700;\"><i class=\"fa fa-list text-primary\"></i> Data {$module_upper}</h3>\n";
        $str .= "        <div class=\"pull-right\">\n";
        if ($enable_excel) {
            $str .= "            <div class=\"btn-group\" style=\"margin-right: 5px;\">\n";
            $str .= "                <button type=\"button\" class=\"btn btn-success btn-sm btn-flat dropdown-toggle\" data-toggle=\"dropdown\">\n";
            $str .= "                    <i class=\"fa fa-wrench\"></i> Tools <span class=\"caret\"></span>\n";
            $str .= "                </button>\n";
            $str .= "                <ul class=\"dropdown-menu pull-right\" role=\"menu\">\n";
            $str .= "                    <li><a href=\"javascript:void(0)\" onclick=\"showImportModal()\"><i class=\"fa fa-upload\"></i> Import Excel</a></li>\n";
            $str .= "                    <li><a href=\"javascript:void(0)\" onclick=\"exportExcel()\"><i class=\"fa fa-download\"></i> Export Excel</a></li>\n";
            $str .= "                </ul>\n";
            $str .= "            </div>\n";
        }
        $str .= "            <button class=\"btn btn-primary btn-sm btn-flat\" onclick=\"showAddModal()\"><i class=\"fa fa-plus\"></i> Tambah Data Baru</button>\n";
        $str .= "        </div>\n";
        $str .= "    </div>\n";
        $str .= "    <div class=\"box-body\" style=\"padding: 20px;\">\n";
        $str .= "        <div class=\"table-responsive\">\n";
        $str .= "            <table class=\"table table-hover table-striped\" id=\"tblData\" style=\"width: 100%;\">\n";
        $str .= "                <thead>\n";
        $str .= "                    <tr class=\"bg-gray-light\">\n";
        $str .= "                        <th width=\"30\" class=\"text-center\">No</th>\n";
        foreach ($fields as $f) {
            if (!in_array($f->name, [$pk_name, 'created_at', 'updated_at', 'deleted_at']) && $f->name != 'id') {
                $str .= "                        <th>" . ucfirst(str_replace('_', ' ', $f->name)) . "</th>\n";
            }
        }
        $str .= "                        <th width=\"100\" class=\"text-center\">Aksi</th>\n";
        $str .= "                    </tr>\n";
        $str .= "                </thead>\n";
        $str .= "                <tbody>\n";
        $str .= "                    <?php if (isset(\$records)): \$no=1; foreach (\$records as \$r): ?>\n";
        $str .= "                    <tr>\n";
        $str .= "                        <td class=\"text-center align-middle\"><?php echo \$no++; ?></td>\n";
        foreach ($fields as $f) {
            if (!in_array($f->name, [$pk_name, 'created_at', 'updated_at', 'deleted_at']) && $f->name != 'id') {
                $str .= "                        <td class=\"align-middle\"><?php echo htmlspecialchars(\$r['{$f->name}']); ?></td>\n";
            }
        }
        $str .= "                        <td class=\"text-center align-middle\">\n";
        $str .= "                            <button class=\"btn btn-sm btn-flat btn-default\" onclick=\"editData(<?php echo \$r['{$pk_name}']; ?>)\" title=\"Edit\"><i class=\"fa fa-pencil text-warning\"></i></button>\n";
        $str .= "                            <button class=\"btn btn-sm btn-flat btn-default\" onclick=\"deleteData(<?php echo \$r['{$pk_name}']; ?>)\" title=\"Hapus\"><i class=\"fa fa-trash text-danger\"></i></button>\n";
        $str .= "                        </td>\n";
        $str .= "                    </tr>\n";
        $str .= "                    <?php endforeach; endif; ?>\n";
        $str .= "                </tbody>\n";
        $str .= "            </table>\n";
        $str .= "        </div>\n";
        $str .= "    </div>\n";
        $str .= "</div>\n\n";

        $str .= "<!-- Modal Form -->\n";
        $str .= "<div class=\"modal fade\" id=\"modalForm\" data-backdrop=\"static\" data-keyboard=\"false\">\n";
        $str .= "    <div class=\"modal-dialog\">\n";
        $str .= "        <div class=\"modal-content border-0\">\n";
        $str .= "            <div class=\"modal-header bg-primary shadow-sm\" style=\"border:0\">\n";
        $str .= "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" style=\"color:#fff;\">&times;</button>\n";
        $str .= "                <h4 class=\"modal-title\" id=\"modalTitle\" style=\"color:#fff; font-weight: 600;\">Form {$module_upper}</h4>\n";
        $str .= "            </div>\n";
        $str .= "            <form id=\"formData\">\n";
        $str .= "                <div class=\"modal-body\" style=\"padding: 25px;\">\n";
        $str .= "                    <input type=\"hidden\" name=\"id\" id=\"dataId\">\n";
        foreach ($fields as $f) {
            if (!in_array($f->name, [$pk_name, 'created_at', 'updated_at', 'deleted_at']) && $f->name != 'id') {
                $str .= "                    <div class=\"form-group\">\n";
                $str .= "                        <label>" . ucfirst(str_replace('_', ' ', $f->name)) . " <span class=\"text-danger\">*</span></label>\n";
                if (stripos($f->name, 'deskripsi') !== false || stripos($f->name, 'keterangan') !== false) {
                     $str .= "                        <textarea name=\"{$f->name}\" id=\"{$f->name}\" class=\"form-control\" required></textarea>\n";
                } elseif (stripos($f->name, 'email') !== false) {
                     $str .= "                        <input type=\"email\" name=\"{$f->name}\" id=\"{$f->name}\" class=\"form-control\" required>\n";
                } elseif (stripos($f->name, 'telp') !== false || stripos($f->name, 'telepon') !== false || stripos($f->name, 'phone') !== false || stripos($f->name, 'nohp') !== false) {
                     $str .= "                        <input type=\"tel\" name=\"{$f->name}\" id=\"{$f->name}\" class=\"form-control\" required>\n";
                } else {
                     $str .= "                        <input type=\"text\" name=\"{$f->name}\" id=\"{$f->name}\" class=\"form-control\" required>\n";
                }
                $str .= "                    </div>\n";
            }
        }
        $str .= "                </div>\n";
        $str .= "                <div class=\"modal-footer bg-gray-light\">\n";
        $str .= "                    <button type=\"button\" class=\"btn btn-default btn-flat\" data-dismiss=\"modal\">Batal</button>\n";
        $str .= "                    <button type=\"submit\" class=\"btn btn-primary btn-flat\"><i class=\"fa fa-save\"></i> Simpan</button>\n";
        $str .= "                </div>\n";
        $str .= "            </form>\n";
        $str .= "        </div>\n";
        $str .= "    </div>\n";
        $str .= "</div>\n\n";

        if ($enable_excel) {
            $str .= "<!-- Modal Import Excel -->\n";
            $str .= "<div class=\"modal fade\" id=\"modalImport\" data-backdrop=\"static\" data-keyboard=\"false\">\n";
            $str .= "    <div class=\"modal-dialog modal-lg\">\n";
            $str .= "        <div class=\"modal-content border-0\">\n";
            $str .= "            <div class=\"modal-header bg-green shadow-sm\" style=\"border:0\">\n";
            $str .= "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" style=\"color:#fff;\">&times;</button>\n";
            $str .= "                <h4 class=\"modal-title\" style=\"color:#fff; font-weight: 600;\"><i class=\"fa fa-file-excel-o\"></i> Import Data {$module_upper}</h4>\n";
            $str .= "            </div>\n";
            $str .= "            <div class=\"modal-body\" style=\"padding: 20px;\">\n";
            $str .= "                <div class=\"form-group\" id=\"importStep1\">\n";
            $str .= "                    <label>Pilih File Excel (.xlsx / .xls)</label>\n";
            $str .= "                    <input type=\"file\" id=\"excelFile\" class=\"form-control\" accept=\".xlsx, .xls\">\n";
            $str .= "                    <p class=\"help-block\">Gunakan baris pertama sebagai Header kolom.</p>\n";
            $str .= "                </div>\n";
            $str .= "                <div id=\"importStep2\" style=\"display:none;\">\n";
            $str .= "                    <label>Pratinjau Data (Review & Verifikasi)</label>\n";
            $str .= "                    <div class=\"table-responsive\" style=\"max-height: 400px;\">\n";
            $str .= "                        <table class=\"table table-bordered table-condensed table-striped\" id=\"tblPreview\">\n";
            $str .= "                            <thead><tr class=\"bg-gray-light\"></tr></thead>\n";
            $str .= "                            <tbody></tbody>\n";
            $str .= "                        </table>\n";
            $str .= "                    </div>\n";
            $str .= "                </div>\n";
            $str .= "            </div>\n";
            $str .= "            <div class=\"modal-footer bg-gray-light\">\n";
            $str .= "                <button type=\"button\" class=\"btn btn-default btn-flat\" data-dismiss=\"modal\">Batal</button>\n";
            $str .= "                <button type=\"button\" class=\"btn btn-success btn-flat\" id=\"btnProcessImport\" style=\"display:none;\"><i class=\"fa fa-check\"></i> Simpan Semua Data</button>\n";
            $str .= "            </div>\n";
            $str .= "        </div>\n";
            $str .= "    </div>\n";
            $str .= "</div>\n\n";
        }

        $str .= "<script src=\"<?php echo base_url('assets/starter_kit/vendor/xlsx.full.min.js'); ?>\"></script>\n";
        $str .= "<script>\n";
        $str .= "var tblData;\n";
        $str .= "$(function(){\n";
        $str .= "    tblData = $('#tblData').DataTable({\n";
        $str .= "        \"dom\": '<\"row\"<\"col-sm-6\"l><\"col-sm-6\"f>>rt<\"row\"<\"col-sm-5\"i><\"col-sm-7\"p>>',\n";
        $str .= "        \"language\": { \"search\": \"Cari:\" }\n";
        $str .= "    });\n";
        $str .= "});\n\n";

        $str .= "function showAddModal() {\n";
        $str .= "    $('#modalTitle').text('Tambah Data {$module_upper}');\n";
        $str .= "    $('#formData')[0].reset();\n";
        $str .= "    $('#dataId').val('');\n";
        $str .= "    $('#modalForm').modal('show');\n";
        $str .= "}\n\n";

        $str .= "function editData(id) {\n";
        $str .= "    $.post(BASE_URL + 'admin/{$module_lower}/get_data', {id: id}, function(res) {\n";
        $str .= "        var d = JSON.parse(res);\n";
        $str .= "        $('#modalTitle').text('Edit Data {$module_upper}');\n";
        $str .= "        $('#dataId').val(d.{$pk_name});\n";
        foreach ($fields as $f) {
            if (!in_array($f->name, [$pk_name, 'created_at', 'updated_at', 'deleted_at']) && $f->name != 'id') {
                $str .= "        $('#{$f->name}').val(d.{$f->name});\n";
            }
        }
        $str .= "        $('#modalForm').modal('show');\n";
        $str .= "    });\n";
        $str .= "}\n\n";

        $str .= "$('#formData').submit(function(e) {\n";
        $str .= "    e.preventDefault();\n";
        $str .= "    App.showLoader();\n";
        $str .= "    $.post(BASE_URL + 'admin/{$module_lower}/save', $(this).serialize(), function(res) {\n";
        $str .= "        App.hideLoader();\n";
        $str .= "        var r = JSON.parse(res);\n";
        $str .= "        if (r.status == 'success') {\n";
        $str .= "            $('#modalForm').modal('hide');\n";
        $str .= "            App.toast(r.message, 'success');\n";
        $str .= "            setTimeout(function() { location.reload(); }, 1500);\n";
        $str .= "        } else {\n";
        $str .= "            App.alert('Error', r.message, 'error');\n";
        $str .= "        }\n";
        $str .= "    }).fail(function() {\n";
        $str .= "        App.hideLoader();\n";
        $str .= "        App.alert('Error', 'Koneksi ke server terputus.', 'error');\n";
        $str .= "    });\n";
        $str .= "});\n\n";

        $str .= "function deleteData(id) {\n";
        $str .= "    App.confirm('Hapus Data?', 'Konfirmasi penghapusan data ini. Data akan dipindahkan ke Recycle Bin.', function() {\n";
        $str .= "        $.post(BASE_URL + 'admin/{$module_lower}/delete', {id: id}, function(res) {\n";
        $str .= "            var r = JSON.parse(res);\n";
        $str .= "            if (r.status == 'success') {\n";
        $str .= "                App.toast(r.message, 'success');\n";
        $str .= "                setTimeout(function() { location.reload(); }, 1500);\n";
        $str .= "            } else {\n";
        $str .= "                App.alert('Error', r.message, 'error');\n";
        $str .= "            }\n";
        $str .= "        });\n";
        $str .= "    });\n";
        $str .= "}\n\n";

        if ($enable_excel) {
            $str .= "var importedData = [];\n";
            $str .= "function showImportModal() {\n";
            $str .= "    $('#modalImport').modal('show');\n";
            $str .= "    $('#importStep1').show();\n";
            $str .= "    $('#importStep2').hide();\n";
            $str .= "    $('#btnProcessImport').hide();\n";
            $str .= "    $('#excelFile').val('');\n";
            $str .= "}\n\n";

            $str .= "$('#excelFile').change(function(e) {\n";
            $str .= "    var reader = new FileReader();\n";
            $str .= "    reader.readAsArrayBuffer(e.target.files[0]);\n";
            $str .= "    reader.onload = function(e) {\n";
            $str .= "        var data = new Uint8Array(reader.result);\n";
            $str .= "        var workbook = XLSX.read(data, {type: 'array'});\n";
            $str .= "        var sheetName = workbook.SheetNames[0];\n";
            $str .= "        var sheet = workbook.Sheets[sheetName];\n";
            $str .= "        var json = XLSX.utils.sheet_to_json(sheet);\n";
            
            $str .= "        if (json.length > 0) {\n";
            $str .= "            importedData = json;\n";
            $str .= "            $('#importStep1').hide();\n";
            $str .= "            $('#importStep2').show();\n";
            $str .= "            $('#btnProcessImport').show();\n";
            
            $str .= "            var head = $('#tblPreview thead tr').empty();\n";
            $str .= "            var body = $('#tblPreview tbody').empty();\n";
            
            $str .= "            // Map headers\n";
            $str .= "            Object.keys(json[0]).forEach(k => head.append('<th>' + k + '</th>'));\n";
            
            $str .= "            // Show first 10 rows as preview\n";
            $str .= "            json.slice(0, 10).forEach(row => {\n";
            $str .= "                var tr = $('<tr>');\n";
            $str .= "                Object.values(row).forEach(v => tr.append('<td>' + v + '</td>'));\n";
            $str .= "                body.append(tr);\n";
            $str .= "            });\n";
            $str .= "            if (json.length > 10) body.append('<tr><td colspan=\"99\" class=\"text-center text-muted italic\">... ' + (json.length - 10) + ' data lainnya tidak ditampilkan di pratinjau ...</td></tr>');\n";
            $str .= "        }\n";
            $str .= "    }\n";
            $str .= "});\n\n";

            $str .= "$('#btnProcessImport').click(function() {\n";
            $str .= "    App.confirm('Simpan Data Import?', 'Anda akan menyimpan ' + importedData.length + ' data ke database.', function() {\n";
            $str .= "        App.showLoader();\n";
            $str .= "        $.post(BASE_URL + 'admin/{$module_lower}/import_excel', {data: importedData}, function(res) {\n";
            $str .= "            App.hideLoader();\n";
            $str .= "            var r = JSON.parse(res);\n";
            $str .= "            if (r.status == 'success') {\n";
            $str .= "                $('#modalImport').modal('hide');\n";
            $str .= "                App.alert('Berhasil', r.message, 'success');\n";
            $str .= "                setTimeout(() => location.reload(), 1500);\n";
            $str .= "            } else {\n";
            $str .= "                App.alert('Gagal', r.message, 'error');\n";
            $str .= "            }\n";
            $str .= "        });\n";
            $str .= "    }, 'primary');\n";
            $str .= "});\n\n";

            $str .= "function exportExcel() {\n";
            $str .= "    var wb = XLSX.utils.book_new();\n";
            $str .= "    var ws_data = [];\n";
            $str .= "    var headers = [];\n";
            $str .= "    $('#tblData thead th').each(function(index) {\n";
            $str .= "        if (index < $('#tblData thead th').length - 1) headers.push($(this).text().trim());\n";
            $str .= "    });\n";
            $str .= "    ws_data.push(headers);\n";
            $str .= "    var filteredData = tblData.rows({ search: 'applied' }).data().toArray();\n";
            $str .= "    for (var i = 0; i < filteredData.length; i++) {\n";
            $str .= "        var rowData = [];\n";
            $str .= "        for (var j = 0; j < headers.length; j++) {\n";
            $str .= "            rowData.push($('<div>').html(filteredData[i][j]).text().trim());\n";
            $str .= "        }\n";
            $str .= "        ws_data.push(rowData);\n";
            $str .= "    }\n";
            $str .= "    var ws = XLSX.utils.aoa_to_sheet(ws_data);\n";
            $str .= "    XLSX.utils.book_append_sheet(wb, ws, 'Data {$module_upper}');\n";
            $str .= "    XLSX.writeFile(wb, 'Export_Data_{$module_upper}_' + new Date().getTime() + '.xlsx');\n";
            $str .= "}\n";
        }

        $str .= "</script>\n";

        return $str;
    }
}
