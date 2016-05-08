<?php
/**
 * @package Phaux-base
 */
class WHNavigation extends WHComponent {
	protected $selection;
	protected $components = array();
	protected $labels = array();
	protected $indexKey = 0;
	
	function __construct(){
		parent::__construct();
		$this->session()->registerObjectOnKeyPath($this,"selection");
		return $this;
	}
	
	function addWithLabel($component,$label){
		
		$this->components[$this->indexKey] = $component;
		$this->labels[$this->indexKey] = $label;
		++$this->indexKey;
		return $this;
	}
	
	public function selection (){
		if($this->selection == NULL && isset($this->components[0])){
			$this->setSelection($this->components[0]);
		}
		return $this->selection;
	}
	
	public function setSelection($aThing){
		$this->selection = $aThing;
		return $this;
	}
	
	public function components(){
		return $this->components;
	}
	
	/*
	**Don't use this
	*/
	public function setComponents($anArray){
		$this->components = $anArray;
		return $this;
	}
	
	public function labelForComponent($aComponent){
		$key = FALSE;
		foreach($this->components as $position => $component){
			if($component === $aComponent){
				$key = $position;
			}
		}
		if($key === FALSE){
			throw new WHException("Can not find label for component");
		}
		return $this->labels[$key];
	}
	
	public function renderContentOn($html){
		return $html->div()->id('layout')->with(
			   $html->anchor()->href('#menu')->id('menuLink')->class('menu-link')->with(
			   	  $html->span()
			   ).
			$html->div()->id('menu')->with(
			$html->div()->class('pure-menu pure-menu-open')->with(
				$this->renderOptionsOn($html)
			)
		).$html->div()->id('main')->with(
				$this->renderSelectionOn($html)
			));
	}
	
	public function labels(){
		return $this->labels;
	}
	
	public function renderOptionsOn($html){
		$list = "";
		foreach($this->components as $component){
			$li = $this->renderOptionOn($html,$component);
			$list .= $li;
		}
		return $html->unorderedList()->
						with($list);
	}
	
	public function renderOptionOn($html,$component){
		$label = $this->renderComponentLabelOn($html,$component);
		$li = $html->listItem()->with($label);
		if($component === $this->selection()){
			$li->class("menu-item-divided pure-menu-selected");
		}else{
		 
		}
		return $li;
	}
	
	public function renderComponentLabelOn($html,$component){
		$link = $html->anchor()->
						callback($this,"setSelection",array($component))->
						with($this->labelForComponent($component));
	
		
	
		return $link;
						
	}
	
	public function renderSelectionOn($html){
		return $html->div()->class('header')->with(
		            $html->h1()->with($this->labelForComponent($this->selection()))
				).
				$html->div()->class('content')->with(
		 		   $html->render($this->selection())
			   );
	}
	
	
	public function children(){
		if($this->selection() == NULL){
			return array();
		}
		return array($this->selection());
	}
	
	
}