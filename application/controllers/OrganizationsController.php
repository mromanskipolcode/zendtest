<?php

class OrganizationsController extends Zend_Controller_Action
{
    
    public function init(){
        $this->view->acitveurl = 'manageorganizations';
    }
    public function manageAction(){
        $this ->_checkAcl('view');
        $organization = new zendtest_Model_DbTable_Organizations();
        
        $select = $organization->select('*');
        $select->setIntegrityCheck(false)
                ->join('person', 'person.person_id=organizations.created_id');
        
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
}