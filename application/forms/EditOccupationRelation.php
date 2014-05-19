<?php
class zendtest_Form_EditOccupationRelation extends Zend_Form
{
    public function init()
    {
        $this->addElement('hash', 'csrf',
            array(
                'ignore' => false
            )
        );

        $this->addElement('select', 'occupation_id', array(
            'label' => 'Occupation',
            'class' => 'genText',
            'required' => true
        ));
        
        $this->addElement('text', 'start_dt', array(
            'label' => 'Start date',
            'class' => 'genText',
            'required' => true,
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty',
                'Date'
            )
        ));
        
        
        
        $this->addElement('text', 'end_dt', array(
            'label' => 'End date',
            'class' => 'genText',
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'Date'
            )
        ));
        
        
        $this->addElement('text', 'email', array(
            'label' => 'Email',
            'class' => 'genText',
            'required' => true,
            'filters' => array(
                'StringTrim',
                'StringToLower'
            ),
            'validators' => array(
                'NotEmpty',
                'EmailAddress'
            )
        ));
        
        $this->addElement('text', 'phone', array(
            'label' => 'Phone',
            'class' => 'genText',
            'required' => true,
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty'
            )
        ));
        
        $this->addElement('select', 'status', array(
                'label' => 'Status',
                'class' => 'genText',
                'required' => true,
                'multioptions' => array(
                    '1' => 'Active',
                    '0' => 'Inactive'
                )
            ));

        $this->setAttrib('class', 'centerform');
        
        $this->addElement('submit', 'save', array(
            'label'  => 'Save',
            'ignore' => true,
            'class'  => 'genText',
        ));
        $this->addDisplayGroup(
                array('occupation_id','phone', 'email','start_dt', 'end_dt', 'status', 'save'), 
                'logingroup'
                );
        
    }
}