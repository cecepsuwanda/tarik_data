<?php
$IP=isset($_POST["ip"]) ? $_POST["ip"] : "192.168.1.201";
$Key=isset($_POST["key"]) ? $_POST["key"] : "0";
$host=isset($_POST["host"]) ? $_POST["host"] : "localhost";
$user=isset($_POST["user"]) ? $_POST["user"] : "root";
$pass=isset($_POST["pass"]) ? $_POST["pass"] : "";
$db=isset($_POST["key"]) ? $_POST["db"] : "";
$tabel=isset($_POST["tabel"]) ? $_POST["tabel"] : "";

if(isset($_POST["ip"])){
    set_time_limit(0);
    echo "Connect Ke Fingerprint : <br>";
	$Connect = fsockopen($IP, "80", $errno, $errstr, 1);
	if($Connect){
		echo "Baca Data dari Fingerprint : <br>";
		$soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
		$newLine="\r\n";
		fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($Connect, "Content-Type: text/xml".$newLine);
	    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($Connect, $soap_request.$newLine);
		$buffer="";
		$i=1;
		while($Response=fgets($Connect, 1024)){
			echo "Baca Data ke - $i : <br> $Response <br>";
			$buffer=$buffer.$Response;
			$i=$i+1;
		}

		$koneksi = mysqli_connect($host,$user,$pass,$db);
 
        // Check connection
        $save=1;        
        if (mysqli_connect_errno()){
	        echo "Koneksi database gagal : " . mysqli_connect_error();
	        $save=0;
        }

        if ($save==1){
           $result = mysqli_query($koneksi,"SHOW TABLES LIKE '{$tabel}'");
	        if( mysqli_num_rows($result) != 1 )
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
		        $result = mysqli_query($koneksi, $sql);
	        }
		  }  
                
        

?>
	<table cellspacing="2" cellpadding="2" border="1">
	<tr align="center">
	    <td><B>UserID</B></td>
	    <td width="200"><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>Status</B></td>
	</tr>
<?php
        
        require_once "parse.php" ;
	    $buffer=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
	    $buffer=explode("\r\n",$buffer);
	    for($a=0;$a<count($buffer);$a++){
		    $data=Parse_Data($buffer[$a],"<Row>","</Row>");
		    $PIN=Parse_Data($data,"<PIN>","</PIN>");
		    $DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
		    $Verified=Parse_Data($data,"<Verified>","</Verified>");
		    $Status=Parse_Data($data,"<Status>","</Status>");
		    if ($save==1){
		       if ($PIN!=""){
                    $sql="select * from $tabel where user_id='$PIN' and tgl_absen='$DateTime'";
                    $result = mysqli_query($koneksi, $sql);
                    $jml_data=mysqli_num_rows($result);                 
                    if($jml_data==0){
                       $sql="insert into $tabel(user_id,tgl_absen,verifikasi,status,tgl_baca) values('$PIN','$DateTime',$Verified,$Status,now())";
		               $result = mysqli_query($koneksi, $sql);
		            }           
		       }	
		    }

?>
	<tr align="center">
		    <td><?php echo $PIN; ?></td>
		    <td><?php echo $DateTime; ?></td>
		    <td><?php echo $Verified; ?></td>
		    <td><?php echo $Status; ?></td>
		</tr>
	<?php 
      }
    ?>
	</table>
<?php	 

	}else{ 
	   echo "Koneksi Gagal";
	}         

  }	
?>
