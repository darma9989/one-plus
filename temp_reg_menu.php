<?php
define('BASEPATH', 'EXT');
require_once('index.php');
$CI =& get_instance();
$CI->load->database();

// 1. Insert Menu
$menu_data = array(
    'menu_name' => 'Recycle Bin',
    'menu_icon' => 'fa fa-trash-o',
    'menu_link' => 'admin/recycle_bin',
    'parent_id' => 9,
    'menu_order' => 3,
    'menu_status' => 1,
    'created_at' => date('Y-m-d H:i:s')
);
$CI->db->insert('menu', $menu_data);
$menu_id = $CI->db->insert_id();

// 2. Grant permission to Super Admin (role_id 1)
$CI->db->insert('role_permissions', array(
    'role_id' => 1,
    'menu_id' => $menu_id
));

echo "Success! Menu ID: $menu_id added and permitted for Super Admin.";
unlink(__FILE__);
