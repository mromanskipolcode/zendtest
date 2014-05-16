<?php

class ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        $exception = $errors->exception;
        
        $this->view->title = (APPLICATION_ENV == 'development') ? $exception->getMessage() : 'Application throws exception';
        $this -> view->message = (APPLICATION_ENV == 'development') ? $exception->getTraceAsString() : 'Application throws exception';
        $this->getResponse()->clearBody();
    }
}