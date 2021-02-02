    <h2>DB-Ergebnis</h2>
    <div id="result_container">
<?php
    // Holen der Formular-Daten (die Schlüssel von Autor und Sprache)
    $typ = $_POST["Typ_u"];

    // Inkludieren aller Skripte, damit diese Funktionen verfügbar sind
    include_once("include/connect_to_database.inc.php");
    include_once("include/show_table.inc.php");

    // Verbinden mit der Datenbank bibliothek
    $dblink = connect_to_database("mbi");
    

    // Query definieren und ausführen
    // Wir wollen von dem Autor alle Titel in der Sprache (sortiert!)
    $query1 = "select MNr from Maschine \n";
    if ($typ != 0) {
        $query1 .= "where TypNr = $typ \n";
        $query1 .= "order by MNr;";
    } else {
        $query1 .= "order by MNr;";
    }
    $result1 = mysqli_query($dblink, $query1);
    if ($result1 == FALSE) {
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
    $mCount = mysqli_num_rows($result1);
    //echo "Typ: $typ \n";
    echo "<p>\n";
    echo "<table border=1>\n";
    echo "<tr>\n";
    echo "<th>ID</th>\n";
    echo "<th>Typ</th>\n";
    echo "<th>Standort</th>\n";
    echo "<th>genutzt seit<br />letzter Wartung [h]</th>\n";
    echo "<th>Wartungdatum</th>\n";
    echo "<th>MWI<br />[h]</th>\n";
    echo "<th>Wartungsstatus</th>\n";
    echo "</tr>\n";
    
    for ($i = 1; $i <= $mCount; $i++) {
        $MNr = mysqli_fetch_row($result1); //fetch holt sich den nächsten Eintrag!
        $query2 = "select MNr, max(WDatum) from Wartung where MNr = $MNr[0]; \n";
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
//       show_table($dblink, $result, $query2);
        $row = mysqli_fetch_row($result);
        $maxWdatum = $row[1];
        $query3 = "select MNr, MTyp, MOrt, sum(NZeit), MWI \n";
        $query3 .= "    from Maschine as M \n";
        $query3 .= "    join Maschinentyp as T using(TypNr) \n";
        $query3 .= "    join Nutzung as N using(MNr) \n";
        $query3 .= "where MNr = $MNr[0] AND NDatum > '$maxWdatum' \n";
/*        if ($typ != 0) {
            $query3 .= "AND TypNr = $typ;";
        }
*/        
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
        $row = mysqli_fetch_row($result);
        $outId = $row[0];
        $outTyp = $row[1];
        $outOrt = $row[2];
        $outNzeit = $row[3];
        $outMWI = $row[4];
        if ($outNzeit == "") {
            $outNzeit = 0;
        }
        echo "<tr>\n";
        echo "<td>".htmlentities($outId)."</td>\n";
        echo "<td>".htmlentities($outTyp)."</td>\n";
        echo "<td>".htmlentities($outOrt)."</td>\n";
        echo "<td>".htmlentities($outNzeit)."</td>\n";
        echo "<td>".htmlentities($maxWdatum)."</td>\n";
        echo "<td>".htmlentities($outMWI)."</td>\n";
        if ($outMWI <= $outNzeit) {
            echo "<td><font color=red>WARTUNG!</font></td>\n";
        } else {
            echo "<td><font color=green>OK</font></td>\n";
        }
        echo "</tr>\n";
        
        
        
    }
    
    echo "</table></p>\n";
 /*   
    $query3 =  "select MNr as MaschinenID, MTyp as Maschinentyp, MWI as Wartungsintervall, MOrt as Standort\n";
    $query3 .= "     from Maschine as M \n";
    $query3 .= "     join Maschinentyp as T using(TypNr) \n";
    if ($typ != 0) {
        $query3 .= "WHERE TypNr = $typ \n";
    }

    $result = mysqli_query($dblink, $query3);
    show_table($dblink, $result, $query3);
*/
    // Anzeige des Ergebnisses.

?>
    </div>
