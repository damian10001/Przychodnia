<?php
$version = '1.0';
$encoding = 'utf-8';

$fp = fopen('specjalizacje.txt', 'r');

$xml = new XMLWriter();
$xml->openUri('specjalizacje.xml');
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument($version, $encoding);

$xml->startElement('specjalizacje');
while($line = fgetcsv($fp, $length, '|')){
    if(count($line) < 8) continue;
    
    $xml->startElement('specjalizacja');
    $xml->writeElement('nazwa', $line[0]);
	$xml->startElement('lekarz');
	$xml->writeElement('imie', $line[1]);
	$xml->writeElement('nazwisko', $line[2]);
	$xml->writeElement('email', $line[3]);
	$xml->writeElement('pesel', $line[4]);
	$xml->writeElement('adres', $line[5]);
	$xml->writeElement('telefon', $line[6]);
	$xml->writeElement('nr_gabinetu', $line[7]);
	$xml->endElement();
    $xml->endElement();
	
}
$xml->endElement();