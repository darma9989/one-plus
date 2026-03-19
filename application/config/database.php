<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'      => '',
    'hostname' => '36.95.239.10',
    'username' => '896386',
    'password' => 'indonesiagoes2opensource',
    'database' => 'db_one_plus',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

/* =================================================================================
 * KONEKSI DATABASE KEDUA (SISTEM LAMA / REFERENSI) - [BISA DIHAPUS JIKA TIDAK PERLU]
 * =================================================================================
 * Digunakan untuk menarik data master dari aplikasi sistem terdahulu secara "Read-Only".
 * Cara Pakai di Controller/Model:
 * $db_lama = $this->load->database('db_lama', TRUE);
 * $data = $db_lama->get('tabel_master_lama')->result();
 */
$db['db_lama'] = array(
    'dsn'      => '',
    'hostname' => '36.95.239.10', // Bisa diganti dengan IP Server luar, misal: 192.168.1.50
    'username' => '896386',      // Username dari database lama
    'password' => 'indonesiagoes2opensource',          // Password dari database lama
    'database' => 'db_master', // Nama database lama yang berjalan
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

