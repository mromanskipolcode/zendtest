<?php
class zendtest_Model_DbTable_PersonOccupation extends Zend_Db_Table_Abstract
{
    protected $_name = 'person_occupation';
    protected $_rowClass = 'zendtest_Model_PersonOccupation';
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
        'Occupation' => array(
            'columns' => array('occupation_id'),
            'refTableClass' => 'zendtest_Model_DbTable_Occupation',
            'refColumns' => array('occupation_id')
        )
    );
    

}
