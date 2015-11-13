<?php require('admin/db.php'); $c = db(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
  

    <title>Twitter Clone</title>

    <!-- Bootstrap core CSS -->
    <link href="http://localhost/projekt08/portal-bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap/css/blog.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#">Home</a>
          <a class="blog-nav-item" href="TwitterClone">Twitter Clone</a>
          <a class="blog-nav-item" href="admin/">Administracija</a>
           <a class="blog-nav-item" href="signup/unos_korisnika.php">Registracija</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Twitter Clone</h1>
        <p class="lead blog-description">Društvena mreža</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">
<?php
/*
 * GLAVNI SADRZAJ
 * PREMA PARAMETRU a U GET NIZU ODLUCUJEMO STO PRIKAZATI
 */
if(!isset($_GET['a'])) { $a = ''; } else { $a = $_GET['a']; }
switch($a){
    case 'kat': ispisClanakaUKategoriji(); break;
    case 'clanak': ispisJednogClanka(); break;
    case 'sortiraj': postaviSortiranje(); break;
    case 'spremi': spremiOcjenu(); break;
    case 'autor' : ispisClanakaAutora(); break;
    case 'tag'   : ispisClanakaTag(); break;
    case 'spremi': spremiOcjenu(); break;
    default: ispisClanaka(); break;
}
function ispisClanakaAutora()
{
	 global $c;
    $autor = $_GET['id'];
    $sql = "SELECT c.id, c.naslov, c.uvod, DATE_FORMAT(c.datum,'%d.%m.%Y u %H:%i') AS datum, c.pogledi, a.ime, a.prezime, k.naziv 
FROM clanci c 
LEFT JOIN kategorije k ON (c.vk_kategorije = k.id) 
LEFT JOIN korisnici a ON (c.vk_autora = a.id) 
WHERE a.id = $autor 
AND c.objavljen = 1";
if(isset($_COOKIE['kako'])){
    if($_COOKIE['kako']=='vrijeme') { $orderby = 'c.datum'; } else { $orderby = 'c.pogledi'; }
    $sql.=" ORDER BY $orderby DESC";
}
    $r = $c->query($sql);
    while($row = $r->fetch_assoc())
    {
            echo '<h2>Kategorija: '.$row['naziv'].'</h2>';
            echo '<p>';
            echo '<strong>'.$row['naslov'].'</strong></p>';
            echo '<p>'.$row['uvod'].'</p>';
            echo '<p><a href="?a=clanak&id='.$row['id'].'">više...</a>';
            echo '<p class="info">'
            . 'Objavljeno: '.$row['datum'].
                    ' - Pogleda:'.$row['pogledi'].
                    ' - Autor: '.$row['ime'].' '.$row['prezime'].
                    ' - Kategorija: '.$row['naziv'].'</p>';
    }
}


function ispisClanaka(){
    global $c;

$sql = "SELECT c.id, c.naslov, c.uvod, 
DATE_FORMAT(c.datum,'%d.%m.%Y u %H:%i') AS datum, 
c.pogledi,a.id AS aid, a.ime, a.prezime, k.naziv, c.suma_ocjena,
c.broj_ocjena 
FROM clanci c 
LEFT JOIN kategorije k ON (c.vk_kategorije = k.id) 
LEFT JOIN korisnici a ON (c.vk_autora = a.id) 
AND c.objavljen = 1";
if(isset($_COOKIE['kako'])){
    if($_COOKIE['kako']=='vrijeme') { $orderby = 'c.datum'; } else { $orderby = 'c.pogledi'; }
    $sql.=" ORDER BY $orderby DESC";
}
$r = $c->query($sql);
    while($row = $r->fetch_assoc())
    {
            
         echo ' <div class="blog-post">';
        
            echo '<h2 class="blog-post-title">'.$row['naslov'].'</h2>';
            echo '<p>'.$row['uvod'].'</p>';
            echo '<p><a href="?a=clanak&id='.$row['id'].'">više...</a>';
            echo '<p class="blog-post-meta">'
            . 'Objavljeno: '.$row['datum'].
                    ' - Pogleda:'.$row['pogledi'].
' - Autor: <a href="?a=autor&id='.$row['aid'].'">'.$row['ime'].' '.$row['prezime'].'</a>'.
                    ' - Kategorija: <strong>'.$row['naziv'].'</strong>';
					// ISPISI PROSJEK I BROJ GLASAČA OVDJE


    }
}

function ispisClanakaUKategoriji(){
    global $c;
    $kategorija = $_GET['id'];
    $sql = "SELECT c.id, c.naslov, c.uvod, DATE_FORMAT(c.datum,'%d.%m.%Y u %H:%i') AS datum, c.pogledi, a.ime, a.prezime, k.naziv 
FROM clanci c 
LEFT JOIN kategorije k ON (c.vk_kategorije = k.id) 
LEFT JOIN korisnici a ON (c.vk_autora = a.id) 
WHERE k.id = $kategorija 
AND c.objavljen = 1";
if(isset($_COOKIE['kako'])){
    if($_COOKIE['kako']=='vrijeme') { $orderby = 'c.datum'; } else { $orderby = 'c.pogledi'; }
    $sql.=" ORDER BY $orderby DESC";
}
    $r = $c->query($sql);
    while($row = $r->fetch_assoc())
    {
            echo '<h2>Kategorija: '.$row['naziv'].'</h2>';
            echo '<p>';
            echo '<strong>'.$row['naslov'].'</strong></p>';
            echo '<p>'.$row['uvod'].'</p>';
            echo '<p><a href="?a=clanak&id='.$row['id'].'">više...</a>';
            echo '<p class="info">'
            . 'Objavljeno: '.$row['datum'].
                    ' - Pogleda:'.$row['pogledi'].
                    ' - Autor: '.$row['ime'].' '.$row['prezime'].
                    ' - Kategorija: '.$row['naziv'].'</p>';
    }
}

function ispisClanakaTag(){
    global $c;
    $tag = $_GET['id'];
    $sql = "SELECT c.id, c.naslov, c.uvod, DATE_FORMAT(c.datum,'%d.%m.%Y u %H:%i') AS datum, c.pogledi, a.ime, a.prezime, k.naziv 
FROM clanci c 
LEFT JOIN kategorije k ON (c.vk_kategorije = k.id) 
LEFT JOIN korisnici a ON (c.vk_autora = a.id)
LEFT JOIN clanci_tagovi ct ON (ct.id_clanka = c.id)  
WHERE ct.id_taga = $tag 
AND c.objavljen = 1";
if(isset($_COOKIE['kako'])){
    if($_COOKIE['kako']=='vrijeme') { $orderby = 'c.datum'; } else { $orderby = 'c.pogledi'; }
    $sql.=" ORDER BY $orderby DESC";
}
    $r = $c->query($sql);
    while($row = $r->fetch_assoc())
    {
            echo '<h2>Kategorija: '.$row['naziv'].'</h2>';
            echo '<p>';
            echo '<strong>'.$row['naslov'].'</strong></p>';
            echo '<p>'.$row['uvod'].'</p>';
            echo '<p><a href="?a=clanak&id='.$row['id'].'">više...</a>';
            echo '<p class="info">'
            . 'Objavljeno: '.$row['datum'].
                    ' - Pogleda:'.$row['pogledi'].
                    ' - Autor: '.$row['ime'].' '.$row['prezime'].
                    ' - Kategorija: '.$row['naziv'].'</p>';
    }
}

function ispisJednogClanka(){
    global $c;
    $id = $_GET['id'];
    $sql = "SELECT * FROM clanci WHERE id = $id AND objavljen = 1 LIMIT 1";
    $r = $c->query($sql);
    $row = $r->fetch_assoc();
    
    echo ' <div class="blog-post">';
    echo '<h2 class="blog-post-title">'.$row['naslov'].'</h2>';
    echo '<p>'.$row['uvod'].'</p>';
    echo '<p>'.$row['tekst'].'</p>';
    echo '<p><a href="'.$_SERVER['SCRIPT_NAME'].'">natrag...</a>';
    echo ' <p class="blog-post-meta">Objavljeno: '.date('d.m.Y \u H:i',strtotime($row['datum'])).' Pogleda:'.$row['pogledi'].'</p>';
    
    
    inkrementirajBrojPrikaza($id);
	
	// OBRAZAC ZA OCJENU ISPOD
	echo '<form method="post" action="?a=spremi&id='.$id.'">';
	echo 'Ocjeni članak: <select name="ocjena">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
			</select>
			<input type="submit" value="Spremi">';
	echo '</form>';
        echo '</div>';
    
}

function spremiOcjenu()
{
	global $c;
	$ocjena = $_POST['ocjena'];
	$sql2 = "UPDATE clanci SET 
				broj_ocjena = broj_ocjena + 1 ,
				suma_ocjena = suma_ocjena + $ocjena,
			 WHERE id = ".$_GET['id'];
	$c->query($sql2);
	ispisJednogClanka();
}

function inkrementirajBrojPrikaza($id){
    global $c;
    $sql = "UPDATE clanci SET pogledi = pogledi+1 WHERE id = $id";
    $c->query($sql);
}

function postaviSortiranje(){
    $kako = $_GET['kako']; // DOHVATI NACIN SORTIRANJA IZ LINKA
    if(isset($_COOKIE['kako'])){ // AKO JE VEC POSTAVLJEN
       if($_COOKIE['kako']!=$kako){ setcookie('kako', $kako, time()+360000); } // POSTAVLJEN JE, ALI NA DRUGI NACIN SORTIRAJA, POSTAVI NA NOVI NACIN
    }
    else { // INACE, POSTAVI GA
        setcookie('kako', $kako, time()+360000);
    }
    
    echo '<p>Postavljeno sortiranje....<a href="'.$_SERVER['SCRIPT_NAME'].'">Početna</a></p>';
}
?>
        
        

        </div><!-- /.blog-main -->
        



        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          
            <div class="sidebar-module sidebar-module-inset">
            <h4>Sortiranje po:</h4>
            <ul>
                <li><a href="?a=sortiraj&kako=vrijeme">
		  Najnoviji</a></li>
                <li><a href="?a=sortiraj&kako=pogledi">
		  Najpopularniji</a></li>
            </ul>
          </div>
         
            
            <div class="sidebar-module">
            <h4>Kategorije</h4>
            <ol class="list-unstyled">
                <?php
                /*
                 * DESNI STUPAC
                 * NAVIGACIJA: KATEGORIJE
                 */

$sql = "SELECT * FROM kategorije";
$r = $c->query($sql);
while($row = $r->fetch_assoc())
{
	echo '<li>';
	echo '<a href="?a=kat&id='.$row['id'].'">'.$row['naziv'].'</a>';
	echo '</li>';
}
?>
            </ol>
          </div>
            
            
            
          <div class="sidebar-module">
            <h4>Tagovi</h4>
            <ol class="list-unstyled">
           <?php
           /*
            * DESNI STUPAC
            * NAVIGACIJA: Tagovi
            */
	// OVDJE ISPISATI TAGOVE KAO LINKOVE
	$sql = "SELECT 
 			COUNT(id_taga) AS broj, id_taga, naziv
			FROM  clanci_tagovi, tagovi 
			WHERE id_taga = id 
			GROUP BY id_taga";
	$r = $c->query($sql);
	while($row=$r->fetch_assoc())
	{
echo '<li>';
echo '<a href="?a=tag&id='.$row['id_taga'].'">'.$row['naziv'].'</a>';
echo ' ('.$row['broj'].')';
echo '</li>';
	}
?>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <div class="blog-footer">
      <p>TwitterClone</p>
      <p>
        &copy;
      </p>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/docs.min.js"></script>
  </body>
</html>
