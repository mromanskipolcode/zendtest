<?php
class zendtest_Form_Organizations extends Zend_Form
{
    public function init()
    {

        $this->addElement('hash', 'csrf',
            array(
                'ignore' => false
            )
        );

        $this->setAttrib('class', 'centerform');
        $this->addElement('text', 'name', array(
            'label'     => 'Organization name',
            'required'  => true,
            'filters'   => array(
                'StringTrim',
            ),
            'validators' => array(
                'NotEmpty'

            )
        ));

        $this->addElement('text', 'address_1', array(
            'label'     => 'Address line 1',
            'required'  => true,
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty'
            ),
        ));
        
        $this->addElement('text', 'address_2', array(
            'label'     => 'Address line 2',
            'required'  => true,
            'filters'   => array(
                'StringTrim'
            )
        ));
        $this->addElement('text', 'city', array(
            'label'     => 'City',
            'required'  => true,
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty'
            )
        ));
        
        $this->addElement('text', 'postal_code', array(
            'label'     => 'Postal code',
            'required'  => true,
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty',
                array('PostCode', false, array('locale' => 'en_US'))
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
        $this->addDisplayGroup(array('name','address_1','address_2', 'city', 'postal_code', 'status', 'save'), 'logingroup');


        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            'Form',
        ));
    }
}

