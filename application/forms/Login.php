
<?php
class zendtest_Form_Login extends Zend_Form
{
    public function init()
    {

        $this->addElement('hash', 'csrf',
            array(
                'ignore' => false
            )
        );

        $this->setAttrib('class', 'centerform');
        $this->addElement('text', 'username', array(
            'label'     => 'Username',
            'required'  => true,
            'filters'   => array(
                'StringToLower',
                'StringTrim',
            ),
            'validators' => array(
                'EmailAddress'

            )
        ));

        $this->addElement('password', 'password', array(
            'label'     => 'Password',
            'class'     => 'genText',
            'required'  => true,
            'filters'   => array(
                'StringTrim'
            ),
            'validators' => array(

                'NotEmpty'
            ),
        ));

        $this->addElement('submit', 'Login', array(
            'label'  => 'Login',
            'ignore' => true,
            'class'  => 'genText',
        ));
        $this->addDisplayGroup(array('username','password','Login'), 'logingroup');


        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            'Form',
        ));
    }
}

