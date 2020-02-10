 <?php  
 session_start();  
 include ('connection/baglanti.php');
 try  
 {  
    if(isset($_POST["login"]))  
    {  
		if(empty($_POST["username"]) || empty($_POST["password"]))  
		{  
			$message = '<label>Kullanıcı Adı ve Parolayı Doldurunuz</label>';  
		}  
		else  
		{  
			$kullanici=$_POST["username"];
			$sifre=$_POST["password"];
			$query = "SELECT * FROM efatura.KULLANICILAR WHERE user_username = '".$kullanici."' and user_sifre='".md5(sha1($sifre))."' ";  
			$statement = $pdo->prepare($query);  
			$statement->execute(  
				array(  
					'username'     =>     $_POST["username"],  
					'password'     =>     $_POST["password"]  
					)  
				);  
			$count = $statement->rowCount();  
			//echo "$count";
			if($count > 0)  
			{  
				 $_SESSION["username"] = $_POST["username"];  
				 $useryetki = $pdo->query("SELECT USER_YETKI FROM efatura.KULLANICILAR WHERE USER_USERNAME = '".$kullanici."'")->fetch();
				 echo $useryetki[0];
				 $_SESSION["YETKI"] = $useryetki[0];
						  //login olan kişileri kayıt altına alan sorgu
 						$sql2 = "INSERT INTO GIRISLER (LOGINOLAN) VALUES ('".$kullanici."') ";		
						ECHO $sql2;
						 if ($pdo->query($sql2) == false) {
						  $result  = 'error';
						  $message = 'query error';
						} else {
						  $result  = 'success';
						  $message = 'query success';

						}
				 //login başarılı ise index sayfasında yönlendiriyor.
				 header("location:index.php");  
			}  
			else  
			{  
				 $message = '<label>Hatalı Giriş Denemesi</label>';  
			}  
        }  
    }  
 }  
 catch(PDOException $error)  
 {  
      $message = 
	  //$query;
	   $error->getMessage();  
 }  
 ?>  
 <!DOCTYPE html>  
<html>  
	<head>  
		  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Trust Me (TM)</title>  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
	</head>  
	<body>  
<style>
body {
		background: #000 !important;
	}
	.card {
		border: 1px solid #28a745;
	}
	.card-login {
		margin-top: 130px;
		padding: 18px;
		max-width: 30rem;
	}

	.card-header {
		color: #fff;
		/*background: #ff0000;*/
		font-family: sans-serif;
		font-size: 20px;
		font-weight: 600 !important;
		margin-top: 10px;
		border-bottom: 0;
	}

	.input-group-prepend span{
		width: 50px;
		background-color: #ff0000;
		color: #fff;
		border:0 !important;
	}

	input:focus{
		outline: 0 0 0 0  !important;
		box-shadow: 0 0 0 0 !important;
	}

	.login_btn{
		width: 130px;
	}

	.login_btn:hover{
		color: #fff;
		background-color: #ff0000;
	}

	.btn-outline-danger {
		color: #fff;
		font-size: 18px;
		background-color: #28a745;
		background-image: none;
		border-color: #28a745;
	}

	.form-control {
		display: block;
		width: 100%;
		height: calc(2.25rem + 2px);
		padding: 0.375rem 0.75rem;
		font-size: 1.2rem;
		line-height: 1.6;
		color: #28a745;
		background-color: transparent;
		background-clip: padding-box;
		border: 1px solid #28a745;
		border-radius: 0;
		transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
	}

	.input-group-text {
		display: -ms-flexbox;
		display: flex;
		-ms-flex-align: center;
		align-items: center;
		padding: 0.375rem 0.75rem;
		margin-bottom: 0;
		font-size: 1.5rem;
		font-weight: 700;
		line-height: 1.6;
		color: #495057;
		text-align: center;
		white-space: nowrap;
		background-color: #e9ecef;
		border: 1px solid #ced4da;
		border-radius: 0;
	}
</style>

		<div class="container">
			<div class="card card-login mx-auto text-center bg-dark">
				<div class="card-header mx-auto bg-dark">
					<span> <img src="logo.png" class="w-75" alt="Logo"> </span><br/>
					<span class="logo_title mt-5"> Giriş Ekranı </span>
				</div>
				<div class="card-body">
					<form action="" method="post">
					 <?php  
						if(isset($message))  
						{  
							 echo '<label class="text-danger">'.$message.'</label>';  
						}  
						?> 
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control" placeholder="Username">
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control" placeholder="Password">
						</div>
						<div class="form-group">
							<input type="submit" name="login" value="Giriş" class="btn btn-outline-danger float-right login_btn">
						</div>
					</form>
				</div>
			</div>
		</div>	   
	</body>  
</html>  