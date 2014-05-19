<?php

class ProfileController extends Zend_Controller_Action
{
    public function init(){
        $this->view->activeurl = 'editprofile';
    }
    
    public function indexAction(){
        /*
        $occupations = new zendtest_Model_DbTable_Occupation();
        $els = $occupations->fetchAll()->toArray();
        $this->view->occupations = $els;
*/
        //get user depended data
        $person = new zendtest_Model_DbTable_User();
        $user = $person->fetchRow($person->select()->where("person_id=?",  Zend_Auth::getInstance()->getIdentity()->person_id));
        //get all occupations
        $relation = $user->findDependentRowset('zendtest_Model_DbTable_PersonOccupation', 'Person')->toArray();
        //get relation with occupation (needed for name)
        $relationOccupation = $user->findManyToManyRowset('zendtest_Model_DbTable_Occupation', 'zendtest_Model_DbTable_PersonOccupation')->toArray();
        $relationConfig = array();
        
        foreach($relationOccupation as $key=>$value){
            $relationConfig[$value['occupation_id']] = $value;
        }
        
        $relations = array();
        if(!empty($relation)){
            foreach($relation as $value){
                if($value['status']==0) continue;
                $relations[] = array('data' => $value, 'occupation' => $relationConfig[$value['occupation_id']]);
                
            }
        }
        $this->view->personRelations=$relations;
        
        
        //part for relation wit organization
        //get all Organization
        $relation = $user->findDependentRowset('zendtest_Model_DbTable_PersonOrganization', 'Person')->toArray();
        //get relation with organization
        $relationOrganization = $user->findManyToManyRowset('zendtest_Model_DbTable_Organization', 'zendtest_Model_DbTable_PersonOrganization')->toArray();
        $relationConfig = array();
        
        $relations = array();
        if(!empty($relation)){
            foreach($relation as $value){
                if($value['status']==0) continue;
                $relations[] = array('data' => $value, 'organization' => $relationConfig[$value['organization_id']]);
                
            }
        }
        $this->view->personOrganizationRelations = $relations;
        
        //show form
        $form = new zendtest_Form_Profileedit();
        $form->getElement('fname')->setValue($user->fname);
        $form->getElement('lname')->setValue($user->lname);
        $form->getElement('email')->setValue($user->email);
        $form->getElement('type')->setValue($user->type);
        $form->getElement('phone_main')->setValue($user->phone_main);
        $form->getElement('phone_cell')->setValue($user->phone_cell);
        $form->getElement('address_1')->setValue($user->address_1);
        $form->getElement('address_2')->setValue($user->address_2);
        $form->getElement('city')->setValue($user->city);
        $form->getElement('postal_code')->setValue($user->postal_code);
        $form->getElement('status')->setValue($user->status);
        
        
        
        $this->view->form = $form;
        
    }
    
    public function editrelationAction()
    {
        
        $form =  new zendtest_Form_EditOccupationRelation();
        
        $occupation = new zendtest_Model_DbTable_Occupation();
        $occupations = $occupation ->fetchAll()->toArray();
        $oc = array();
        
        foreach($occupations as $value){
            $oc[$value['occupation_id']] = $value['name'];
        }
        
        $occupationrelation = new zendtest_Model_DbTable_PersonOccupation();
        $row = $occupationrelation->fetchRow($occupationrelation->select()
                ->where("person_id=?",  Zend_Auth::getInstance()->getIdentity()->person_id)
                ->where("occupation_id", $this->_request->getParam('byid'))
                );
        
        $form->getElement('occupation_id')->setMultiOptions($oc)->setValue($row->occupation_id);
        $form->getElement('start_dt')->setValue($row->start_dt);
        $form->getElement('end_dt')->setValue($row->end_dt == '0000-00-00' ? '' : $row->end_dt);
        $form->getElement('status')->setValue($row->status);
        
        
        
        if($this->_request->getPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $row->occupation_id = $this->_request->getPost('occupation_id');
                $row->start_dt = $this->_request->getPost('start_dt');
                $row->end_dt = $this->_request->getPost('end_dt');
                $row->status = $this->_request->getPost('status');
                $row->modify_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->modify_dt = date('Y-m-d H:i:s');
                $row->save();
                $this->_redirect('profile');
            }
        }

        $this->view->form = $form;
    }
    
    public function addnewoccupationrelationAction()
    {
        $form =  new zendtest_Form_EditOccupationRelation();
        
        $occupation = new zendtest_Model_DbTable_Occupation();
        $occupations = $occupation ->fetchAll()->toArray();
        $oc = array();
        
        foreach($occupations as $value){
            $oc[$value['occupation_id']] = $value['name'];
        }
        $form->getElement('occupation_id')->setMultiOptions($oc);
        
        //we can choose phone and email from user profile or session. I will 
        //use user profile
        $person = new zendtest_Model_DbTable_User();
        $user = $person->fetchRow($person->select()->where("person_id=?",  Zend_Auth::getInstance()->getIdentity()->person_id));
        $form->getElement('phone')->setValue($user->phone_main);
        $form->getElement('email')->setValue($user->email);
        
        if($this->_request->getPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $occupationrelation = new zendtest_Model_DbTable_PersonOccupation();
                $row = $occupationrelation->createRow();
                $row->occupation_id = $this->_request->getPost('occupation_id');
                $row->person_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->start_dt = $this->_request->getPost('start_dt');
                $row->end_dt = $this->_request->getPost('end_dt');
                $row->status = $this->_request->getPost('status');
                $row->create_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->create_dt = date('Y-m-d H:i:s');
                $row->save();
                $this->_redirect('profile');
            }
        }
        
        
        
        $this->view->form = $form;
    }
    
    public function addneworganizationrelationAction(){
        $form =  new zendtest_Form_EditOrganizationRelation();
        
        $occupation = new zendtest_Model_DbTable_Organization();
        $occupations = $occupation ->fetchAll()->toArray();
        $oc = array();
        
        foreach($occupations as $value){
            $oc[$value['organization_id']] = $value['name'];
        }
        $form->getElement('organization_id')->setMultiOptions($oc);
        
        if($this->_request->getPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $occupationrelation = new zendtest_Model_DbTable_PersonOrganization();
                $row = $occupationrelation->createRow();
                $row->organization_id = $this->_request->getPost('organization_id');
                $row->person_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->start_dt = $this->_request->getPost('start_dt');
                $row->end_dt = $this->_request->getPost('end_dt');
                $row->status = $this->_request->getPost('status');
                $row->create_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->create_dt = date('Y-m-d H:i:s');
                $row->save();
                $this->_redirect('profile');
            }
        }
        
        $this->view->form = $form;
    }
    
    
    
    public function editrelationorganizationAction()
    {
        
        $form =  new zendtest_Form_EditOrganizationRelation();
        
        $occupation = new zendtest_Model_DbTable_Organization();
        $occupations = $occupation ->fetchAll()->toArray();
        $oc = array();
        
        foreach($occupations as $value){
            $oc[$value['organization_id']] = $value['name'];
        }
        
        $occupationrelation = new zendtest_Model_DbTable_PersonOrganization();
        $row = $occupationrelation->fetchRow($occupationrelation->select()
                ->where("person_id=?",  Zend_Auth::getInstance()->getIdentity()->person_id)
                ->where("organization_id", $this->_request->getParam('byid'))
                );
        
        $form->getElement('organization_id')->setMultiOptions($oc)->setValue($row->organization_id);
        $form->getElement('start_dt')->setValue($row->start_dt);
        $form->getElement('end_dt')->setValue($row->end_dt == '0000-00-00' ? '' : $row->end_dt);
        $form->getElement('status')->setValue($row->status);
        
        
        if($this->_request->getPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $row->organization_id = $this->_request->getPost('organization_id');
                $row->start_dt = $this->_request->getPost('start_dt');
                $row->end_dt = $this->_request->getPost('end_dt');
                $row->status = $this->_request->getPost('status');
                $row->modify_id = Zend_Auth::getInstance()->getIdentity()->person_id;
                $row->modify_dt = date('Y-m-d H:i:s');
                $row->save();
                $this->_redirect('profile');
            }
        }

        $this->view->form = $form;
    }
}