<?php
    include('include/session.php');
	include('include/system_connect.php');
   
    $action=$_POST['action'];
    if ($action=="Update Profile") 
    { $parent_first=$_POST['parent_first'];
      $parent_last=$_POST['parent_last'];
      $child_first=$_POST['child_first'];
      $child_last=$_POST['child_last'];
      $relation=$_POST['relation'];
      $dob=$_POST['dob'];
      $gender=$_POST['gender'];
      $mob=$_POST['mob'];
      $email=$_POST['email'];
      $address=$_POST['address'];

      $qry=$mysqli->prepare("select * from user where mob=? and id!=?");
      $qry->bind_param('ss',$mob,$user_id);
      $qry->execute();
      $qry->store_result();
      if($qry->num_rows>0)
      { $_SESSION['msg']="Mobile No already exists!";
	    header('location:dashboard');
      }
      else 
      { $qry=$mysqli->prepare("select * from user where email=? and id!=?");
	    $qry->bind_param('ss',$email,$user_id);
	    $qry->execute();
	    $qry->store_result();
	    if($qry->num_rows>0)
	    { $_SESSION['msg']="Email Id already exists!";
	      header('location:dashboard');
	    }
	    else
	    { $dob=date("d-m-Y",strtotime($dob));
          $qry=$mysqli->prepare("update user set parent_first=?, parent_last=?, child_first=?, child_last=?, relation=?, dob=?, gender=?, mob=?, email=?, address=? where id=?");
          $qry->bind_param('sssssssssss',$parent_first,$parent_last,$child_first,$child_last,$relation,$dob,$gender,$mob,$email,$address,$user_id);
          $qry->execute();
          $_SESSION['msg']="Profile Update Successful!";
          header('location:dashboard');
        }
      }
    }
    if ($action=="") 
    {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/logo.png">
    <title>Welcome To Congnisight</title>
    <link rel="stylesheet" href="css/dashboard_style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            <?php
                $qry=$mysqli->prepare("select parent_first, parent_last, child_first, child_last, relation, dob, gender, mob, email, address from user where id=?");
                $qry->bind_param('s',$user_id);
                $qry->execute();
                $qry->bind_result($parent_first,$parent_last,$child_first,$child_last,$relation,$dob,$gender,$mob,$email,$address);
                while ($qry->fetch()) 
                { $parent_first=$parent_first;
                  $parent_last=$parent_last;
                  $child_first=$child_first;
                  $child_last=$child_last;
                  $relation=$relation;
                  $dob=$dob;
                  $gender=$gender;
                  $mob=$mob;
                  $email=$email;
                  $address=$address;
                }

                $current_date = date('Y-m-d');
                $birth_date_obj = new DateTime($dob);
                $current_date_obj = new DateTime($current_date);
                $diff = $current_date_obj->diff($birth_date_obj);
                $age_years = $diff->y;
                $age_month = $diff->m;

                if($age_years<1){$age=$age_month." Month";}else{$age=$age_years." Year";}

                if($relation==1){ $title="Mr. ";}elseif($relation==2){ $title="Mrs. ";}
                echo "Welcome ".$title.$parent_first." ".$parent_last;

                if($_SESSION['msg']!="")
				{ ?>
					<h5><?php echo $_SESSION['msg'];?></h5>
				  <?
				  unset($_SESSION['msg']);	
				}
            ?>
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list"
                    href="#account-info">Info</a>
						<a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-Test" onclick="validate2()">Test</a>
                        <a class="list-group-item list-group-item-action" href="logout">Logout</a>
                        <!-- <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a> -->            
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade" id="account-general">
                           <h2>Welcome!</h2>
                        </div>
						<div class="tab-pane fade" id="account-Test">
                            <div class="card-body pb-2">
                                <?php
                                  if($age_years>0 || $age_month>9)
                                  {
                                ?>
                                    <div class="form-group">
									    <a href="pro/level1"><button type="button" class="btn btn-primary">Begin Test</button>&nbsp;</a>
								    </div>
                                
								    <div class="form-group">
                                        <a href="pro/"><button type="button" class="btn btn-primary">Show previous Test Result</button>&nbsp;</a>
								    </div>
								<?php  
                                }
                                else
                                { ?>
                                    <h4>Not Eligible for test</h4>
                                    <?php
                                }
                            ?>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Current password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Repeat new password</label>
                                    <input type="password" class="form-control">
                                </div>
								<div class="form-group">
									<button type="button" class="btn btn-primary">Reset Password</button>&nbsp;
								</div>
                            </div>
                        </div> -->
                        <div class="tab-pane fade  active show" id="account-info">
                            <form action="dashboard" method="post">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Child's First Name</label>
                                    <input type="text" id="one" disabled required name="child_first" class="form-control" value="<?php echo $child_first;?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Child's Last Name</label>
                                    <input type="text" id="two" disabled required name="child_last" class="form-control" value="<?php echo $child_last;?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Parents's First Name</label>
                                    <input type="text" id="three" disabled required name="parent_first" class="form-control" value="<?php echo $parent_first;?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Parents's Last Name</label>
                                    <input type="text" id="four" disabled required name="parent_last" class="form-control" value="<?php echo $parent_last;?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Relation with child</label>
									<select class="custom-select" id="five" disabled name="relation">
                                        <option <?php if($relation==1){echo "selected";} ?> value="1">Father</option>
                                        <option <?php if($relation==2){echo "selected";} ?> value="2">Mother</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Child's Birthday</label>
                                    <input type="date" id="six" disabled name="dob" class="form-control" required value="<?php echo date("Y-m-d",strtotime($dob));?>">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Child's Age</label>
                                    <input type="text" disabled  class="form-control" value="<?php echo $age;?>">
                                </div>
								<div class="form-group">
                                    <label class="form-label">Child's Gender</label>
									<select class="custom-select" id="seven" disabled name="gender">
                                        <option <?php if($gender==1){echo "selected";} ?> value="1">Male</option>
							            <option <?php if($gender==2){echo "selected";} ?> value="2">Female</option>
							            <option <?php if($gender==3){echo "selected";} ?> value="3">Other</option>
                                    </select>
                                </div>
							</div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Contacts</h6>
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="mob" id="eight" disabled class="form-control" required value="<?php echo $mob;?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="nine" disabled name="email" class="form-control" required value="<?php echo $email;?>">
                                </div>
								<div class="form-group">
                                    <label class="form-label">Address</label>
									<textarea class="form-control"
                                        rows="3" name="address" id="ten" disabled><?php echo $address;?></textarea>
                                </div>
                            </div>
                            <hr class="">
                                <div class="card-body pb-2">
                                    <button class="btn btn-primary" id="btn" onclick="validate()" type="button">Edit Profile</button>
                                    <input class="btn btn-primary" id="btn2" type="hidden" name="action" value="Update Profile">
                                </div>
                            </form>
                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>
function validate() 
{ document.getElementById("one").disabled=false;
  document.getElementById("two").disabled=false;
  document.getElementById("three").disabled=false;
  document.getElementById("four").disabled=false;
  document.getElementById("five").disabled=false;
  document.getElementById("six").disabled=false;
  document.getElementById("seven").disabled=false;
  document.getElementById("eight").disabled=false;
  document.getElementById("nine").disabled=false;
  document.getElementById("ten").disabled=false;
  document.getElementById("btn").style.display="none";
  document.getElementById("btn2").type="submit";
}

function validate2() 
{ document.getElementById("one").disabled=true;
  document.getElementById("two").disabled=true;
  document.getElementById("three").disabled=true;
  document.getElementById("four").disabled=true;
  document.getElementById("five").disabled=true;
  document.getElementById("six").disabled=true;
  document.getElementById("seven").disabled=true;
  document.getElementById("eight").disabled=true;
  document.getElementById("nine").disabled=true;
  document.getElementById("ten").disabled=true;
  document.getElementById("btn").style.display="block";
  document.getElementById("btn2").type="hidden";
}
</script>
<?php  } ?>