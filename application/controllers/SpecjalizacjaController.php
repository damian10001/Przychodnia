<?php

class SpecjalizacjaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
	$Specjalizacja = new Application_Model_DbTable_Specjalizacja();
	$this->view->specjalizacja = $Specjalizacja->fetchAll();
    }

    public function showAction()
    {
        // action body
	$slug = $this->_request->getParam('slug', 'brak');
	$Specjalizacja = new Application_Model_DbTable_Specjalizacja();
	$this->view->specjalizacja = $Specjalizacja->findOneBySlug($slug);
	if (!$this->view->specjalizacja){
	    throw new Zend_Controller_Action_Exception('Błąd', 404);
	}
    }


}



