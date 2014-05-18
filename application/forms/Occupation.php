<?php

class zendtest_Form_Occupation extends Zend_Form
{
    public function init(){
        $this->addElement('hash', 'csrf',
            array(
                'ignore' => false
            )
        );

        $this->setAttrib('class', 'centerform');
        
        $this->addElement('text', 'name', array(
            'label'     => 'Occupation name',
            'required'  => true,
            'filters'   => array(
                'StringTrim',
            ),
            'validators' => array(
                'NotEmpty'

            )
        ));
        
        $this->addElement('textarea', 'description', array(
            'label'     => 'Occupation description',
            'required'  => true,
            'filters'   => array(
                'StringTrim',
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


        

        $this->addElement('submit', 'save', array(
            'label'  => 'Save',
            'ignore' => true,
            'class'  => 'genText',
        ));
        $this->addDisplayGroup(array('name','description', 'status', 'save'), 'logingroup');


        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            'Form',
        ));
        
    }
}
