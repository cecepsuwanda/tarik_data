<?php  

/**
 * 
 */
class fp_connect 
{
	private $ip;
    private $errno;
    private $errstr;
    private $sock;

	function __construct()
	{
		$this->ip = $_SESSION['fp_config']['ip'];
        //$this->connect();
	}

	function connect($ip="")
	{
		if(!empty($ip)){
          $this->ip = $ip;                  
		}
		

		$this->sock = fsockopen($this->ip, "80", $this->errno, $this->errstr, 1);
		if (!$this->sock) {
           throw new Exception("$this->errstr ($this->errno)");
        }
	}

	function read($soap_request)
	{
		 $this->connect();

		 $tabel=$_SESSION['db_config']['tabel'];

		 $koneksi = new db_connect();
        
          $result = $koneksi->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE 'log_$tabel'");
          
          if($koneksi->numrows()==0)
          {
              //echo "create";
               $sql="CREATE TABLE `log_$tabel` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `no` int(11) DEFAULT 0,
                      `log` varchar(255) DEFAULT NULL,                      
                      PRIMARY KEY (`id`)
                     )";
                $result = $koneksi->query($sql);
          }else{
          	    //echo "delete";
          	    $sql="DELETE FROM `log_$tabel`";
                $result = $koneksi->query($sql);
          }


		$newLine="\r\n";
		fputs($this->sock, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($this->sock, "Content-Type: text/xml".$newLine);
	    fputs($this->sock, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($this->sock, $soap_request.$newLine);
		$buffer="";		
		$i=1;
		while($Response=fgets($this->sock, 1024)){			
			$tmp=str_replace("\r\n","",$Response);
			$sql="insert into log_$tabel(no,log) values('$i','$tmp')";
	        $result = $koneksi->query($sql);
			$buffer=$buffer.$Response;
			$i=$i+1;			
		}
		fclose($this->sock);        
        return $buffer;
	}

	function read_all_fpdata()
	{

		$key=$_SESSION['fp_config']['key'];
		$soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
		$buffer = $this->read($soap_request);
		$buffer=$this->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
		$buffer=explode("\r\n",$buffer);
		$arr_fpdata=array();
		for($a=0;$a<count($buffer);$a++){
		    $data=$this->Parse_Data($buffer[$a],"<Row>","</Row>");
		    $PIN=$this->Parse_Data($data,"<PIN>","</PIN>");
		    $DateTime=$this->Parse_Data($data,"<DateTime>","</DateTime>");
		    $Verified=$this->Parse_Data($data,"<Verified>","</Verified>");
		    $Status=$this->Parse_Data($data,"<Status>","</Status>");
		    $arr_fpdata[]=array('pin'=>$PIN,'datetime'=>$DateTime,'verified'=>$Verified,'status'=>$Status);
		}
		
		return $arr_fpdata;    
	}

	public function delete_all_fdata()
	{
		$key=$_SESSION['fp_config']['key'];
		$soap_request="<ClearData><ArgComKey xsi:type=\"xsd:integer\">".$key."</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
		$buffer = $this->read($soap_request);
		$buffer=$this->Parse_Data($buffer,"<Information>","</Information>");
		//echo $buffer;
	}

	private function Parse_Data($data,$p1,$p2){
		$data=" ".$data;
		$hasil="";
		$awal=strpos($data,$p1);
		if($awal!=""){
			$akhir=strpos(strstr($data,$p1),$p2);
			if($akhir!=""){
				$hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
			}
		}
		return $hasil;	
	}
}

?>