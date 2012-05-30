<?php

$version = '1.0';
$encoding = 'utf-8';

$fp = fopen('godziny_przyjec.txt', 'r');

$xml = new XMLWriter();
$xml->openUri('godziny_przyjec.xml');
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument($version, $encoding);

$xml->startElement('godziny_przyjec');
while ($line = fgetcsv($fp, $length, '|')) {
    if (count($line) < 7)
	continue;

    $xml->startElement('lekarz');
    $xml->writeElement('imie', $line[0]);
    $xml->writeElement('nazwisko', $line[1]);
    $xml->writeElement('email', $line[2]);
    $xml->writeElement('pesel', $line[3]);
	$xml->startElement('godzina_przyjec');
	$xml->writeElement('dzien_tygodnia', $line[4]);
	$xml->writeElement('godzina_od', $line[5]);
	$xml->writeElement('godzina_do', $line[6]);
	$xml->endElement();
    $xml->endElement();
}
$xml->endElement();