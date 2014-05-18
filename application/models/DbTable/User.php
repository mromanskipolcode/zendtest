<?php
class zendtest_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    protected $_name = 'person';
    protected $_rowClass = 'zendtest_Model_User';
    protected $_dependentTables = array(
        'zendtest_Model_DbTable_Organization'
    );
    

}
