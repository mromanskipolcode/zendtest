<?php

class OrganizationsController extends Zend_Controller_Action
{
    
    public function init(){
        $this->view->activeurl = 'manageorganizations';
    }
    
    /**
     * List all organizations action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
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
        
        $elements = Zend_Registry::getInstance()->constants->elementsperpage;
        $paginator ->setItemCountPerPage(empty($elements) ? '4' : $elements);
        
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
    
    /**
     * Create new organization action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function addnewAction(){
        $this ->_checkAcl('addnew');
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
                $nrow->status = $this->_request->getPost('status');
                $nrow->create_id = $auth ->getIdentity()->person_id;
                $nrow->create_dt = date('Y-m-d H:i:s');
                $nrow->modify_id = null;
                $nrow->save();
                $this->_redirect('organizations/manage');
            }
        }
        $this->view->form=$form;
    }
    
    /**
     * Edit existing organization action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function editexternalAction(){
        $this ->_checkAcl('edit');
        $form = new zendtest_Form_Organizations();
        $organization = new zendtest_Model_DbTable_Organization();
        $row = $organization->fetchRow($organization->select()->where("organization_id=?",$this->_request->getParam('byid')));
        //assign form values
        $form->getElement('name')->setValue($row->name);
        $form->getElement('address_1')->setValue($row->address_1);
        $form->getElement('address_2')->setValue($row->address_2);
        $form->getElement('city')->setValue($row->city);
        $form->getElement('postal_code')->setValue($row->postal_code);
        $form->getElement('status')->setValue($row->status);
        
        
        
        if($this->_request->getPost()){
            if($form->isValid($this->_request->getPost())){
                
                $auth = Zend_Auth::getInstance();
                $organizations = new zendtest_Model_DbTable_Organization();
                $nrow = $row;
                //$nrow = $organizations ->fetchRow("organization_id=?",$this->_request->getParam('byid'));
                $nrow->name = $this->_request->getPost('name');
                $nrow->address_1 = $this->_request->getPost('address_1');
                $nrow->address_2 = $this->_request->getPost('address_2');
                $nrow->city = $this->_request->getPost('city');
                $nrow->postal_code = $this->_request->getPost('postal_code');
                $nrow->status = $this->_request->getPost('status');
                $nrow->modify_id = $auth ->getIdentity()->person_id;
                $nrow->modify_dt = date('Y-m-d H:i:s');
                $nrow->modify_id = null;
                $nrow->save();
                $this->_redirect('organizations/manage');
            }
        }
        $this->view->form=$form;
    }
    
}