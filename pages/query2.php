    <h2>DB-Ergebnis</h2>
    <div id="result_container">
<?php
    // Holen der Formular-Daten (die Schlüssel von Autor und Sprache)
    $ID = $_POST["ID_n"];

    
    // Inkludieren aller Skripte, damit diese Funktionen verfügbar sind
    include_once("include/connect_to_database.inc.php");
    include_once("include/show_table.inc.php");

    // Verbinden mit der Datenbank bibliothek
    $dblink = connect_to_database("mbi");
    // Query definieren und ausführen
    // Wir wollen von dem Autor alle Titel in der Sprache (sortiert!)
    $query1 = "select max(WDatum) from Wartung where MNr = $ID";
    $result = mysqli_query($dblink, $query1);
    if ($result == FALSE) {
        echo "<p><b>Fehler im SQL-Kommando.</b></p>\n";
		echo "<p>\n";
		if ($query) {
			echo "<b>Das Kommando:</b><br />\n";
			echo "<pre>\n$query\n</pre>\n";
		}
		echo "<b>Fehlermeldung:</b>\n";
		echo "<pre>".mysqli_error($dblink)."</pre>\n";
		echo "</p>";
		return;
	}
	$row = mysqli_fetch_row($result);
	$maxWdatum = $row[0];
	
    if ($_POST["wdat"] == "on") {
        $zRaum = $maxWdatum;
    } else {
        $zRaum = $_POST["NDatum_n"];
    }
    
    $query2 = "select NNr as Nutzung, NDatum as Nutzungsdatum, NZeit as 'Nutzungsdauer [h]' from Nutzung \n";
    if ($zRaum != 0) {
        $query2 .= "where MNr = $ID AND NDatum > '$zRaum'";
    } else {
        $query2 .= "where MNr = $ID AND NDatum > '$maxWdatum'";
    }
    $result = mysqli_query($dblink, $query2);
    if ($result == FALSE) {
        echo "<p><b>Fehler im SQL-Kommando.</b></p>\n";
		echo "<p>\n";
		if ($query) {
			echo "<b>Das Kommando:</b><br />\n";
			echo "<pre>\n$query\n</pre>\n";
		}
		echo "<b>Fehlermeldung:</b>\n";
		echo "<pre>".mysqli_error($dblink)."</pre>\n";
		echo "</p>";
		return;
	}
    show_table($bdlink, $result, $query2);


    // Anzeige des Ergebnisses.

?>
    </div>
