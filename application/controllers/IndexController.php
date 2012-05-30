<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
	$Informacje = new Application_Model_DbTable_Informacje();
	$this->view->informacje = $Informacje->fetchAll();
    }


}

