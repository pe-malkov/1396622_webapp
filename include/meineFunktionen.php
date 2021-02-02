<?php
function datum2edv($datum)
{
	$dteile = preg_split("/[.]/", $datum);
	$edvdatum = $dteile[2]."-".$dteile[1]."-".$dteile[0];
	return $edvdatum;
}
?>
