<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
// if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
// }
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0;
	    /*background: #007bff;*/
		

		

		
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}

	label {
		
		color: White;
		font-weight: bold;
		padding: 4px;
		text-transform: uppercase;
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: small;
	}

</style>

<body class="bg-dark" style="background-image: url(img/fondo.jpg); ">


  <main id="main" >
  	
  		<div class="align-self-center w-100">
		<h4 class="text-white text-center"></h4>
  		<div id="login-center" class="row justify-content-center" >
  			<div class="card col-md-3 bg-dark">
  				<div class="card-body">
					  <center>
					  <img src="img/licores.png" alt="" style="width:450px;">
					  </center>
  					<form id="login-form" >
					  <br>
  						<div class="form-group">
  							<label for="username" class="control-label">Usuario</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
						  <br>
  						<div class="form-group">
  							<label for="password" class="control-label">Contraseña</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Ingresar</button></center>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Usuario c Contraseña Incorrectos</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>