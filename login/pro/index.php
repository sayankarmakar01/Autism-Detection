<?php
include('../include/session.php');
include('../include/system_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/x-icon" href="../../assets/images/logo.png">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.w3-button {
    width:150px;
    border-radius:3px;
    margin:7px;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Result</h2>
<a href="../dashboard"><button class="w3-button w3-green">Go Dashboard</button></a>
<table>
  <tr>
    <th>Sl No.</th>
    <th>Date</th>
    <th>Type</th>
    <th>Autistic Percentage</th>
    <th>Remark</th>
  </tr>
  <?php
    $qry=$mysqli->prepare("select score, out_of_score, level, process_id from result where user_id=?");
    $qry->bind_param('s',$user_id);
    $qry->execute();
    $qry->bind_result($score, $out_of_score, $level, $process_id);
    while ($qry->fetch()) 
    { $date=explode("_",$process_id);
      $date=date("d-m-Y",strtotime($date[0]));
      $wrong=$out_of_score-$score;
      $percentage=($wrong/$out_of_score)*100;
      if($level==1)
      { if($percentage>=90){$remark="The child may have developmental delay";}
        else if($percentage>=70 && $percentage<=89){$remark="The child may have moderate developmental delay";}
        else if($percentage>=60 && $percentage<=69){$remark="The child may have mild developmental delay";}
        else if($percentage<60){$remark="Need Medical Practitioners to detect";}
        if($percentage==0){$remark="No Autistic";}
      }
      elseif ($level==2) 
      { if($percentage>=90){$remark="The child may be under high Autism Spectrum Disorder";}
        else if($percentage<90 && $percentage>0){$remark="The child may be under moderately";}
        else if($percentage==0){$remark="No Autistic";}
      }
      $sl++;
       ?>
        <tr>
            <td><?php echo $sl;?></td>
            <td><?php echo $date;?></td>
            <td><?php echo "Level ".$level;?></td>
            <td><?php echo $percentage;?> %</td>
            <td><?php echo $remark;?></td>
        </tr>
        <?php
          if($old_process_id==$process_id)
          { $net_per=($prev_percentage+$percentage)/2;
            if($net_per>=90){$remark="The child may be under high Autism Spectrum Disorder";}
            else if($net_per>=70 && $net_per<=89){$remark="The child may be under moderately";}
            else if($net_per>=60 && $net_per<=69){$remark="The child may be under mild Autism Spectrum Disorder";}
            else if($net_per<60){$remark="Need Medical Practitioners to detect / No Autistic";}
            else if($net_per==0){$remark="No Autistic";}
            ?>
              <tr>
                <td colspan=3>Final Result based on last level 1 and 2</td>
                <td><?php echo $net_per;?> %</td>
                <td><?php echo $remark;?></td>
              </tr>
            <?php
          }
          $old_process_id=$process_id;
          $prev_percentage=$percentage;
        ?>
      <?php
    }
  ?>
  
 
</table>

</body>
</html>

