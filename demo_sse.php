 <?php
require_once 'config.php'; 
require_once 'db_connect.php';

$data='';
$tabel=$_SESSION['db_config']['tabel'];
$koneksi = new db_connect();

$tbl = '<table cellspacing="2" cellpadding="2" border="1"><tr align="center"><td><B>No</B></td><td width="1000"><B>Log</B></td></tr>';

$result = $koneksi->query("SHOW TABLES LIKE '{log_$tabel}'");
if($koneksi->numrows()!=1)
{
   $sql="select * from log_$tabel order by no desc";
   $result = $koneksi->query($sql);
   $logs = $koneksi->fecth_array();

    
    
   foreach ($logs as $log) {
     $tbl .= "<tr align='center'><td>".$log['no']."</td><td>".htmlspecialchars($log['log'])."</td></tr>";	
   }
   
}
   $tbl.='</table>'; 
   $data=$tbl;

  header('Content-Type: text/event-stream');
  header('Cache-Control: no-cache');
  echo "event: message\n";
  echo "data: {$data}\n\n";
  flush();
  sleep(2);  
?>

