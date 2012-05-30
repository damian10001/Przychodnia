<?php
$version = '1.0';
$encoding = 'utf-8';

$fp = fopen('pacjenci.txt', 'r');

$xml = new XMLWriter();
$xml->openUri('pacjenci.xml');
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument($version, $encoding);

$xml->startElement('pacjenci');
while($line = fgetcsv($fp, $length, '|')){
    if(count($line) < 7) continue;
    
    $xml->startElement('pacjent');
    $xml->writeElement('imie', $line[0]);
    $xml->writeElement('nazwisko', $line[1]);
    $xml->writeElement('email', $line[2]);
    $xml->writeElement('pesel', $line[3]);
    $xml->writeElement('nr_ubezpieczenia', $line[4]);
    $xml->writeElement('adres', $line[5]);
    $xml->writeElement('telefon', $line[6]);
    $xml->endElement();
}
$xml->endElement();