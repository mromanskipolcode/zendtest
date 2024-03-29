<?php

class UsersController extends Zend_Controller_Action
{
    
    public function init(){
        $this->view->activeurl = 'manageusers';
    }
    private function _checkAcl($action){
        $type = '';
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $type = $auth->getIdentity()->type;
        }

        $acl = new Zendtest_Acl();
        
        if (!$acl->isAllowed($type, 'users', $action)) {

            die('not allowed!');

            return false;
        }
        return true;
    }
    
    /**
     * List all users action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function manageAction(){
        $this ->_checkAcl('view');
        $organization = new zendtest_Model_DbTable_User();
        
        $select = $organization->select('person');
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
        
        $elements = Zend_Registry::getInstance()->constants->elementsperpage;
        $paginator ->setItemCountPerPage(empty($elements) ? '4' : $elements);
        
        $request = $this->getParam('page');
        $paginator->setCurrentPageNumber(empty($request) ? '1' : $request);
        
        
        $this ->view->paginator = $paginator;
    }
    
    /**
     * Edit user action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function editexternalAction(){
        $this ->_checkAcl('edit');
        $form = new zendtest_Form_Profileedit();
        $person = new zendtest_Model_DbTable_User();
        
        
        

        
        
        $row = $person->fetchRow($person->select()->where("person_id=?",$this->_request->getParam('byid')));
        $form->getElement('fname')->setValue($row->fname);
        $form->getElement('lname')->setValue($row->lname);
        $form->getElement('email')->setValue($row->email);
        $form->getElement('type')->setValue($row->type);
        $form->getElement('phone_main')->setValue($row->phone_main);
        $form->getElement('phone_cell')->setValue($row->phone_cell);
        $form->getElement('address_1')->setValue($row->address_1);
        $form->getElement('address_2')->setValue($row->address_2);
        $form->getElement('city')->setValue($row->city);
        $form->getElement('postal_code')->setValue($row->postal_code);
        $form->getElement('state_code')->setValue($row->state_code);
        $form->getElement('country')->setValue($row->country);
        $form->getElement('status')->setValue($row->status);
        
        //change validators, because maybe we don't want to change password
        $form->getElement('password')->setValidators(array())
                ->setRequired(false)
                ->addValidator('identical', false, array('token' => 'password1'));
        $form->getElement('password1')->setValidators(array())
                ->addValidator('identical', false, array('token' => 'password'))
                ->setRequired(false);


        
        if($this->_request->getPost()) {
            if($form->isValid($this->_request->getPost())) {
                $row->fname=$this->_request->getPost('fname');
                $row->lname = $this->_request->getPost('lname');
                $row->email = $this->_request->getPost('email');
                $row->type = $this->_request->getPost('type');
                $row->phone_main = $this->_request->getPost('phone_main');
                $row->phone_cell = $this->_request->getPost('phone_cell');
                $row->address_1 = $this->_request->getPost('address_1');
                $row->address_2 = $this->_request->getPost('address_2');
                $row->city = $this->_request->getPost('city');
                $row->postal_code = $this->_request->getPost('postal_code');
                $row->country = $this->_request->getPost('country');
                $row->state_code = $this->_request->getPost('state_code');
                
                $row->status = $this->_request->getPost('status');
                $row->modify_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->modify_dt = date('Y-m-d H:i:s');
                $pass = $this->_request->getPost('password');
                if(!empty($pass)){
                    $salt = Zend_Registry::getInstance()->constants->salt;
                    $row->password = sha1($pass.$salt);
                }
                $row->save();
                $this->_redirect('users/manage');
            }
        }
        $this->view->form = $form;
        
    }
    
    /**
     * Create new user action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function addnewAction(){
        $this ->_checkAcl('addnew');
        $form = new zendtest_Form_Profileedit();
        
        if($this->_request->getPost()) {
            if($form->isValid($this->_request->getPost())) {
                $person = new zendtest_Model_DbTable_User();
                $row = $person ->createRow();
                $row->fname=$this->_request->getPost('fname');
                $row->lname = $this->_request->getPost('lname');
                $row->email = $this->_request->getPost('email');
                $row->type = $this->_request->getPost('type');
                $row->phone_main = $this->_request->getPost('phone_main');
                $row->phone_cell = $this->_request->getPost('phone_cell');
                $row->address_1 = $this->_request->getPost('address_1');
                $row->address_2 = $this->_request->getPost('address_2');
                $row->city = $this->_request->getPost('city');
                $row->postal_code = $this->_request->getPost('postal_code');
                $row->status = $this->_request->getPost('status');
                $row->create_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->create_dt = date('Y-m-d H:i:s');
                $row->country = $this->_request->getPost('country');
                $row->state_code = $this->_request->getPost('state_code');
                
                $pass = $this->_request->getPost('password');
                if(!empty($pass)){
                    $salt = Zend_Registry::getInstance()->constants->salt;
                    $row->password = sha1($pass.$salt);
                }
                $row->save();
                $this->_redirect('users/manage');
            }
        }
        $this->view->form = $form;
    }
}