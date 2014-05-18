
<?php
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    public function menu()
    {
      

        $auth     = Zend_Auth::getInstance();

        $menu = array();
        if (!$auth->hasIdentity()) {
            return '';
        }

        //administrator part
        $menu['administrator'][] = array(
            'key'=>'manageusers',
            'label' => 'Manage users',
            'url' => $this->view->url(
                    array (
                        'controller'     => 'users',
                        'action'        => 'manage'
                        ), 'default',true
                    )
        );
        $menu['administrator'][] = array(
            'key'=>'manageorganizations',
            'label' => 'Manage organizations',
            'url' => $this->view->url(
                    array (
                        'controller'     => 'organizations',
                        'action'        => 'manage'
                        ), 'default',true
                    )
        );
        
        $menu['administrator'][] = array(
            'key'=>'manageoccupations',
            'label' => 'Manage occupations',
            'url' => $this->view->url(
                    array (
                        'controller'     => 'occupations',
                        'action'        => 'manage'
                        ), 'default',true
                    )
        );
        
        $menu['administrator'][] = array(
            'key'=>'editprofile',
            'label' => 'Edit profile',
            'url' => $this->view->url(
                    array (
                        'controller'     => 'profile',
                        'action'        => 'index'
                        ), 'default',true
                    )
        );

        //contractor part
        $menu['contractor'][] = array(
            'label' => 'Edit profile',
            'url' => $this->view->url(
                array(
                    'controller' => 'profile',
                    'action' => 'index'
                ), 'default',true
            )
        );

        $menu['subcontractor'] = $menu['emplyee'] = $menu['contractor'];


        if(empty($menu[$auth ->getIdentity() -> type])) {
            return '';
        }

        $menucontent = '<div class="list-group">';
        foreach ($menu[$auth->getIdentity()->type] as $value) {
            $menucontent .= sprintf('<a href="%s" class="list-group-item %s">%s</a>',
                    $value['url'],
                    ($this->view->activeurl==$value['key'])? 'active' : '',
                    $value['label']);
        }
        $menucontent .= '</div>';



        return $menucontent;
    }
}

