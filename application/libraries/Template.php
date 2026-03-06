<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Library — Theme Engine
 * Support AdminLTE 2 & AdminLTE 3 dengan toggle
 */
class Template {

    var $template_data = array();
    var $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Set variable untuk template
     */
    public function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    /**
     * Load template dengan theme engine
     * @param string $view - path view content
     * @param array $data - data untuk view
     * @param bool $return - return sebagai string atau langsung output
     */
    public function load($view = '', $data = array(), $return = FALSE) {
        // Load system settings
        $this->CI->load->model('Setting_model');
        $settings = $this->CI->Setting_model->get_all();

        // Inject semua settings ke template data
        foreach ($settings as $key => $value) {
            $this->set('sys_' . $key, $value);
        }

        // Tentukan theme aktif (Dipaksa ke AdminLTE 2 untuk konsistensi)
        $theme = 'adminlte2';
        $layout = isset($settings['sidebar_layout']) ? $settings['sidebar_layout'] : 'sidebar';

        $this->set('active_theme', $theme);
        $this->set('sidebar_layout', $layout);

        // Render content view
        $this->set('contents', $this->CI->load->view($view, $data, TRUE));

        // Load template berdasarkan theme
        $template_path = 'templates/' . $theme . '/template';
        return $this->CI->load->view($template_path, $this->template_data, $return);
    }
}
