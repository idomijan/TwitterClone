<?php session_start();
require_once('db.php');
logiran(1);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<?php
if(!isset($_GET['a'])) { $a = ''; } else { $a = $_GET['a']; }
$c = db();
// DOHVATI ID OSOBE I POSTAVI GA U SESSION VARIJABLU "kid"
// IF SLUZI KAKO BI OVAJ UPIT RADILI SAMO JEDNOM
if(!isset($_SESSION['kid'])) 
{ 
	$sql = "SELECT id 
		FROM korisnici 
		WHERE username ='".$_SESSION['login']."'";
	$r = $c->query($sql);
	$row = $r->fetch_assoc(); // WHILE NE TREBA KADA JE SAMO 1 RED
	$_SESSION['kid']=$row['id'];
}
echo '<p align="right"><a href="logout.php">ODJAVA</a></p>';
switch($a) 
{
	case 'create': unos(); break;
	case 'update': izmjeni(); break;
	case 'delete': brisi(); break;
	case 'tagiraj': pregledTagova();  break;
	case 'spremiTagove': spremiTagove(); break;
	default : pregled(); form(); // READ
}
function spremiTagove()
{
	$oznaceniTagovi = array(); // PRAZNO POLJE, ZA TAGOVE
	foreach($_POST as $key=>$value) // Submit=Spremi, id=43, tagovi_1,...
	{
		if(strpos($key,'tagovi_')===0) // SAMO CHECKBOXI!!!!
		{
			$id = substr($key,7); // OD KRAJA "tagovi_" do kraja
			$oznaceniTagovi[]=$id; // UBACI ID U POLJE 
		}
	}
	$id_clanka = $_POST['id']; // ZA KOJI CLANAK VEZUJEMO
	
	global $c;
	if(count($oznaceniTagovi)>0)
	{
		foreach($oznaceniTagovi as $t)
		{
			$sql = "INSERT INTO clanci_tagovi(id_clanka, id_taga) 
			 		VALUES($id_clanka, $t)";
			$c->query($sql);
			//echo $sql.'<br>';
			pregled(); form();
		}
	}
	
}

function pregledTagova()
{
	global $c;
	$sql = "SELECT * FROM tagovi"; // UPIT
	$r = $c->query($sql); // DOHVATI MYSQL RESULT SET
echo '<form method="post" action="?a=spremiTagove">';
	echo '<table border="1" cellpadding="4">';
	while($row = $r->fetch_assoc())
	{
		// RETCI TABLICE SA CHECKBOXOM I IMENOM TAGA
		echo '<tr>';
		echo '<td>';
		// OVDJE CHECKBOX
	echo '<input type="checkbox" name="tagovi_'.$row['id'].'">';
		echo '</td>';
		
		echo '<td>';
		echo $row['naziv'];  // OVDJE NAZIV TAGA
		echo '</td>';
		
		echo '</tr>';
	}
	echo '</table>';
	echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
echo '<input type="submit" name="submit" value="spremi">';
	echo '</form>';
	
}

function pregled(){
	// ISPIS KATEGORIJA SA EDIT I DELETE LINKOVIMA
	global $c;
	$sql = "SELECT c.id, c.naslov, k.id AS kid  
			FROM clanci c, korisnici k  
			WHERE c.vk_autora = k.id 
			AND k.username = '".$_SESSION['login']."'";
	$r = $c->query($sql);
	if($r->num_rows == 0) 
	{
		echo '<p>Nemate radova u bazi</p><hr>';
	}
	while($row = $r->fetch_assoc())
	{
	  echo '<p>'.$row['naslov'];
	  echo ' - <a href="?a=update&id='.$row['id'].'">IZMJENI</a>';
	  echo ' - <a href="?a=delete&id='.$row['id'].'">IZBRISI</a>';
	  echo ' - <a href="?a=tagiraj&id='.$row['id'].'">TAGIRAJ</a>';
	  echo '</p><hr>';
	}
	
}
function form(){
	// OBRAZAC SA JEDNIM TEXT POLJEM
	global $c;
	echo '<form method="post" action="?a=create">';
	echo 'Naslov: <input type="text" name="naslov"><br>';
	// PADAJUCA ZA VK_KATEGORIJE
        echo '<p>Kategorija: ';
	select('kategorije','id','naziv','kategorije');
        echo '</p>';
	echo '<br>Uvodni tekst: <br><textarea rows="10" cols="50" name="uvod"></textarea><br>';
	echo '<br>Puni tekst: <br><textarea  rows="10" cols="50" name="tekst"></textarea><br>';
	echo '<input type="submit" name="submit" value="Spremi">';
	echo '</form>';
}
function unos(){
	global $c;
	$naslov = $_POST['naslov'];
	$kategorije = $_POST['kategorije'];
	$uvod = $_POST['uvod'];
	$tekst = $_POST['tekst'];
	$objavljen = 0;
	$pogleda = 0;
	$vk_autora = $_SESSION['kid']; 
	
	
	$sql = "INSERT INTO 
			clanci(naslov,vk_kategorije, vk_autora, objavljen, 
			uvod, tekst, pogledi) 
			VALUES ('$naslov',$kategorije,$vk_autora, $objavljen,
			'$uvod', '$tekst',$pogleda)";
	$c->query($sql);
	
	echo '<a href="autori.php">Povratak</a>';
}
function izmjeni()
{	
	global $c;
	$id = $_GET['id']; // POSLANO SA PREGLEDA "?a=update&id=11"
	if(!$_POST)
	{
		$sql = "SELECT * FROM clanci WHERE id=$id";
		$r = $c->query($sql);
		$row = $r->fetch_assoc(); // Netreba while jer je samo 1 redak
		
		// OBRAZAC SA JEDNIM TEXT POLJEM (POPUNJENO POLJE)
		echo '<form method="post" action="?a=update&id='.$id.'">';
		
		echo 'Naslov: <input type="text" name="naslov" 
									value="'.$row['naslov'].'"><br>';
		// PADAJUCA ZA VK_KATEGORIJE
                echo '<p>Kategorija: ';
		preselect('kategorije','id','naziv','kategorije', 
												$row['vk_kategorije']);
                echo '</p>';
		echo '<br>Uvodni tekst: <br><textarea  rows="10" cols="50" name="uvod">'.$row['uvod'].'</textarea><br>';
		echo '<br>Puni tekst: <br><textarea  rows="10" cols="50" name="tekst">'.$row['tekst'].'</textarea><br>';
		
		echo '<input type="submit" name="submit" value="Spremi">';
		echo '</form>';
	}
	else
	{
		// UPDATE U BAZI
		$naslov = $_POST['naslov'];
		$kategorije = $_POST['kategorije'];
		$uvod = $_POST['uvod'];
		$tekst = $_POST['tekst'];
		
		$sql = "UPDATE clanci 
				SET naslov='$naslov',
					vk_kategorije = $kategorije, 
					uvod = '$uvod',
					tekst = '$tekst'  
				WHERE id=$id";
		$c->query($sql);
		echo '<a href="autori.php">Povratak</a>';
	}
}
function brisi(){
	// NEMA POTVRDE, ODMAH DELETE, NEMA OBRAZAC
	global $c;
	$id = $_GET['id'];
	$sql = "DELETE FROM clanci WHERE id=$id LIMIT 1";
	$c->query($sql);
	echo '<a href="autori.php">Povratak</a>';
}
?>
</body>
</html>
