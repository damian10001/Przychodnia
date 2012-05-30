<?php
$version = '1.0';
$encoding = 'utf-8';

$fp = fopen('informacje.txt', 'r');

$xml = new XMLWriter();
$xml->openUri('informacje.xml');
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument($version, $encoding);

$xml->startElement('informacje');
while($line = fgetcsv($fp, $length, '|')){
    if(count($line) < 5) continue;
    
    $xml->startElement('informacja');
    $xml->writeElement('data', $line[0]);
    $xml->writeElement('czas', $line[1]);
    $xml->writeElement('tytul', $line[2]);
    $xml->writeElement('tresc', $line[3]);
    $xml->writeElement('autor', $line[4]);
    $xml->endElement();
}
$xml->endElement();