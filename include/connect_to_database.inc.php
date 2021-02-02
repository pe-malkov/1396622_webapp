<?php
function  connect_to_database($dbname) {
	$dbuser='root';
	$dbpasswd='xyz';
	$dbhost='localhost';

	// Versuche, Datenbank $dbname zu öffnen
	$dblink = @mysqli_connect($dbhost, $dbuser, $dbpasswd, $dbname);

	if (!$dblink) {
		// Fehlermeldung  in einer Seite
		$meldung = "Fehler beim verbinden mit der Datenbank!";

		echo "<html>
			<head><title>$meldung</title></head>
			<body><h1>$meldung</h1></body>
			</html>\n";
		exit();
	}
	// Zeichensatz einstellen. In Linux: utf8 (In Win: latin1)
	mysqli_set_charset($dblink, "utf8");
	return $dblink;
}
?>
