<?php
/**
 * This file defines Access Controls for the WIKI application.
 * The application basically has only two types of users
 * Administrator and WIKI user
 * A Guest is allowed to view, create new articles and edit existing articles.
 * While the Administrator can additionally create new WIKI Users 
 */

class Zendtest_Acl extends Zend_Acl
{
    public function __construct()
    {
        try {
            //define available roles
            $this->addRole(new Zend_Acl_Role('administrator'))
                    ->addRole(new Zend_Acl_Role('employee'))
                    ->addRole(new Zend_Acl_Role('subcontractor'))
                    ->addRole(new Zend_Acl_Role('contractor'), 'subcontractor');

            
            /*$parents = array('emplyee', 'subcontractor', 'contractor', 'administrator');
            $this->addRole(new Zend_Acl_Role('emplyee'), $parents);
            $this->addRole(new Zend_Acl_Role('subcontractor'), $parents);
            $this->addRole(new Zend_Acl_Role('contractor'), $parents);
            $this->addRole(new Zend_Acl_Role('administrator'), $parents);
            */
            // define resources
            $this->add(new Zend_Acl_Resource('profile'));
            $this->add(new Zend_Acl_Resource('organization'));
            $this->add(new Zend_Acl_Resource('occupation'));
            $this->add(new Zend_Acl_Resource('person'));
            $this->add(new Zend_Acl_Resource('users'));
            
            

            // The user Administrator has access to all resources
            $this->allow('administrator');
            
            $this->allow('employee','profile',array('save','edit'));
            $this->allow('contractor','profile',array('save','edit'));
            $this->allow('subcontractor','profile',array('save','edit'));
            //$this->allow('employee','occupation',array('create'));
            //$this->allow('employee','organization',array('create'));
            
            
        } catch (Zend_Acl_Exception $e) {
            //die('ACL exception!');
            Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('logger')->getLogger()->err($e->getMessage());
            throw $e;
        }
    }
}
