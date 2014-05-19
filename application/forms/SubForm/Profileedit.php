<?php
class zendtest_Form_SubForm_Profileedit extends Zend_Form
{
    protected $rowNumber = 1;
    protected $values;
    public function init()
    {
        $this->values = $this->view->occupations;
        Zend_Debug::dump($this->values);
        exit;
        $decorators = array(
                'ViewHelper',
                array('HtmlTag', array('tag' => 'li', 'class' => 'form_field'))			
        );

        /*
         * We want array notation, so we will need to do a belongs to here.
         */
        $this->setElementsBelongTo("member[{$this->rowNumber}]");

        $this->addElement('select', 'status', array(
                'label' => 'Status',
                'class' => 'genText',
                'required' => true,
                'multioptions' => $this -> values
            ));

    }
    
    /**
     * Set occupations amount
     * @param type $num
     * @return zendtest_Form_SubForm_Profileedit
     */
    public function setRowNumber($num) 
    {
        $this->rowNumber = (int) $num;
        return $this;
    }
    
    /**
     * Set occupation list select options
     * @param type $values
     */
    public function setValuesOption($values)
    {
        $this->values = $values;
    }

}

