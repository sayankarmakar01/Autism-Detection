<?php
include('../include/session.php');
include('../include/system_connect.php');
$action=$_POST['action'];
if($action=="process")
{ $qry=$mysqli->prepare("select process_id from result where level1_sts='y' and level2_sts='n' and user_id=?");
  $qry->bind_param('s',$user_id);
  $qry->execute();
  $qry->bind_result($process_id);
  while ($qry->fetch()) 
  { $process_id=$process_id;
  }
  
  $l2_ids=$_POST['l2_ids'];
  $score=0;
  foreach($l2_ids as $l2_id)
  { $ans=$_POST['group'.$l2_id];
    
    $qry=$mysqli->prepare("select question, yes, no from level_2_question where id=?");
    $qry->bind_param('s',$l2_id);
    $qry->execute();
    $qry->bind_result($question,$yes,$no);
    while ($qry->fetch()) 
    { $question=$question;
      $yes=$yes;
      $no=$no;
    }
    if($yes==1){$correct="Yes";}elseif($no==1){$correct="No";}
    if($ans==$correct){$score++;}

    $qry=$mysqli->prepare("insert into reselt_question_2 (question, answer, correct, process_id) values(?, ?, ?, ?)");
    $qry->bind_param('ssss',$question, $ans, $correct, $process_id);
    $qry->execute();
  }

  $level=2;
  $out_of_score=$_POST['total'];
  $qry=$mysqli->prepare("insert into result (score, level, process_id, user_id, out_of_score) values(?, ?, ?, ?, ?)");
  $qry->bind_param('sssss',$score, $level, $process_id, $user_id, $out_of_score);
  $qry->execute();

  $qry=$mysqli->prepare("update result set level1_sts='y', level2_sts='y' where process_id=?");
  $qry->bind_param('s',$process_id);
  $qry->execute();

  $_SESSION['msg']="Test Complete";
  header('location:../dashboard');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developmental Questions</title>
    <style>
        /* Basic Reset */
        body, h3, form, label, input {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
        }

        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        .question-container {
            margin-bottom: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            h3 {
                font-size: 22px;
            }

            form {
                padding: 15px;
                max-width: 100%;
            }

            label {
                font-size: 14px;
            }

            button {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h3>Developmental Questions (Level 2)</h3>
    <form action="level2" method="post">
        <!-- Question 1 -->
         <?php
            $qry=$mysqli->prepare("select id, question from level_2_question order by id");
            $qry->execute();
            $qry->bind_result($q_id, $question);
            while ($qry->fetch()) 
            { $i++;
              ?>
                <input type="hidden" name="l2_ids[]" value="<?php echo $q_id;?>">
                <div class="question-container">
                    <label><?php echo $question;?></label>
                    <input type="radio" name="group<?php echo $q_id;?>" value="Yes"> Yes
                    <input type="radio" name="group<?php echo $q_id;?>" value="No"> No
                </div>
              <?php
            }
         ?>
          <input type="hidden" name="total" value="<?php echo $i;?>">
        
        <!-- Submit Button -->
        <button type="submit" name="action" value="process">Submit</button>
    </form>
</body>
</html>
