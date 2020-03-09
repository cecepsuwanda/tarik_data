<?php

if( isset($_SERVER['HTTP_X_REQUESTED_WITH'])  && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{    
    // Code that will run if this file called via AJAX request

    $IP=isset($_POST["ip"]) ? $_POST["ip"] : "192.168.1.201";
    $Key=isset($_POST["key"]) ? $_POST["key"] : "0";
    $host=isset($_POST["host"]) ? $_POST["host"] : "localhost";
    $user=isset($_POST["user"]) ? $_POST["user"] : "root";
    $pass=isset($_POST["pass"]) ? $_POST["pass"] : "";
    $db=isset($_POST["key"]) ? $_POST["db"] : "";
    $tabel=isset($_POST["tabel"]) ? $_POST["tabel"] : "";

} else {
	header("Location: http://localhost/tarik_data");
    // Code that will run when accessing this file directly
} 



?>