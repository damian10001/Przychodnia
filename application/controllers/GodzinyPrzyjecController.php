<?php

class GodzinyPrzyjecController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
	$GodzinyPrzyjec = new Application_Model_DbTable_GodzinyPrzyjec();
	$this->view->godzinyPrzyjec = $GodzinyPrzyjec->fetchAll();
    }


}

