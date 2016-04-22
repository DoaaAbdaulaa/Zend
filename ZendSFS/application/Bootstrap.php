<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initSession()
	{
		Zend_Session::start();
	}


	protected function _initPlaceholders()
	{
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('XHTML1_STRICT');
		//Meta
		$view->headMeta()->appendName('keywords', 'framework, PHP')->appendHttpEquiv('Content-Type','text/html;charset=utf-8');
		// Set the initial title and separator:
		$view->headTitle('SFS')->setSeparator(' :: ');
		// Set the initial stylesheet:
<<<<<<< HEAD
		$view->headScript()->prependFile($view->baseUrl().'/Zend/ZendSFS/public/js/bootstrap.min.js');
		$view->headScript()->prependFile($view->baseUrl().'/Zend/ZendSFS/public/js/jquery-1.11.2.js');
		// Set the initial JS to load:
		// $view->headScript()->prependFile('/js/code.js');
		$view->headLink()->prependStylesheet($view->baseUrl().'/Zend/ZendSFS/public/css/bootstrap.min.css');


	}

=======
		//$view->headLink()->prependStylesheet('/css/site.css');
		// Set the initial JS to load:
		//$view->headScript()->prependFile('/js/code.js');

	}

	//To activate session
	protected function _initSession(){
		Zend_Session::start();
	}




>>>>>>> 29bbea56dfd713027a05ef1a0f7da92d37b9a7bc
}

