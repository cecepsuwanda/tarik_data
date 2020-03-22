<?php  

/**
 * 
 */
class db_connect 
{
	private $koneksi;
	private $result;

	function __construct()
	{
		$host=$_SESSION['db_config']['host'];
		$user=$_SESSION['db_config']['user'];
		$pass=$_SESSION['db_config']['pass'];
		$db=$_SESSION['db_config']['db'];
		$tabel=$_SESSION['db_config']['tabel'];
		$this->koneksi = mysqli_connect($host,$user,$pass,$db);
		if (mysqli_connect_errno()){
           throw new Exception("Koneksi database gagal : " . mysqli_connect_error());
		}
	}

	function query($sql)
	{
		$this->result = mysqli_query($this->koneksi,$sql);
	    //print_r($this->result);
	    return ($this->result != false) ;
	}

	function fecth_array()
	{
	  $data = array();
	  while ($row=mysqli_fetch_array($this->result, MYSQLI_ASSOC)) {
	   	$data[]=$row;
	   }
	  return $data;  	
	}

	function affectedrows() {
      return  mysqli_num_rows($this->result);
	}

	function numrows(){ 
      return  mysqli_num_rows($this->result);
	}

	function close() { 
      mysqli_close($this->koneksi);
	}


}

?>