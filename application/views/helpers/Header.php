<?php
class Zend_View_Helper_Header extends Zend_View_Helper_Abstract
{
    public function header() 
    {
   
        
        $auth     = Zend_Auth::getInstance();
        $username = '';
        
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity() -> email;
        }
        

        $welcome         = 'Welcome <span class="bold">' . $username . '</span>';
        
        if ($username != '') {
            $welcome .= ' - <a href="' 
                . $this->view->url(
                        array (
                                'controller'    => 'login',
                                'action'                => 'logout'
                                )
                        )
                . '">logout</a>';    
        } else {
            $welcome = '<a href="' 
                . $this->view->url(
                        array (
                                'controller'    => 'login',
                                'action'                => 'index'
                                )
                        )
                . '">please, login</a>';    
        }
        
        $headerHtml = <<<EOQ
<div id="header">
    <a href="/">Home</a> | $welcome
</div>
EOQ;

        return $headerHtml;
    }
}
