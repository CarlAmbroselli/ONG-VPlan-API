<?php
$today = date("w");

switch ($_GET["tag"]){
	case "Montag": //Montag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLmontag.htm");
	break;
	case "Dienstag": //Dienstag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLdienst.htm");
	break;
	case "Mittwoch": //Mittwoch
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLmittwo.htm");
	break;
	case "Donnerstag": //Donnerstag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLdonner.htm");
	break;
	case "Freitag": //Freitag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLfreita.htm");
	break;
}

if(strlen($html)){

$daten = array();
$count = 0;

$start = strpos($html, 'align="center">Vertretungsplan f&uuml;r ')+40;
$html = substr($html, $start);
$end = strpos($html, "</h2>");
$datum = substr($html, 0, $end);

$start = strpos($html, '<th><h2>Vertretungen</h2></th></tr><tr><td>&nbsp;<br>')+53;
$html = substr($html, $start);
$end = strpos($html, "<br>&nbsp;</td></tr><tr><td>");
$sonderinfos = substr($html, 0, $end);

echo $sonderinfos;

}
