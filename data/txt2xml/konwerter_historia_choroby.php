<?php
$version = '1.0';
$encoding = 'utf-8';

$fp = fopen('historia_choroby.txt', 'r');

$xml = new XMLWriter();
$xml->openUri('historia_choroby.xml');
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument($version, $encoding);

$xml->startElement('historie_chorob');
while($line = fgetcsv($fp, $length, '|')){
    if(count($line) < 7) continue;
    
    $xml->startElement('historia_choroby');
    $xml->writeElement('nazwa', $line[0]);
    $xml->writeElement('opis_choroby', $line[1]);
    $xml->writeElement('data', $line[2]);
	$xml->startElement('pacjent');
	$xml->writeElement('imie', $line[3]);
	$xml->writeElement('nazwisko', $line[4]);
	$xml->writeElement('email', $line[5]);
	$xml->writeElement('pesel', $line[6]);
	$xml->endElement();
    $xml->endElement();
}
$xml->endElement();