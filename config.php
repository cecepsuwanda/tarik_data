<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    session_write_close();
    set_time_limit(0);
}


$_SESSION['fp_config']['ip']='192.168.0.201';
$_SESSION['fp_config']['key']='0';

$_SESSION['db_config']['host']='localhost';
$_SESSION['db_config']['user']='root';
$_SESSION['db_config']['pass']='123456';
$_SESSION['db_config']['db']='finger_print';
$_SESSION['db_config']['tabel']='tarik_data';

?>