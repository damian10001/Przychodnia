<?php

class WizytaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function showAction()
    {
        // action body
	$slug = $this->_request->getParam('slug', 'brak');
	$Wizyta = new Application_Model_DbTable_Wizyta();
	$this->view->wizyta = $Wizyta->findOneBySlug($slug);
	if(!$this->view->wizyta){
	    throw new Zend_Controller_Action_Exception('Błąd', 404);
	}
    }


}



