<?php

class Zendtest_Validate_DeleteLastAdmin extends Zend_Validate_Abstract 
{

     const ISLAST ='You cannot deactivate last administrator at system.';

    // definiujemy tablicę komunikatów błędów dla poszczególnych kodów
    // zwracam uwagę na '%value', które może być w locie zamienione na sprawdzaną wartość
    protected $_messageTemplates = array(
        self::ISLAST=> "You cannot deactivate last administrator at system. That is a custom validator class message",
        
    );

    public function isValid($value, $context = null) 
    {
        
        if($value==1) {
            return true;
        }
        
        
        $person = new zendtest_Model_DbTable_User();
        $user = $person->fetchAll($person->select()->where("type='administrator'")
                ->where("status='1'"))
                ->toArray();
        
        if(count($user)<2){
            $this->_error(self::ISLAST);
            return false;
        }
        return true;
        

        return $isValid;
    }

}
