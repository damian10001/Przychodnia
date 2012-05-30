<?php

class LekarzController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
	$Lekarz = new Application_Model_DbTable_Lekarz();
	$this->view->lekarze = $Lekarz->fetchAll();
    }

    public function showAction()
    {
        // action body
	$slug = $this->_request->getParam('slug', 'brak');
	$Lekarz = new Application_Model_DbTable_Lekarz();
	$this->view->lekarz = $Lekarz->findOneBySlug($slug);
	if (!$this->view->lekarz){
	    throw new Zend_Controller_Action_Exception('Błąd', 404);
	}
    }


}



