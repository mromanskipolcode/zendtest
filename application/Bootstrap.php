<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

        protected function _initAutoload()
        {
                Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

                return new Zend_Application_Module_Autoloader(
                        array(
                                'namespace'     => 'zendtest',
                                'basePath'      => dirname(__FILE__)
                                )
                        );
        }
        /**
         * Load js/css - use twitter bootstrap v3
         */
        protected function _initViewHelpers() {
            $view = new Zend_View();
            $view->headTitle('Test app project')->setSeparator(' - ');
            
            $view->doctype('HTML5');
            $view->setBasePath($view->baseUrl());
            $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
            $view->headLink()->appendStylesheet($view->baseUrl().'/css/bootstrap.min.css');
            $view->headLink()->appendStylesheet($view->baseUrl().'/css/page.css');
            $view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
            $view->headScript()->appendFile($view->baseUrl().'/js/bootstrap.min.js');
            
            
        }

}

