<?php

class OccupationsController extends Zend_Controller_Action
{
    public function init(){
        $this->view->activeurl = 'manageoccupations';
    }
    
    private function _checkAcl($action){
        $type = '';
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $type = $auth->getIdentity()->type;
        }

        $acl = new Zendtest_Acl();
        
        if (!$acl->isAllowed($type, 'occupation', $action)) {

            die('not allowed!');

            return false;
        }
        return true;
    }
    
    
    /**
     * List all available occupations action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function manageAction(){
        $this ->_checkAcl('view');
        $occupation = new zendtest_Model_DbTable_Occupation();
        
        $select = $occupation->select('occupation');
                
        $select->setIntegrityCheck(false)
                ->join('person', 'person.person_id=occupation.create_id')
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns('occupation.*')
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
    
    
    /**
     * Edit existing occupation action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function editexternalAction(){
        $this ->_checkAcl('edit');
        $form = new zendtest_Form_Occupation();
        $occupation = new zendtest_Model_DbTable_Occupation();
        
        $row = $occupation->fetchRow($occupation->select()->where("occupation_id=?",$this->_request->getParam('byid')));
        $form->getElement('name')->setValue($row->name);
        $form->getElement('description')->setValue($row->description);
        $form->getElement('status')->setValue($row->status);
        
        
        if($this->_request->getPost()) {
            if($form->isValid($this->_request->getPost())) {
                $row->name=$this->_request->getPost('name');
                $row->description = $this->_request->getPost('description');
                $row->status = $this->_request->getPost('status');
                $row->modify_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->modify_dt = date('Y-m-d H:i:s');
     
                $row->save();
                $this->_redirect('occupations/manage');
            }
        }
        $this->view->form = $form;
        
    }
    
    /**
     * Create new occupation action
     * @author Mikolaj Romanski <mikolaj.romanski@polcode.net>
     */
    public function addnewAction(){
        $this ->_checkAcl('addnew');
        $form = new zendtest_Form_Occupation();
        if($this->_request->getPost()) {
            if($form->isValid($this->_request->getPost())) {
                $occupation = new zendtest_Model_DbTable_Occupation();
                $row = $occupation ->createRow();
                $row->name=$this->_request->getPost('name');
                $row->description = $this->_request->getPost('description');
                $row->status = $this->_request->getPost('status');
                $row->create_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->create_dt = date('Y-m-d H:i:s');
                $row->save();
                $this->_redirect('occupations/manage');
            }
        }
        $this->view->form = $form;
    }
    
}