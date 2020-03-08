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

	function __construct($ip)
	{
		$this->ip = $ip;
        $this->connect();
	}

	function connect($ip="")
	{
		if(!empty($ip)){
          $this->ip = $ip;                  
		}
		$this->sock = fsockopen($this->ip, "80", $this->errno, $this->errstr, 1);
		if (!$this->sock) {
           throw new Exception("$errstr ($errno)");
        }
	}

	function read($soap_request)
	{
		$newLine="\r\n";
		fputs($this->sock, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($this->sock, "Content-Type: text/xml".$newLine);
	    fputs($this->sock, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($this->sock, $soap_request.$newLine);
		$buffer="";		
		while($Response=fgets($this->sock, 1024)){			
			$buffer=$buffer.$Response;			
		}        
        return $buffer;
	}

	function read_all_fpdata($key)
	{
		$soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
		$buffer = $this->read($soap_request);
		$buffer=$this->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
		$arr_fpdata=array();
		for($a=0;$a<count($buffer);$a++){
		    $data=Parse_Data($buffer[$a],"<Row>","</Row>");
		    $PIN=Parse_Data($data,"<PIN>","</PIN>");
		    $DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
		    $Verified=Parse_Data($data,"<Verified>","</Verified>");
		    $Status=Parse_Data($data,"<Status>","</Status>");
		    $arr_fpdata[]=array('pin'=>$PIN,'datetime'=>$DateTime,'verified'=>$Verified,'status'=>$Status);
		}
		
		return $arr_fpdata;    
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