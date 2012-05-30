<?php
$version = '1.0';
$encoding = 'utf-8';

$fp = fopen('wizyty.txt', 'r');

$xml = new XMLWriter();
$xml->openUri('wizyty.xml');
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument($version, $encoding);

$xml->startElement('wizyty');
while($line = fgetcsv($fp, $length, '|')){
    if(count($line) < 13) continue;
    
    $xml->startElement('wizyta');
    $xml->writeElement('data', $line[0]);
    $xml->writeElement('czas', $line[1]);
    $xml->writeElement('opis_wizyty', $line[2]);
    $xml->writeElement('recepta', $line[3]);
    $xml->writeElement('czy_odbyta', $line[4]);
	$xml->startElement('lekarz');
	$xml->writeElement('imie', $line[5]);
	$xml->writeElement('nazwisko', $line[6]);
	$xml->writeElement('email', $line[7]);
	$xml->writeElement('pesel', $line[8]);
	$xml->endElement();
	$xml->startElement('pacjent');
	$xml->writeElement('imie', $line[9]);
	$xml->writeElement('nazwisko', $line[10]);
	$xml->writeElement('email', $line[11]);
	$xml->writeElement('pesel', $line[12]);
	$xml->endElement();
    $xml->endElement();
	
}
$xml->endElement();