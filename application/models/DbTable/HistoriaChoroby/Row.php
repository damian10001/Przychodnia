<?php

class Application_Model_DbTable_HistoriaChoroby_Row extends Zend_Db_Table_Row {

    public function __toString() {
	return (string) $this->nazwa . ' ' . $this->getPacjent();
    }

    function getPacjent() {
	return $this->findParentRow('Application_Model_DbTable_Pacjent');
    }

    public function setSlug($slug) {
	if (trim($slug) == '') {
	    $slug = 'nieznany';
	}

	$next_slug = $slug;

	$q = 'select count(historia_choroby_id) from historia_choroby where slug = ?';
	$db = $this->_getTable()->getAdapter();
	$ile = $db->fetchOne($q, $next_slug);

	$unikatowy = ($ile == 0);

	$min = 2;
	$max = 100;

	while (!$unikatowy) {

	    $next_slug = $slug . $min;
	    $min++;

	    if ($min > $max + 1) {
		throw new Exception("setSlug({$next_slug})");
	    };

	    $q = 'select count(historia_choroby_id) from historia_choroby where slug = ?';
	    $db = $this->_getTable()->getAdapter();
	    $ile = $db->fetchOne($q, $next_slug);

	    $unikatowy = ($ile == 0);
	}

	$this->slug = $next_slug;
    }

    protected function _insert() {
	if ($this->slug === null) {
	    $this->setSlug(My_Slugs::string2slug($this->__toString()));
	}
    }

    protected function _update() {
	if ($this->slug === null) {
	    $this->setSlug(My_Slugs::string2slug($this->__toString()));
	}
    }

}