<?php

class LoginController extends Zend_Controller_Action
{

    public function indexAction()
    {



        $form = new zendtest_Form_Login();

        $form->setMethod('post')->setAction(
                $this->view->url(array('controller' => 'login', 'action' => 'login'))
                );
        $this->view->form = $form;
    }
    public function loginAction()
    {
        $request = $this ->getRequest();
        // Make sure form validates first
        $form = new zendtest_Form_Login();
        if (!$form->isValid($request->getPost())) {

            $this->_forward('index');
            return;
        }

        $auth = Zend_Auth::getInstance();
        $adapter = new Zend_Auth_Adapter_DbTable(
            Zend_Db_Table_Abstract::getDefaultAdapter(),
            'person',
            'email',
            'password'
        );

        $salt = Zend_Registry::getInstance()->constants->salt;
        
        $adapter->setIdentity($form->getValue('username'))
                ->setCredential(sha1($form->getValue('password').$salt));

        $authResult = $auth->authenticate($adapter);
        if ($authResult) {
            $user = $adapter->getResultRowObject(null,'password');
            $auth ->getStorage() ->write($user);
            if($auth->getIdentity()->status!='1'){
                $auth->clearIdentity();
                $this->_redirect($this->view->url(
                    array (
                        'controller'     => 'login',
                        'action'        => 'index'
                        )
                    ));
            }
            $this->_redirect(array('controller' => 'index', 'action' => 'index'));
        }
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_forward('login');
    }

}

