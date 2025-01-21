<?php
ob_start();
session_start();
putenv('TZ=Asia/Calcutta');
date_default_timezone_set("Asia/Calcutta");
$mysqli=new mysqli("localhost","root","","minor");
$user_id=$_SESSION['user_id'];
?>