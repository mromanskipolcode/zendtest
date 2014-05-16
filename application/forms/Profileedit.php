<?php
class zendtest_Form_Profileedit extends Zend_Form
{
    public function init()
    {

        $this->addElement('hash', 'csrf',
            array(
                'ignore' => false
            )
        );

        $this->setAttrib('class', 'centerform');
        $this->addElement('text', 'fname', array(
            'label'     => 'First name',
            'required'  => true,
            'filters'   => array(
                'StringTrim',
            ),
            'validators' => array(
                'NotEmpty'

            )
        ));
        $this->addElement('text', 'lname', array(
            'label'     => 'First name',
            'required'  => true,
            'filters'   => array(
                'StringTrim',
            ),
            'validators' => array(
                'NotEmpty'

            )
        ));
        
        
        $this->addElement('text', 'email', array(
            'label' => 'Email',
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



        $this->addElement('password', 'password', array(
            'label'     => 'Password',
            'class'     => 'genText',
            'required'  => true,
            'autocomplete' => 'off',
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty'
            ),
        ));

        $this->addElement('password', 'password1', array(
            'label'     => 'Password',
            'class'     => 'genText',
            'autocomplete' => 'off',
            'required'  => true,
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                array('identical', false, array('token' => 'password'))
            )
        ));
        
        $this->addElement('text', 'phone_main', array(
            'label'     => 'Phone main',
            'class'     => 'genText',
            'required'  => true,
            'autocomplete' => 'off',
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty'
            ),
        ));
        
        $this->addElement('text', 'phone_cell', array(
            'label'     => 'Phone cell',
            'class'     => 'genText',
            'required'  => true,
            'autocomplete' => 'off',
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(
                'NotEmpty'
            ),
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

        $auth= Zend_Auth::getInstance();
        if ($auth->getIdentity()->type == 'administrator') {
            $this->addElement('select', 'type', array(
                'label' => 'Account type',
                'class' => 'genText',
                'required' => true,
                'multioptions' => array(
                    'employee' => 'Employee',
                    'contractor' =>'Contractor',
                    'administrator' =>'Administrator'
                )
            ));
        }
        else{
            $this->addElement('select', 'type', array(
                'label' => 'Account type',
                'class' => 'genText',
                'required' => true,
                'multioptions' => array(
                    'employee' => 'Employee',
                    'contractor' =>'Contractor'
                )
            ));
        } 

        

        $this->addElement('submit', 'save', array(
            'label'  => 'Save',
            'ignore' => true,
            'class'  => 'genText',
        ));
        $this->addDisplayGroup(
                array('fname','lname', 'email', 'type',
                    'password', 'password1', 'phone_main', 
                    'phone_cell', 'address_1','address_2', 'city', 'postal_code', 
                    'status', 'save'), 'logingroup');


        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            'Form',
        ));
    }
}

