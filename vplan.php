<?php
$output = array();
for($i = 0; $i < 2; $i++){
$today = date("w")+$i;
switch ($today){
	case 1: //Montag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLmontag.htm");
	break;
	case 2: //Dienstag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLdienst.htm");
	break;
	case 3: //Mittwoch
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLmittwo.htm");
	break;
	case 4: //Donnerstag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLdonner.htm");
	break;
	case 5: //Freitag
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLfreita.htm");
	$i = 1;
	break;
	default:
	$html = file_get_contents("http://www.otto-nagel-gymnasium.de/joomla158/plaene/KLmontag.htm");
	$i = 1;
	break;
}

if(strlen($html)){

$daten = array();
$count = 0;
$start = strpos($html, 'align="center">Vertretungsplan f&uuml;r ')+40;
$html = substr($html, $start);
$end = strpos($html, "</h2>");
$datum = substr($html, 0, $end);

$start = strpos($datum, ' ');
$end = strpos($datum, '.');
$tag = substr($datum, $start, $end-$start);
$datum = substr($datum, $end-+1);
$end = strpos($datum, ' ');
$monat = substr($datum, 0, $end);
$monatszahl = 0;

switch ($monat){
	case "Januar": 
	$monatszahl = 1;
	break;
	case "Februar":
	$monatszahl = 2;
	break;
	case "M&aumlrz":
	$monatszahl = 3;
	break;
	case "April":
	$monatszahl = 4;
	break;
	case "Mai":
	$monatszahl = 5;
	break;
	case "Juni":
	$monatszahl = 6;
	break;
	case "Juli":
	$monatszahl = 7;
	break;
	case "August":
	$monatszahl = 8;
	break;
	case "September":
	$monatszahl = 9;
	break;
	case "Oktober":
	$monatszahl = 10;
	break;
	case "November":
	$monatszahl = 11;
	break;
	case "Dezember":
	$monatszahl = 12;
	break;
}

if($tag >= date("j") || $monatszahl > date("n")){
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
		$stunde = str_replace("1. Std.", "1. Block", $stunde);
		$stunde = str_replace("3. Std.", "2. Block", $stunde);
		$stunde = str_replace("5. Std.", "3. Block", $stunde);
		$stunde = str_replace("7. Std.", "4. Block", $stunde);
		$stunde = str_replace("9. Std.", "5. Block", $stunde);
		if($i == 0){$stunde = "Heute, ".$stunde;}
		else {
			if($today > 0 && $today < 5){$stunde = "Morgen, ".$stunde;}	
			else 
			{$stunde = "Montag, ".$stunde;}
			
		$html = substr($html, $end+5);
		if($stunde == $daten[$count]["daten"][$count2]["stunde"])
		{
			$count3++;
		}
		
		else{
			$count3 = 0;
			$count2++;
		}
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

array_push($output, $daten);

}
}
}
echo json_encode($output);
