<?php
/**
 * @package Phaux-test
 */
class WHNavigationTest extends WHComponent {
	protected $navigation;
	
	public function __construct(){
		$this->navigation = Object::construct("WHNavigation");
		$this->navigation->
				addWithLabel(Object::construct("WHCounter"),"Counter")->
				addWithLabel(Object::construct("WHFormTest"),"Forms")->
				addWithLabel(Object::construct("WHMultiCounter"),"Multiple Counter")->
				addWithLabel(Object::construct("WHRegisteredCounter"),"Registered Counter")->
				addWithLabel(Object::construct("WHDialogTest"),"Dialog test")->
				addWithLabel(Object::construct("WHLiveTest"),"AJAX Links")->
				addWithLabel(Object::construct("WHExceptionTest"),"Exceptions")->
				addWithLabel($this->plotTest(),'Ploting')->
				addWithLabel(Object::construct('WHBrowser'),'Code Browser');
				
		return $this;
	}
	
	public function plotTest(){
		return Object::construct('WHPlotTest');
	}
	
	public function renderContentOn($html){
		return $html->render($this->navigation);
	}
	
	public function children(){
		return array($this->navigation);
	}
	
	
	public function updateRoot($anHtmlRoot){
		parent::updateRoot($anHtmlRoot);
		$anHtmlRoot->setTitle("Some of Phaux");
	}
}