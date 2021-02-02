    <h2>DB-Ergebnis</h2>
    <div id="result_container">
<?php
    // Holen der Formular-Daten (die Schlüssel von Autor und Sprache)
    $ID = $_POST["ID_w"];

    // Inkludieren aller Skripte, damit diese Funktionen verfügbar sind
    include_once("include/connect_to_database.inc.php");
    include_once("include/show_table.inc.php");

    // Verbinden mit der Datenbank bibliothek
    $dblink = connect_to_database("mbi");
    // Query definieren und ausführen
    $date = date("Y-m-d");
    $query1 = "select max(WDatum) from Wartung where MNr = $ID; \n";
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
    
    $query11 = "select datediff('$date', '$maxWdatum'); \n";
    $result = mysqli_query($dblink, $query11);
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
    $datediff = $row[0];
    
    $query2 = "select sum(NZeit), MWI \n";
    $query2 .= "    from Maschine as M \n";
    $query2 .= "    join Nutzung as N using(MNr) \n";
    $query2 .= "where MNr = $ID AND NDatum > '$maxWdatum' \n";
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
    $row = mysqli_fetch_row($result);
    $outNzeit = $row[0];
    $outMWI = $row[1];
    if ($outNzeit == "") {
        $outNzeit = 0;
    }

        
    $query3 = "select WNr as Wartung, WDatum as Wartungsdatum, WHinweis as Wartungshinweis from Wartung where MNr = $ID; \n";
    $result = mysqli_query($dblink, $query3);
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
    show_table($bdlink, $result, $query3);
    echo "<p>letzte Wartung vor $datediff Tagen</p>";
    echo "<p>Nutzungszeit seit letzter Wartung: $outNzeit</p>";
    if ($outNzeit > $outMWI) {
        echo "<p>Wartungsstatus: <font color=red>WARTUNG ERFORDERLICH!</font></p>";
    } else {
        echo "<p>Wartungsstatus: <font color=green>OK</font></p>";
    }




    // Anzeige des Ergebnisses.

?>
    </div>
