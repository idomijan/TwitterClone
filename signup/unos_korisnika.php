<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
  

    <title>RIPOFF!</title>

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
         
          <a class="blog-nav-item" href="/../TwitterClone1/TwitterClone">Twitter Clone</a>
          <a class="blog-nav-item" href="/../TwitterClone1/TwitterClone/admin">Administracija</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Twitter Clone</h1>
        <p class="lead blog-description" > Društvena mreža</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

<body>
<?php
if($_POST)
{
	require_once('db.php');
	$c = db();
	$ime = $_POST['ime']; 
	$prezime = $_POST['prezime']; 
	$username = $_POST['username']; 
	$password = md5($_POST['password']); 

	$tip = $_POST['vk_tip']; 
	$oib = $_POST['oib'];
	
	$unos = "INSERT INTO korisnici (ime, prezime, username, password, vk_tip, oib) VALUES ('$ime', '$prezime', '$username', '$password', $tip, $oib)"; 
	
	$c->query($unos); 
	
	if($c->errno)
	{
		echo 'Errrror!!!!!!!! '; 
	}
	
	else
	{
	echo 'Uspjesno ste obavili unos <br>'; 
	$pregled = 'SELECT * FROM korisnici ORDER BY prezime';
	$r = $c->query($pregled);
	echo '<table width="90%" border="0" cellspacing="0" cellpadding="4">';
	while($red = $r->fetch_assoc())
	{
	echo '<tr>';
    echo '<td>'.$red['oib'].'</td>';
    echo '<td>'.$red['ime'].'</td>';
    echo '<td>'.$red['prezime'].'</td>';
    echo '<td>'.$red['username'].'</td>';
	echo '<td>'.$red['password'].'</td>';
	echo '<td>'.$red['vk_tip'].'</td>'; 
  	echo '</tr>';
	}
	echo '</table>';
	$r->free();
	
	echo '<a href="unos_osoba.php">Unos jos osoba</a>';
	}	
	$c->close();
}
else
{
require_once('db.php');
$c = db();
echo '
<form id="form1" name="form1" method="post" action="">
  <fieldset>
  <legend>Unos korisnika</legend>
  <p>Ime: 
    <label>
    <input type="text" name="ime" id="ime" />
    </label>
  </p>
  <p>Prezime: 
    <label>
    <input type="text" name="prezime" id="prezime" />
    </label>
  </p>
  <p>Username(: 
    <label>
    <input name="username" type="text" id="username" value="" />
    </label>
  </p>
  <p>Password: 
    <label>
    <input name="password" type="text" id="password" value="" />
    </label>
  </p>
  <p>OIB: 
    <label>
    <input name="oib" type="text" id="oib" maxlength="11" />
    </label>
  </p>
  <label <p> Tip korisnika:';
  select('tip_korisnika', 'id', 'naziv', 'vk_tip'); 
  echo '
  <p>
    <label>
    <input type="submit" name="button" id="button" value="Submit" />
    </label>
  </p>
  
  
  </fieldset>
  </form>';
$c->close(); 
}

?>


</body>
</html>
