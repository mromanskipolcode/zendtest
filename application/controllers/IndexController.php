<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction(){
        if(!Zend_Auth::getInstance()->hasIdentity())  {
            $this->_redirect('/login');
        }
    }
}