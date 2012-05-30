<?php

class PacjentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
	$Pacjent = new Application_Model_DbTable_Pacjent();
	$this->view->pacjenci = $Pacjent->fetchAll();
    }

    public function showAction()
    {
        // action body
	$slug = $this->_request->getParam('slug', 'brak');
	$Pacjent = new Application_Model_DbTable_Pacjent();
	$this->view->pacjent = $Pacjent->findOneBySlug($slug);
	if (!$this->view->pacjent){
	    throw new Zend_Controller_Action_Exception('Błąd', 404);
	}
    }


}



