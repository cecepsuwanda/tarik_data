<?php

?>

<html>
<head>
	 <title>Tarik Data Mesin Absensi</title>

	 <script type = "text/javascript" 
         src = "jquery-3.4.1.min.js">
      </script>
		
      <script type = "text/javascript" language = "javascript">
         $(document).ready(function() {
             var source;            


             $("#frm_download").submit(function(e){
                  e.preventDefault();
                  $("#dt_table").html("");
                  $("#dt_finger").html("");
                   
		             	source = new EventSource("demo_sse.php");
		                source.onmessage = function(event) {
		                    $("#dt_finger").html(event.data);
		                }; 

                  $.ajax({
							url: 'tarik-data.php',
							data: $("#frm_download").serialize(),
							error: function() {
							          alert('error');
							          source.close();
							       },
							dataType: 'json',
							success: function(data) {
							                           $("#dt_table").html(data.text);
							                           source.close();
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
<!--<h3>Setting Finger Print</h3>
<table>
  <tr>
  	<td>
  	  IP Address	
  	</td>
  	<td>
      :		
  	</td>
  	<td>
      <input type="Text" name="ip" value="192.168.0.201" size=15 required>		
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
</table>-->

<input type="Submit" name="submit" value="Download">
</form>
<br>
<div id="dt_finger"></div>
<div id="dt_table"></div>
</body>
</html>