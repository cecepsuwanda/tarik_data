<html>
<head>
	 <title>Tarik Data Mesin Absensi</title>

</head>
<body bgcolor="#caffcb">

<H3>Download Log Data</H3>

<form id="frm_download" action="" method="post" >
<h3>Setting Finger Print</h3>
<table>
  <tr>
  	<td>
  	  IP Address	
  	</td>
  	<td>
      :		
  	</td>
  	<td>
      <input type="Text" name="ip" value="192.168.1.201" size=15 required>		
  	</td>
  </tr>
  <tr>
  	<td>
      Comm Key 		
  	</td>
  	<td>
       :		
  	</td>
  	<td>
      <input type="Text" name="key" size="5" value="0" require> 		
  	</td>
  </tr>	
</table>
   
<h3>Setting MySQL</h3>

<table>
	<tr>
		<td>
		  Host 	
		</td>
		<td>
		   :	
		</td>
		<td>
		   <input type="Text" name="host" value="localhost" size=15 required>	
		</td>
	</tr>
	<tr>
		<td>
	      User 		
		</td>
		<td>
	      :
		</td>
		<td>
		   <input type="Text" name="user" size="15" value="root" required>			
		</td>
	</tr>
	<tr>
		<td>
		  Pass 
		</td>
		<td>
			:
		</td>
		<td>
		   <input type="Text" name="pass" size="15" value="" required>		
		</td>
	</tr>
	<tr>
		<td>
	      DB 		
		</td>
		<td>
			:
		</td>
		<td>
		   <input type="Text" name="db" size="15" value="" required>	
		</td>
	</tr>
	<tr>
		<td>
          Tabel 		
		</td>
		<td>
		   :	
		</td>
		<td>
		   <input type="Text" name="tabel" size="15" value="" required>	
		</td>
	</tr>
</table>

<input type="Submit" name="submit" value="Download">
</form>

</body>
</html>