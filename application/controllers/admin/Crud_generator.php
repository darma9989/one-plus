<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_generator extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Crud_generator_model');
        $this->load->library('Generator_core');
    }

    public function index() {
        $this->data['title'] = 'CRUD Generator (Enterprise)';
        $this->data['tables'] = $this->Crud_generator_model->get_tables();
        $this->data['parents'] = $this->Crud_generator_model->get_parents();
        $this->template->load('admin/crud_generator/index', $this->data);
    }

    public function get_tables_ajax() {
        $db_group = $this->input->post('db_group', TRUE);
        if (empty($db_group)) $db_group = 'default';
        $tables = $this->Crud_generator_model->get_tables($db_group);
        echo json_encode($tables);
    }

    public function generate() {
        $table_mode = $this->input->post('table_mode', TRUE);
        $module = $this->input->post('module_name', TRUE);
        
        if ($table_mode == 'new') {
            $table = $this->input->post('new_table_name', TRUE);
            $table = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $table));
            
            $f_names = $this->input->post('field_name');
            $f_types = $this->input->post('field_type');
            $f_lens = $this->input->post('field_length');
            $f_nulls = $this->input->post('field_null');
            
            if (empty($table) || empty($f_names)) {
                echo json_encode(['status' => 'error', 'message' => 'Nama Tabel dan Minimal 1 Field harus diisi untuk mode Baru.']);
                return;
            }

            $fields_raw = [];
            for($i = 0; $i < count($f_names); $i++) {
                if(!empty($f_names[$i])) {
                    $fields_raw[] = [
                        'name' => strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $f_names[$i])),
                        'type' => $f_types[$i],
                        'length' => $f_lens[$i],
                        'null' => $f_nulls[$i] == '1'
                    ];
                }
            }
            
            if(!$this->Crud_generator_model->create_table($table, $fields_raw)) {
                 echo json_encode(['status' => 'error', 'message' => 'Gagal membuat tabel Database. Pastikan tabel belum ada.']);
                 return;
            }
        } else {
            $table = $this->input->post('table_name', TRUE);
            if (empty($table)) {
                echo json_encode(['status' => 'error', 'message' => 'Tabel Database wajib dipilih.']);
                return;
            }
        }
        
        if (empty($module)) {
            echo json_encode(['status' => 'error', 'message' => 'Nama Modul wajib diisi.']);
            return;
        }

        $module_lower = strtolower(str_replace(' ', '_', $module));
        $module_upper = ucfirst($module_lower);
        
        $db_group = $this->input->post('db_group', TRUE);
        if (empty($db_group) || $table_mode == 'new') $db_group = 'default';

        $fields = $this->Crud_generator_model->get_fields($table, $db_group);
        if (empty($fields)) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengambil informasi kolom dari tabel (pastikan tabel ada di database sumber).']);
            return;
        }

        $generate_to_file = $this->input->post('generate_to_file') ? TRUE : FALSE;
        $enable_excel = $this->input->post('enable_excel') ? TRUE : FALSE;
        
        $controller_code = $this->generator_core->generate_controller($table, $module_upper, $module_lower, $fields, $enable_excel);
        $model_code = $this->generator_core->generate_model($table, $module_upper, $module_lower, $fields, $enable_excel, $db_group);
        $view_code = $this->generator_core->generate_view($table, $module_upper, $module_lower, $fields, $enable_excel);

        if ($generate_to_file) {
            $err = [];
            
            $view_dir = APPPATH . 'views/admin/' . $module_lower;
            if (!is_dir($view_dir)) {
                mkdir($view_dir, 0755, TRUE);
            }

            if(!file_put_contents(APPPATH.'models/'.$module_upper.'_model.php', $model_code)) $err[] = 'Gagal mem-build file Model';
            if(!file_put_contents(APPPATH.'controllers/admin/'.$module_upper.'.php', $controller_code)) $err[] = 'Gagal mem-build file Controller';
            if(!file_put_contents($view_dir.'/index.php', $view_code)) $err[] = 'Gagal mem-build file View';
            
            if (empty($err)) {
                
                // --- MENU REGISTRATION INJECTION ---
                $menu_mode = $this->input->post('menu_mode');
                $parent_id = NULL;

                if ($menu_mode == 'existing_parent') {
                    $parent_id = $this->input->post('parent_id');
                } else if ($menu_mode == 'new_parent') {
                    $new_parent_name = $this->input->post('new_parent_name');
                    $new_parent_icon = $this->input->post('new_parent_icon') ? $this->input->post('new_parent_icon') : 'fa-folder';
                    
                    if (!empty($new_parent_name)) {
                        $existing_parent = $this->db->get_where('menu', ['menu_name' => $new_parent_name, 'menu_link' => '#', 'parent_id' => NULL])->row();
                        if ($existing_parent) {
                            $parent_id = $existing_parent->id;
                        } else {
                            $this->db->insert('menu', [
                                'menu_name' => $new_parent_name,
                                'menu_icon' => $new_parent_icon,
                                'menu_link' => '#',
                                'parent_id' => NULL,
                                'menu_order'=> 99,
                                'menu_status'=> 1,
                                'created_at'=> date('Y-m-d H:i:s')
                            ]);
                            $parent_id = $this->db->insert_id();
                            $this->db->insert('role_permissions', ['role_id' => 1, 'menu_id' => $parent_id]);
                        }
                    }
                }

                $child_link = 'admin/' . $module_lower;
                $existing_child = $this->db->get_where('menu', ['menu_link' => $child_link])->row();

                if (!$existing_child) {
                    // Create the child menu
                    $this->db->insert('menu', [
                        'menu_name' => ucwords(str_replace('_', ' ', $module)),
                        'menu_icon' => 'fa-circle-o',
                        'menu_link' => $child_link,
                        'parent_id' => $parent_id,
                        'menu_order'=> 99,
                        'menu_status'=> 1,
                        'created_at'=> date('Y-m-d H:i:s')
                    ]);
                    
                    $new_menu_id = $this->db->insert_id();
                    
                    // Automatically grant access to Super Admin (Role 1)
                    $this->db->insert('role_permissions', ['role_id' => 1, 'menu_id' => $new_menu_id]);
                }

                echo json_encode(['status' => 'success', 'message' => "Proses Injeksi Core Berhasil! Modul {$module_upper} sudah terinstalasi / diperbarui."]);
            } else {
                echo json_encode(['status' => 'error', 'message' => implode(', ', $err)]);
            }
        } else {
            echo json_encode([
                'status' => 'success', 
                'message' => 'Simulasi Skrip Modul berhasil disusun sesuai Standar Enterprise.',
                'controller' => htmlspecialchars($controller_code, ENT_QUOTES, 'UTF-8'),
                'model' => htmlspecialchars($model_code, ENT_QUOTES, 'UTF-8'),
                'view' => htmlspecialchars($view_code, ENT_QUOTES, 'UTF-8')
            ]);
        }
    }
}
