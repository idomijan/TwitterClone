<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php

function db()
{
		$conn = new mysqli("localhost", "root", "", "baza"); 
		return $conn;
}
function select($tablica,$id,$tekst,$naziv_polja)
{	
	$c = db();
	$upit = "SELECT * FROM $tablica ";
	$r = $c->query($upit);
	echo '<select name="'.$naziv_polja.'"  >'; 
	while($redak=$r->fetch_assoc())
	{
			echo '<option value="'.$redak[$id].'">'. $redak[$tekst].'</option>';
	}
	echo '</select>';
	$c->close();
}
function padajuca($tablica1, $tablica2, $id1, $id2, $tekst, $naziv_polja)
{
	$c = db();
	//postavljanje upita
	//$upit = "SELECT * FROM $tablica ORDER BY $tekst";
	$upit = "SELECT * FROM $tablica1, $tablica2 WHERE  $id1 = $id2";
	//postavljanje upita i dohvat rezultata
	$r=$c->query($upit);
	if(!$r){echo 'Upit nije uspio<br>Greška = '.$c->error;}
	//ispis rezultata
	echo '<select name="'.$naziv_polja.'">';
	while($redak=$r->fetch_assoc())
	{
	echo '<option value="'.$redak[$id2].'">'.$redak[$tekst].'</option>';
	} 
	echo '</select>'; 
	//zatvaranje veze na bazu
	$c->close(); 
}



?>
</body>
</html>
