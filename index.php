<html>
<head>
	 <title>Tarik Data Mesin Absensi</title>

	 <script type = "text/javascript" 
         src = "http://localhost/tarik_data/jquery-3.4.1.min.js">
      </script>
		
      <script type = "text/javascript" language = "javascript">
         $(document).ready(function() {
             $("#frm_download").submit(function(e){
                  e.preventDefault();
                  $.ajax({
							url: 'http://localhost/tarik_data/tarik-data.php',
							data: $("#frm_download").serialize(),
							error: function() {
							          alert('error');
							       },
							dataType: 'json',
							success: function(data) {
							                           alert(data.text);
							                         },
							type: 'POST'
						});

             });
         });
      </script>

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
<br>
<!--Baca Data dari Fingerprint : <br>
<div id="dt_fp"></div>
<br>-->
<table cellspacing="2" cellpadding="2" border="1">
	<tr align="center">
	    <td><B>UserID</B></td>
	    <td width="200"><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>Status</B></td>
	</tr>
	<div id="dt_table"></div>
</table>	

</body>
</html>