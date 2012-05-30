<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap('db');



//uzupełnienie bazy danych o informacje
$Informacja = new Application_Model_DbTable_Informacje();
$Informacja->delete('');

$xml = simplexml_load_file('../data/txt2xml/informacje.xml');
foreach ($xml->informacja as $inf){
    $dane = (array) $inf;
    try {
	$inf_id = $Informacja->createRow($dane)->save();
    } catch (Zend_Db_Statement_Exception $e) {
	die($e->getMessage());
    }
}

//uzupełnienie bazy danych o specjalizacje i lekarzy
$Specjalizacja = new Application_Model_DbTable_Specjalizacja();
$Lekarz = new Application_Model_DbTable_Lekarz();
$LekarzHasSpecjalizacja = new Application_Model_DbTable_LekarzHasSpecjalizacja();
$LekarzHasSpecjalizacja->delete('');
$Lekarz->delete('');
$Specjalizacja->delete('');

$xml = simplexml_load_file('../data/txt2xml/specjalizacje.xml');
foreach ($xml->specjalizacja as $s){
    $dane = (array) $s;
    try {
	$specjalizacja_id = $Specjalizacja->insertIfNotExists($dane);
    } catch (Zend_Db_Statement_Exception $e) {
	die ($e->getMessage());
    }
    foreach ($s->lekarz as $lek){
	$dane = (array) $lek;
	try {
	    $lekarz_id = $Lekarz->insertIfNotExists($dane);
	} catch (Zend_Db_Statement_Exception $e) {
	    die ($e->getMessage());
	}
	
	$dane = array(
	    'specjalizacja_id' => $specjalizacja_id,
	    'lekarz_id' => $lekarz_id
	);
	try {
	    $LekarzHasSpecjalizacja->createRow($dane)->save();
	} catch (Zend_Db_Statement_Exception $e) {
	    die($e->getMessage());
	}
    }
}

//uzupełnienie bazy danych o godziny przyjęć lekarzy
$GodzinyPrzyjec = new Application_Model_DbTable_GodzinyPrzyjec();
$Lekarz = new Application_Model_DbTable_Lekarz();
$GodzinyPrzyjec->delete('');

$xml = simplexml_load_file('../data/txt2xml/godziny_przyjec.xml');
foreach ($xml->lekarz as $lek){
    $dane = (array) $lek;
    try {
	$lekarz_id = $Lekarz->insertIfNotExists($dane);
    } catch (Zend_Db_Statement_Exception $e) {
	die ($e->getMessage());
    }
    
    foreach ($lek->godzina_przyjec as $gp){
	$dane = (array) $gp;
	$dane['lekarz_id'] = $lekarz_id;
	
	try {
	    $GodzinyPrzyjec->createRow($dane)->save();
	} catch (Zend_Db_Statement_Exception $e) {
	    die($e->getMessage());
	}	
    }
}

//uzupełnienie bazy danych o pacjentów
$Pacjent= new Application_Model_DbTable_Pacjent();
$Pacjent->delete('');

$xml = simplexml_load_file('../data/txt2xml/pacjenci.xml');
foreach ($xml->pacjent as $pac){
    $dane = (array) $pac;
    try {
	$Pacjent->createRow($dane)->save();
    } catch (Zend_Db_Statement_Exception $e) {
	die($e->getMessage());
    }
}

//uzupełnienie bazy danych o historię choroby pacjentów
$HistoriaChoroby = new Application_Model_DbTable_HistoriaChoroby();
$Pacjent = new Application_Model_DbTable_Pacjent();
$HistoriaChoroby->delete('');

$xml = simplexml_load_file('../data/txt2xml/historia_choroby.xml');
foreach ($xml->historia_choroby as $his){
    $dane = (array) $his;
    
    $dane2 = (array) $his->pacjent;
    try {
	$pacjent_id = $Pacjent->insertIfNotExists($dane2);
    } catch (Zend_Db_Statement_Exception $e) {
	die ($e->getMessage());
    }
	
    $dane['pacjent_id'] = $pacjent_id;
    try {
        $HistoriaChoroby->createRow($dane)->save();
    } catch (Zend_Db_Statement_Exception $e) {
        die($e->getMessage());
    }
}

//uzupełnienie bazy danych o wizyty
$Pacjent = new Application_Model_DbTable_Pacjent();
$Lekarz = new Application_Model_DbTable_Lekarz();
$Wizyta = new Application_Model_DbTable_Wizyta();
$Wizyta->delete('');

$xml = simplexml_load_file('../data/txt2xml/wizyty.xml');
foreach ($xml->wizyta as $wiz){
    $dane = (array) $wiz;
    
    $dane2 = (array) $wiz->lekarz;
    try {
	$lekarz_id = $Lekarz->insertIfNotExists($dane2);
    } catch (Zend_Db_Statement_Exception $e) {
	die ($e->getMessage());
    }
    $dane['lekarz_id'] = $lekarz_id;
    
    $dane3 = (array) $wiz->pacjent;
    try {
        $pacjent_id = $Pacjent->insertIfNotExists($dane3);
    } catch (Zend_Db_Statement_Exception $e) {
        die($e->getMessage());
    }
    $dane['pacjent_id'] = $pacjent_id;
    
    try {
        $Wizyta->createRow($dane)->save();
    } catch (Zend_Db_Statement_Exception $e) {
        die($e->getMessage());
    }
}