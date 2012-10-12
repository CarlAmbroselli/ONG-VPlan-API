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

$startk = strpos($html, '<h3>')+4;
$starts = strpos($html, '<h4>')+4;

while($startk > 4 && $starts > 4){
	$html = substr($html, $startk);
	$end = strpos($html, "</h3>");
	$daten[$count]["klasse"] = substr($html, 0, $end);
	
	$starts = strpos($html, '<h4>')+4;
	$count2 = 0;
	$count3 = 0;
	while($starts > 4 && $starts < $startk){
		$html = substr($html, $starts);
		$end = strpos($html, "</h4>");
		$stunde = substr($html, 0, $end);
		$html = substr($html, $end+5);
		if($stunde == $daten[$count]["daten"][$count2]["stunde"])
		{
			$count3++;
		}
		
		else{
			$count3 = 0;
			$count2++;
			$daten[$count]["daten"][$count2]["stunde"] = $stunde;
		}
		
		$end = strpos($html, '    --&#8250;  ');
		$daten[$count]["daten"][$count2]["info"][$count3]["alt"] = substr($html, 0, $end);
		$html = substr($html, $end+15);	
		$end = strpos($html, '</li>');
		$daten[$count]["daten"][$count2]["info"][$count3]["neu"] = substr($html, 0, $end);		
		$html = substr($html, $end);
		$starts = strpos($html, '<h4>')+4;
		$startk = strpos($html, '<h3>')+4;
	}
	$count++;
	$startk = strpos($html, '<h3>')+4;
	$starts = strpos($html, '<h4>')+4;
}

echo json_encode($daten);

}
