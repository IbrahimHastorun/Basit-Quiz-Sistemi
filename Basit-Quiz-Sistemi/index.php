<?php 
	require_once("dahili.php");
	session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>QUİZ UYGULAMA</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<style>
		#renk {
			background-color:#FBFBFB;
			margin-top:10px;
			border:1px  #DEDEDE solid;	
			padding:10px;
			text-align:left;
		}
		#pad {
			padding:10px;	
		}
	</style>
</head>
<body>
	<div class="container" style="text-align:center">
		<?php
			@$islem = $_GET['islem'];

			switch ($islem) {
				case 'sonuc':

					sonuc($database);

				break;

				case 'tanimla':

					formkontrol($database);
					
				break;
				
				default:

					if (@$_SESSION['izin'] != "") {

						sorularıgetir($database);
						
					}else {

						giris($database);
						
					}
					
				break;
			}



		?>


	</div>
</body>
</html>