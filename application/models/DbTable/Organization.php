<?php
class zendtest_Model_DbTable_Organization extends Zend_Db_Table_Abstract
{
    protected $_name = 'organization';
    protected $_rowClass = 'zendtest_Model_Organization';
    protected $_referenceMap = array(
        'Creator' => array(
            'columns' => array('create_id'),
            'refTableClass' => 'zendtest_Model_DbTable_User',
            'refColumns' => array('person_id')
        ),
        'Modified' => array(
            'columns' => array('modify_id'),
            'refTableClass' => 'zendtest_Model_DbTable_User',
            'refColumns' => array('person_id')
        )
    );
    
    protected $_dependentTables = array(
        'zendtest_Model_DbTable_PersonOrganization'
    );
    

}
