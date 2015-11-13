<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
if($_POST)
{
	require_once('db.php');
	$c = db();
	$z = $_POST['zemlja']; 
	$upit = "SELECT * FROM korisnici WHERE vk_zemlje = '$z'";
	$r = $c->query($upit); 
	echo '<table width="90%" border="0" cellspacing="0" cellpadding="4">';
	while($red = $r->fetch_assoc())
	{
	echo '<tr>';
    echo '<td>'.$red['oib'].'</td>';
    echo '<td>'.$red['ime'].'</td>';
    echo '<td>'.$red['prezime'].'</td>';
    echo '<td>'.$red['username'].'</td>';
	echo '<td>'.$red['vk_zemlje'].'</td>';
	echo '<td>'.$red['vk_tip'].'</td>'; 
  	echo '</tr>';
	}
	echo '</table>';
		$r->free();
	$c->close();

	
	

}
else
{
	require_once('db.php');
	$c = db();
	echo '<form id="form1" name="form1" method="post" action="">
  <label>'; 
  padajuca('country', 'korisnici', 'Code', 'vk_zemlje', 'Name', 'zemlja' );
  echo '
  <input type="submit" name="button" id="button" value="Submit" />
  </label>
</form>'; 
	

}

?>

</body>
</html>
