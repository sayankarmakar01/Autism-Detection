<?php
	include('include/system_connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registration</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="../assets/images/logo.png">

		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>

		<div class="wrapper" style="background-image: url('images/bg-registration-form-2.jpg');">
			<div class="inner">
				<div class="image-holder">
					<img src="images/registration-form-2.jpg" alt="">
				</div>
				<form action="registration" method="post">
					<h3>Registration Form</h3>
					<?php
						if($_SESSION['msg']!="")
						{ ?>
							<h5><?php echo $_SESSION['msg'];?></h5>
						  <?
						  unset($_SESSION['msg']);	
						}
					?>
					<div class="form-group">
						<input type="text" name="parent_first" required placeholder="Parent's First Name" class="form-control">
						<input type="text" name="parent_last" required placeholder="Parent's Last Name" class="form-control">
					</div>
					<div class="form-group">
						<input type="text" name="child_first" required placeholder="Child's First Name" class="form-control">
						<input type="text" name="child_last" required placeholder="Child's Last Name" class="form-control">
					</div>
					<div class="form-wrapper">
						<select name="relation" id="" required class="form-control">
							<option value="" disabled selected>Relation</option>
							<option value="1">Father</option>
							<option value="2">Mother</option>
						</select>
						<i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
					</div>
					<div class="form-wrapper">
						<label for="">Child's Date of Birth</label>
						<input type="date" name="dob" required placeholder="Date of Birth" class="form-control">
						<i class="zmdi zmdi-account"></i>
					</div>
					<div class="form-wrapper">
						<select name="gender" id="" required class="form-control">
							<option value="" disabled selected>Child's Gender</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
							<option value="3">Other</option>
						</select>
						<i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
					</div>
					<div class="form-wrapper">
						<input type="text" name="mob" required placeholder="Contact No" class="form-control">
						<i class="zmdi zmdi-account"></i>
					</div>
					<div class="form-wrapper">
						<input type="text" name="email" required placeholder="Email Address" class="form-control">
						<i class="zmdi zmdi-email"></i>
					</div>
					<button name="btn" value="register">Register
						<i class="zmdi zmdi-arrow-right"></i>
					</button>
				</form>
			</div>
		</div>
		
	</body>
</html>
<?php
$action=$_POST['btn'];
if($action=="register")
{ $parent_first=$_POST['parent_first'];
  $parent_last=$_POST['parent_last'];
  $child_first=$_POST['child_first'];
  $child_last=$_POST['child_last'];
  $relation=$_POST['relation'];
  $dob=$_POST['dob'];
  $gender=$_POST['gender'];
  $mob=$_POST['mob'];
  $email=$_POST['email'];

  $qry=$mysqli->prepare("select * from user where mob=?");
  $qry->bind_param('s',$mob);
  $qry->execute();
  $qry->store_result();
  if($qry->num_rows>0)
  { $_SESSION['msg']="Mobile No already exists!";
	header('location:registration');
  }
  else 
  { $qry=$mysqli->prepare("select * from user where email=?");
	$qry->bind_param('s',$email);
	$qry->execute();
	$qry->store_result();
	if($qry->num_rows>0)
	{ $_SESSION['msg']="Email Id already exists!";
	  header('location:registration');
	}
	else
	{ $dob=date("d-m-Y",strtotime($dob));
	  $qry=$mysqli->prepare("insert into user(parent_first, parent_last, child_first, child_last, relation, dob, gender, mob, email) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
	  $qry->bind_param('sssssssss',$parent_first,$parent_last,$child_first,$child_last,$relation,$dob,$gender,$mob,$email);
	  $qry->execute();
	  $_SESSION['msg']="Registration Successful!";
	  header('location:index');
	}
  }
}
?>