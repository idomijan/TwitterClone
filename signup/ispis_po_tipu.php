<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
require_once('db.php');
$c = db();

$upit1 = "SELECT * FROM korisnici WHERE vk_tip = 1";
$upit = "SELECT * FROM country, korisnici WHERE Code = vk_zemlje"; 
$t = $c->query($upit);
$r = $c->query($upit1);
/*while ($red = $t->fetch_assoc())
{
	echo $red['Name'].'<br>';
}*/

echo '<br>AUTOR <br>';
while($red = $r->fetch_assoc())
{
	
	echo $red['ime']." ".$red['prezime']." ".$red['oib'];  	
	if($red2 = $t->fetch_assoc())
	{
		echo $red2['Name'].'<br>'; 
	}
	
}
echo '<br>'; 
$upit2 = "SELECT * FROM korisnici WHERE vk_tip = 2"; 
$r1 = $c->query($upit2);

echo 'UREDNIK <br>'; 
while($red = $r1->fetch_assoc())
{

	echo $red['ime']." ".$red['prezime']." ".$red['oib']; 
	if($red2 = $t->fetch_assoc())
	{
		echo $red2['Name'].'<br>'; 
	} 	
	
}

echo '<br>';
echo 'ADMINISTRATOR <br>'; 
$upit3 = "SELECT * FROM korisnici WHERE vk_tip = 3";
$r2 = $c->query($upit3);
while ($red = $r2->fetch_assoc())
{
	echo $red['ime']." ".$red['prezime']." ".$red['oib']; 
	if($red2 = $t->fetch_assoc())
	{
		echo $red2['Name'].'<br>'; 
	}
}
echo '<br>';
echo 'KLUB <br>'; 
$upit3 = "SELECT * FROM korisnici WHERE vk_tip = 4";
$r2 = $c->query($upit3);
while ($red = $r2->fetch_assoc())
{
	echo $red['ime']." ".$red['prezime']." ".$red['oib']; 
	if($red2 = $t->fetch_assoc())
	{
		echo $red2['Name'].'<br>'; 
	}
}
echo '<br>';
echo 'IZVODJAC <br>'; 
$upit3 = "SELECT * FROM korisnici WHERE vk_tip = 5";
$r2 = $c->query($upit3);
while ($red = $r2->fetch_assoc())
{
	echo $red['ime']." ".$red['prezime']." ".$red['oib']; 
	if($red2 = $t->fetch_assoc())
	{
		echo $red2['Name'].'<br>'; 
	}
}


?>
</body>
</html>
