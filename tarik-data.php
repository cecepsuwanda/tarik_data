<?php
require_once 'config.php';
require_once 'fp_connect.php';
require_once 'db_connect.php';

if( isset($_SERVER['HTTP_X_REQUESTED_WITH'])  && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{    
    
    // Code that will run if this file called via AJAX request

   /* $IP=isset($_POST["ip"]) ? $_POST["ip"] : "192.168.1.201";
    $Key=isset($_POST["key"]) ? $_POST["key"] : "0";
    $host=isset($_POST["host"]) ? $_POST["host"] : "localhost";
    $user=isset($_POST["user"]) ? $_POST["user"] : "root";
    $pass=isset($_POST["pass"]) ? $_POST["pass"] : "";
    $db=isset($_POST["key"]) ? $_POST["db"] : "";
    $tabel=isset($_POST["tabel"]) ? $_POST["tabel"] : "";*/
    $tabel=$_SESSION['db_config']['tabel'];
    try {
    	
    	$Connect = new fp_connect();
        $data = $Connect->read_all_fpdata();
        
        $koneksi = new db_connect();
        
         $result = $koneksi->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '$tabel'");
          if($koneksi->numrows()!=1)
          {
               $sql="CREATE TABLE `$tabel` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_id` varchar(50) DEFAULT NULL,
                      `tgl_absen` datetime DEFAULT NULL,
                      `verifikasi` int(11) DEFAULT '0',
                      `status` int(11) DEFAULT '0',
                      `tgl_baca` datetime DEFAULT NULL,
                      PRIMARY KEY (`id`)
                     )";
                $result = $koneksi->query($sql);
          }
              
        $tbl = '<table cellspacing="2" cellpadding="2" border="1">
                <tr align="center">
                <td><B>UserID</B></td>
                <td width="200"><B>Tanggal & Jam</B></td>
                <td><B>Verifikasi</B></td>
                <td><B>Status</B></td>
                <td>Simpan/Tidak</td>
                </tr>';
        foreach ($data as $row) {
              $PIN=$row['pin'];
              $DateTime=$row['datetime'];
              $Verified=$row['verified'];
              $Status=$row['status'];
              if ($PIN!=""){
	              $sql="select * from $tabel where user_id='$PIN' and tgl_absen='$DateTime'";
	              $result = $koneksi->query($sql);
	              $jml_data=$koneksi->numrows();                 
	              $simpan="Tidak";
	              if($jml_data==0){
	                  $sql="insert into $tabel(user_id,tgl_absen,verifikasi,status,tgl_baca) values('$PIN','$DateTime',$Verified,$Status,now())";
	                  $result = $koneksi->query($sql);
	                  $simpan="Simpan";
	              } 

	              $tbl .= "<tr align='center'>
	              <td>$PIN</td>
	              <td>$DateTime</td>
	              <td>$Verified</td>
	              <td>$Status</td>
	              <td>$simpan</td>
	              </tr>";
            }
          }
          
         $tbl.='</table>';
        echo json_encode(array('text'=>$tbl));

    } catch (Exception $e) {
    	echo json_encode(array('text'=>$e));
    }
      

} else {
	header("Location: http://localhost/tarik_data");
    // Code that will run when accessing this file directly
} 



?>