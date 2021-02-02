<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>WZM-DB Menu</title>
	<link rel="stylesheet" type="text/css" href="css/view.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/menu.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/query.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/tcal.css" media="all" />
	<script type="text/javascript" src="js/view.js"></script>
	<script type="text/javascript" src="js/tcal.js"></script>
</head>

<body id="main_body" >

<!-- Kopfbereich -->
<div id=kopfbereich>
	<p>WZM-DB</p>
	<hr>
</div> <!-- Ende kopfbereich -->


<!-- Menüspalte -->
<div id=menuSpalte>
	<!-- Das Aussehen wird in der CSS-Datei menu.css festgelegt! -->
	<a href="?goto=uebersicht" class="menulink">Übersicht</a> <p>
	<a href="?goto=nutzung" class="menulink">Nutzung</a></p>
	<a href="?goto=wartung" class="menulink">Wartung</a></p>
    <a href="?goto=eintrag_typ" class="menulink">WZM-Typ Hinzufügen</a></p>
    <a href="?goto=eintrag_maschine" class="menulink">WZM Hinzufügen</a></p>
    <a href="?goto=eintrag_nutzung" class="menulink">Nutzung eintragen</a></p>
    <a href="?goto=eintrag_wartung" class="menulink">Wartung eintragen</a></p>
    <a href="?goto=entf_maschine" class="menulink">WZM Entfernen</a></p>
</div> <!-- Ende menuSpalte -->

<!-- Inhalt -->
<div id=inhalt>
	<!-- Das, was anzuzeigen ist -->

<?php
	session_start();
	include_once("include/meineFunktionen.php");

	$wohin = false;
	if (isset($_REQUEST["goto"])) {
		$wohin = !empty($_REQUEST["goto"]) ? $_REQUEST["goto"] : false;
	}

	if ($wohin == false) {
		echo "<p><h2 id='passtnicht'>Bitte wählen Sie einen Query aus dem Menü<h2></p>";
	}
	else {
		$rc = @include_once("pages/$wohin.php");
		if ($rc == false)
			@include_once("pages/$wohin.html");
	}
?>

</div> <!-- Ende inhalt -->

</body>
</html>
