<?php

class HistoriaChorobyController extends Zend_Controller_Action
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
	$HistoriaChoroby = new Application_Model_DbTable_HistoriaChoroby();
	$this->view->historiaChoroby = $HistoriaChoroby->findOneBySlug($slug);
	if (!$this->view->historiaChoroby){
	    throw new Zend_Controller_Action_Exception('Błąd', 404);
	}
    }


}



