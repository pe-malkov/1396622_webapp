    <h2>DB-Ergebnis</h2>
    <div id="result_container">
<?php
    // Holen der Formular-Daten (die Schlüssel von Autor und Sprache)
    $MNr = $_POST["ID_en"];
    $NDatum = $_POST["NDatum_e"];
    $NDauer = $_POST["NDauer_e"];
    // Inkludieren aller Skripte, damit diese Funktionen verfügbar sind
    include_once("include/connect_to_database.inc.php");
    include_once("include/show_table.inc.php");

    // Verbinden mit der Datenbank bibliothek
    $dblink = connect_to_database("mbi");
    // Query definieren und ausführen
    $insert = "INSERT INTO Nutzung (MNr, NDatum, NZeit) VALUES ('$MNr', '$NDatum', '$NDauer');";
    $result = mysqli_query($dblink, $insert);
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
    } else {
        $lastID = mysqli_insert_id($dblink);
        echo "<p>Nutzungseintrag Erfolgreich</p>";
        echo "<p>Nutzung eingetragen unter der Nutzungs-ID: $lastID</p>";
    }
    
?>

