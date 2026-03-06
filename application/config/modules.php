<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modules Configuration
 * Enable/disable module tanpa hapus kode
 * Key = nama folder controller, value = aktif/tidak
 */
$config['modules'] = array(
    'dashboard'     => TRUE,
    'users'         => TRUE,
    'roles'         => TRUE,
    'menus'         => TRUE,
    'settings'      => TRUE,
    'backups'       => TRUE,
    'activity_log'  => TRUE,
    'audit_trail'   => TRUE,
);
