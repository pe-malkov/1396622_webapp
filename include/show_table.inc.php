<?php
function  show_table($dblink, $result, $query = false) {
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
	$rows = mysqli_num_rows($result);
	$cols = mysqli_num_fields($result);

	if ($rows > 0) {
		echo "<table border=1>\n";
		echo "<tr>\n";
		for ($i = 0; $i < $cols; $i++) {
			$field = mysqli_fetch_field_direct($result, $i);   
			echo "<th>".htmlentities($field->name)."</th>\n";
		}
		echo "</tr>\n";

		while ($row = mysqli_fetch_row($result)) {
			echo "<tr>\n";
			for ($i = 0; $i < $cols; $i++) {
				echo "<td>".htmlentities($row[$i])."</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table><p>\n";
	}
	else {
		echo "<p><b>Leere Ergebnistabelle!</b></p>\n";
	}
}
?>
