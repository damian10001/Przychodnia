<?php

class Application_Model_DbTable_LekarzHasSpecjalizacja extends Zend_Db_Table_Abstract
{
    protected $_name = 'lekarz_has_specjalizacja';
    
    //relacja n:m tabel 'lekarz' i 'specjalizacja'
    protected $_referenceMap = array(
	'Lekarz' => array(
	    'columns'		=> array('lekarz_id'),
	    'refTableClass'	=> 'Application_Model_DbTable_Lekarz',
	    'refTableColumns'	=> array('lekarz_id')
	),
	'Specjalizacja' => array(
	    'columns'		=> array('specjalizacja_id'),
	    'refTableClass'	=> 'Application_Model_DbTable_Specjalizacja',
	    'refTableColumns'	=> array('specjalizacja_id')
	)
    );


}

