<?php
class zendtest_Model_DbTable_PersonOrganization extends Zend_Db_Table_Abstract
{
    protected $_name = 'person_organization';
    protected $_rowClass = 'zendtest_Model_PersonOrganization';
    protected $_referenceMap = array(
        'Person' => array(
            'columns' => array('person_id'),
            'refTableClass' => 'zendtest_Model_DbTable_User',
            'refColumns' => array('person_id')
        ),
        'Creator' => array(
            'columns' => array('create_id'),
            'refTableClass' => 'zendtest_Model_DbTable_User',
            'refColumns' => array('person_id')
        ),
        'Modified' => array(
            'columns' => array('modify_id'),
            'refTableClass' => 'zendtest_Model_DbTable_User',
            'refColumns' => array('person_id')
        ),
        'Organization' => array(
            'columns' => array('organization_id'),
            'refTableClass' => 'zendtest_Model_DbTable_Organization',
            'refColumns' => array('organization_id')
        )
    );
    

}
