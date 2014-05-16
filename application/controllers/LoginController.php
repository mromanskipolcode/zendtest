<?php

class LoginController extends Zend_Controller_Action
{
    public function indexAction(){
        $form = new zendtest_Form_Login();
        $this->view->form=$form;
        if($this->_request->getPost()){
            $this->_forward('login');
        }
    }
    
    
}