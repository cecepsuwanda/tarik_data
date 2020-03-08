<?php  

/**
 * 
 */
class db_connect 
{
	private $koneksi;
	private $result;

	function __construct($host,$user,$pass,$db)
	{
		$this->koneksi = mysqli_connect($host,$user,$pass,$db);
		if (mysqli_connect_errno()){
           throw new Exception("Koneksi database gagal : " . mysqli_connect_error());
		}
	}

	function query($sql)
	{
		$this->result = mysqli_query($this->koneksi,$sql);
	    return ($this->result != false) ;
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