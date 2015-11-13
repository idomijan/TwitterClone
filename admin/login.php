<?php
$username = $_POST['username'];
$pass = md5($_POST['pass']);
require_once('db.php');
$c=db();
$upit = "SELECT * FROM korisnici WHERE username='$username' AND 
		 password = '$pass' LIMIT 1";
$r = $c->query($upit);
if($r && $r->num_rows==1)
{
	session_start();
	$row = $r->fetch_assoc();
	$_SESSION['login']=$username;
	$_SESSION['tip']= $row['vk_tip'];
	
	switch($row['vk_tip'])
	{
		case 1:  header("Location: autori.php"); break;
		default: header("Location: index.php");
	}
	
}
else 
{
	header("Location: index.php");
}
$c->close();
?>
