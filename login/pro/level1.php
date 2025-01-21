<?php
include('../include/session.php');
include('../include/system_connect.php');
$action=$_POST['action'];

$qry=$mysqli->prepare("select * from result where level1_sts='y' and level2_sts='n'");
$qry->execute();
$qry->store_result();
$row=$qry->num_rows;
if($row==1){ header('location:level2'); }
if($action=="process")
{ $process_id=date("Ymd_His")."_".mt_rand(100,999);
  $l1_ids=$_POST['l1_ids'];
  $score=0;
  foreach($l1_ids as $l1_id)
  { $qry=$mysqli->prepare("select correct from level_1 where id=?");
    $qry->bind_param('s',$l1_id);
    $qry->execute();
    $qry->bind_result($correct);
    while ($qry->fetch()) 
    { $correct=$correct;
    }

    $q_ids=$_POST['group'.$l1_id];
    $i=0;
    foreach ($q_ids as $q_id) 
    { $i++;
      $qry=$mysqli->prepare("select question from level_1_question where id=?");
      $qry->bind_param('s',$q_id);
      $qry->execute();
      $qry->bind_result($question);
      while ($qry->fetch()) 
      { $question=$question;
      }

      $qry=$mysqli->prepare("insert into result_question (question, l1_id, process_id) values(?, ?, ?)");
      $qry->bind_param('sss',$question, $l1_id, $process_id);
      $qry->execute();
    }
    if($i>=$correct){$score++;}
  }
  $level=1;
  $out_of_score=count($l1_ids);
  $qry=$mysqli->prepare("select * from level_1");
  $qry->execute();
  $qry->store_result();
  $row=$qry->num_rows;
  if($row==$out_of_score){$sts="y";}else{$sts="n";}

  $qry=$mysqli->prepare("insert into result (score, level, process_id, user_id, out_of_score, level1_sts) values(?, ?, ?, ?, ?, ?)");
  $qry->bind_param('ssssss',$score, $level, $process_id, $user_id, $out_of_score, $sts);
  $qry->execute();
  
  if($sts=="y")
  { header('location:level2');
  }
  else
  { $_SESSION['msg']="Test Complete";
    header('location:../dashboard');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../assets/images/logo.png">
    <title>Level-1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 600px;
        }

        h3 {
            color: #555;
            font-size: 18px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin: 8px 0;
            font-size: 16px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        .form-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
        }

        .form-container form {
            margin-bottom: 20px;
        }

        .form-container form:last-child {
            margin-bottom: 0;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }

            h3 {
                font-size: 16px;
            }

            label {
                font-size: 14px;
            }

            button {
                padding: 10px;
                font-size: 14px;
            }

            .form-container {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            form {
                padding: 15px;
            }

            button {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Level-1 Test</h2>
        
        <form action="level1" method="post">
            <?php
                $qry=$mysqli->prepare("select dob from user where id=?");
                $qry->bind_param('s',$user_id);
                $qry->execute();
                $qry->bind_result($dob);
                while ($qry->fetch()) 
                { $dob=$dob;
                }
 
                $current_date = date('Y-m-d');
                $birth_date_obj = new DateTime($dob);
                $current_date_obj = new DateTime($current_date);
                $diff = $current_date_obj->diff($birth_date_obj);
                $age_years = $diff->y;
                $age_month = $diff->m;

                $qry=$mysqli->prepare("select id, from_month, to_month from level_1 order by id");
                $qry->execute();
                $qry->bind_result($id, $from_month, $to_month);
                while ($qry->fetch()) 
                { $i++;
                  $a[$i]=$id;
                  $b[$i]=$from_month;
                  $c[$i]=$to_month;
                }

                if($age_years>0){$age_month=($age_years*12)+$age_month;}
  
                if($age_month<10){ header('location:../dashboard');}
                for ($j=1; $j <=$i ; $j++) 
                { $id=$a[$j];
                  $from_month=$b[$j];
                  $to_month=$c[$j];

                  if($age_month<$to_month){break;}   
            ?>
                    <h3>Growth of child at the age of <?php echo $from_month." - ".$to_month;?> months: </h3>
                    <input type="hidden" name="l1_ids[]" value="<?php echo $id;?>">
                    <?php
                        $qry=$mysqli->prepare("select id, question from level_1_question where l1_id=? order by id");
                        $qry->bind_param('s',$id);
                        $qry->execute();
                        $qry->bind_result($q_id, $question);
                        while ($qry->fetch()) 
                        { ?>
                            <label>
                                <input type="checkbox" name="group<?php echo $id;?>[]" value="<?php echo $q_id;?>"> <?php echo $question;?>
                            </label> 
                            <?php
                        }
                }
              ?>
              <button type="submit" name="action" value="process">Submit</button>
        </form>
    </div>
</body>
</html>