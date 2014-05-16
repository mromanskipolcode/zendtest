<?php

class OrganizationsController extends Zend_Controller_Action
{
    
    public function init(){
        $this->view->activeurl = 'manageorganizations';
    }
    public function manageAction(){
        $this ->_checkAcl('view');
        $organization = new zendtest_Model_DbTable_Organization();
        
        $select = $organization->select('organization');
                
        $select->setIntegrityCheck(false)
                ->join('person', 'person.person_id=organization.create_id')
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns('organization.*')
                ->columns('person.fname')
                ->columns('person.lname')
                ->columns('person.email');
                
        
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
        $paginator ->setItemCountPerPage(7);
        $request = $this->getParam('page');
        $paginator->setCurrentPageNumber(empty($request) ? '1' : $request);
        
        
        
        $this ->view->paginator = $paginator;
        
    }
    
    private function _checkAcl($action){
        $type = '';
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $type = $auth->getIdentity()->type;
        }

        $acl = new Zendtest_Acl();
        
        if (!$acl->isAllowed($type, 'organization', $action)) {

            die('not allowed!');

            return false;
        }
        return true;
    }
    
    public function addnewAction(){
        $form = new zendtest_Form_Organizations();
        if($this->_request->getPost()){
            if($form->isValid($this->_request->getPost())){
                
                $auth = Zend_Auth::getInstance();
                $organizations = new zendtest_Model_DbTable_Organization();
                $nrow = $organizations ->createRow();
                $nrow->name = $this->_request->getPost('name');
                $nrow->address_1 = $this->_request->getPost('address_1');
                $nrow->address_2 = $this->_request->getPost('address_2');
                $nrow->city = $this->_request->getPost('city');
                $nrow->postal_code = $this->_request->getPost('postal_code');
                $nrow->status = $this->_request->getPost('postal_code');
                $nrow->create_id = $auth ->getIdentity()->person_id;
                $nrow->create_dt = date('Y-m-d H:i:s');
                $nrow->modify_id = null;
                $nrow->save();
                $this->_redirect('organizations/manage');
            }
        }
        $this->view->form=$form;
    }
}