<?php
class zendtest_Form_EditOrganizationRelation extends Zend_Form
{
    public function init()
    {
        $this->addElement('hash', 'csrf',
            array(
                'ignore' => false
            )
        );

        $this->addElement('select', 'organization_id', array(
            'label' => 'Organization',
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
                array('organization_id','start_dt', 'end_dt', 'status', 'save'), 
                'logingroup'
                );
        
    }
}