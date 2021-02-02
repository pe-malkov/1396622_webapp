    <h2>DB-Ergebnis</h2>
    <div id="result_container">
<?php
    // Holen der Formular-Daten (die Schlüssel von Autor und Sprache)
    $MNr_d = $_POST["ID_d"];
    // Inkludieren aller Skripte, damit diese Funktionen verfügbar sind
    include_once("include/connect_to_database.inc.php");
    include_once("include/show_table.inc.php");

    // Verbinden mit der Datenbank bibliothek
    $dblink = connect_to_database("mbi");
    
    $delete = "delete \n";
    $delete .= "    from Nutzung \n";
    $delete .= "where MNr = $MNr_d;";
    $result = mysqli_query($dblink, $delete);
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
        echo "<p>Nutzungseinträge Erfolgreich entfernt</p>";
    }

    // Query definieren und ausführen
    $delete = "delete \n";
    $delete .= "    from Wartung \n";
    $delete .= "where MNr = $MNr_d;";
    $result = mysqli_query($dblink, $delete);
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
        echo "<p>Wartungseinträge Erfolgreich entfernt</p>";
    }

        $delete = "delete \n";
    $delete .= "    from Maschine \n";
    $delete .= "where MNr = $MNr_d;";
    $result = mysqli_query($dblink, $delete);
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
        echo "<p>Maschineneintrag Erfolgreich entfernt</p>";
    }
?>
    </div>
