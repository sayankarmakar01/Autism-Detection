<?php
	include('include/system_connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="../assets/images/logo.png">

		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">


		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>

		<div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
			<div class="inner">
				<div class="image-holder">
					<img src="images/registration-form-1.jpg" alt="">
				</div>
				<form action="index" method="post" style="margin: 50px;">
					<h3>Login Form</h3>
					<?php
						if($_SESSION['msg']!="")
						{ ?>
							<h5><?php echo $_SESSION['msg'];?></h5>
						  <?
						  unset($_SESSION['msg']);	
						}
					?>
					<div class="form-wrapper">
						<input type="text" name="email" required placeholder="Enter Registered Email" class="form-control">
						<i class="zmdi zmdi-account"></i>
					</div>
					<div class="form-wrapper">
						<input type="password" name="mob" required placeholder="Enter Registered Phone No" class="form-control">
						<i class="zmdi zmdi-lock"></i>
					</div>
					<button name="btn" value="login">Login
						<i class="zmdi zmdi-arrow-right"></i>
					</button>
					<div class="form-wrapper" style="padding-top:30px;">
						<h4>Do not have any account? </h4><a href="registration">Click here to register</a>
					</div>
				</form>
				
			</div>
		</div>
		
	</body>
</html>
<?php
$action=$_POST['btn'];
if($action=="login")
{ $mob=$_POST['mob'];
  $email=$_POST['email'];

  $qry=$mysqli->prepare("select id from user where mob=? and email=?");
  $qry->bind_param('ss',$mob,$email);
  $qry->execute();
  $qry->bind_result($id);
  while ($qry->fetch()) 
  { $id=$id;
  }
  
  if($id=="")
  { $_SESSION['msg']="Invalid Login Details";
	header('location:index');
  }
  else 
  { $_SESSION['user_id']=$id;
	header('location:dashboard');
  }
}
?>