<?php
phpinfo();
if( ini_get('allow_url_fopen') ) {
    die('allow_url_fopen is enabled. file_get_contents should work well');
} else {
    die('allow_url_fopen is disabled. file_get_contents would not work');
}
exit;
	$host = "localhost";
	$user = "programaction";
	$pass = "XJaMEJ3ZRUn";
	$dbname = "rds";
	
	if ($_SERVER['SERVER_NAME']=="localhost")  {
		$host = "localhost";
		$user = "root";
		$pass = "";
		$dbname = "auroyaumedessons_web";
	} 
	
	$link=mysql_connect($host,$user,$pass) or die("Acces denied on server");
	@mysql_select_db($dbname) or die("Acces denied on server");
	
	mysql_set_charset('utf8');
	
	$sql = "SELECT users.*, licences.date_expiration_licence FROM users 
	JOIN licences ON users.id_licence=licences.id_licence AND licences.date_expiration_licence <= CURDATE() AND licences.date_expiration_licence<>0 ORDER BY licences.date_expiration_licence DESC";
	$req = mysql_query($sql) or die(mysql_error().'<br>'.$sql);
	if (mysql_num_rows($req)>0) {
		echo '<strong>'.mysql_num_rows($req).'</strong><br>';
		$nbReq=0;
		while ($enr=mysql_fetch_assoc($req)) {
			$id_usager=$enr['id_usager'];
			
			$sqldel="DELETE FROM resultats WHERE id_usager='$id_usager'";
			mysql_query($sqldel) or die(mysql_error().'<br>'.$sqldel);
			
			$sqldel="DELETE FROM users_progression WHERE id_usager='$id_usager'";
			mysql_query($sqldel) or die(mysql_error().'<br>'.$sqldel);
			
			$sqldel="DELETE FROM users_recompenses WHERE id_usager='$id_usager'";
			mysql_query($sqldel) or die(mysql_error().'<br>'.$sqldel);
			
			$sqldel="DELETE FROM users_ca_recompenses WHERE id_usager='$id_usager'";
			mysql_query($sqldel) or die(mysql_error().'<br>'.$sqldel);
			
			$sqldel="DELETE FROM users WHERE id_usager='$id_usager'";
			mysql_query($sqldel) or die(mysql_error().'<br>'.$sqldel);
			
		}
		echo $nbReq;
		$sqldel="DELETE FROM licences WHERE date_expiration_licence <= CURDATE() AND date_expiration_licence<>0";
		mysql_query($sqldel) or die(mysql_error().'<br>'.$sqldel);
	}
?>