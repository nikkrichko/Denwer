<?php
/**
*	@version	$Id: core.php 29 2013-04-03 02:32:38Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('OMG_VERSION') or die();
/**
 * @package     omg
 * @subpackage  core
 */
require_once(OPATH_LIB_3RD . DS. 'Browser.php');

class OMGCore
{
	/* document */
	public $document;
	/* browser */
	public $browser;
	public $language;
	
	
	
	/* template */
	public $basePath;
	public $baseUrl;
	public $baseUrlFull;
	public $templateName;
	public $templateUrl;
	public $templatePath;
	
	/* template parameters */
	public $params;
	
	public $defaultBlockParams = '{
			"6":{"width":"2,2,2,2,2,2","phone":"1,1,1,1,1,1","tablet":"1,1,1,1,1,1","desktop":"1,1,1,1,1,1"},
			"5":{"width":"4,2,2,2,2","phone":"1,1,1,1,1","tablet":"1,1,1,1,1","desktop":"1,1,1,1,1"},
			"4":{"width":"6,2,2,2","phone":"1,1,1,1","tablet":"1,1,1,1","desktop":"1,1,1,1"},
			"3":{"width":"8,2,2","phone":"1,1,1","tablet":"1,1,1","desktop":"1,1,1"},
			"2":{"width":"10,2","phone":"1,1","tablet":"1,1","desktop":"1,1"},
			"1":{"width":"12","phone":"1","tablet":"1","desktop":"1"}
		}';
	
	public $defaultMainbodyParams = '{
			"4":{"width":"2,6,2,2","phone":"1,1,1,1","tablet":"1,1,1,1","desktop":"1,1,1,1"},
			"3":{"width":"2,8,2","phone":"1,1,1","tablet":"1,1,1","desktop":"1,1,1"},
			"2":{"width":"2,10","phone":"1,1","tablet":"1,1","desktop":"1,1"},
			"1":{"width":"12","phone":"1","tablet":"1","desktop":"1"}
			}';
	
	/* other page var */
	public $bodyClasses = array('oBody');
	
	/**/
	public function __construct($templateName = null)
	{	// set the document var
		$document = JFactory::getDocument();
		$language = JFactory::getLanguage();
		$language->load('com_otemplates', JPATH_ADMINISTRATOR);
		$this->document =& $document;
		
		$this->document->setGenerator('');
		
		$this->basePath = $this->cleanPath(JPATH_ROOT);
		$this->baseUrl = JURI::root(true) . "/";
		$this->baseUrlFull = JURI::root();
		$this->templateName = $document->template;
		$this->templatePath = $this->cleanPath(JPATH_ROOT . '/' . 'templates' . '/' . $this->templateName);
		$this->templateUrl = $this->baseUrl . 'templates' . '/' . $this->templateName;
			
		
		$this->browser = new Browser();
		
		$this->params = $this->document->params;
		
		/* body class */
		$this->bodyClasses[] = $document->getDirection();
		$is_innerPage = true;
		if ($this->isHomepage()){
			$this->bodyClasses[] = 'homepage';
			$is_innerPage = false;
		}
		if ($this->isFrontpage()){
			$this->bodyClasses[] = 'frontpage';
			$is_innerPage = false;
		}
		if ($is_innerPage) $this->bodyClasses[] = 'innerpage';
		
	}
	
	
	/*
	*	get body classes
	*/
	function addBodyClass($class = ''){
		if (isset($class) && $class != '') $this->bodyClasses[] = $class;
	}
	
	/*
	*	get body classes
	*/
	function getBodyClass(){
		return implode(' ', $this->bodyClasses);
	}
	
	/*
	*	Check Frontpage view
	*/
	function isFrontpage(){
		return (JRequest::getCmd('option') == 'com_content' && JRequest::getCmd( 'view' ) == 'featured') ;
	}
	
	/*
	*	Check Homepage
	*/
	public function isHomepage(){
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$lang = JFactory::getLanguage();
		if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/*
	*	Check browser IE and version
	*/
	public function isIE($compare = '==', $version = null){
		if (!isset($version)) return ($this->browser->getBrowser() == Browser::BROWSER_IE);
		switch($compare){
			case '!=': 
				$matchVersion = $this->browser->getVersion() != (int)$version; 
			break;
			case '>':  
				$matchVersion = $this->browser->getVersion() > (int)$version; 
			break;
			case '>=': 
				$matchVersion = $this->browser->getVersion() >= (int)$version; 
			break;
			case '<':  
				$matchVersion = $this->browser->getVersion() < (int)$version; 
			break;
			case '<=': 
				$matchVersion = $this->browser->getVersion() <= (int)$version; 
			break;
			case '==': 
			default:
				$matchVersion = $this->browser->getVersion() == (int)$version; 
			break;
		}
		return ($this->browser->getBrowser() == Browser::BROWSER_IE && $matchVersion);
	}
	
	
	/* @desc: build the list of positions
	*  @params: 
	*  @output: (array)
	*/
	public function getPositions($blockName, $blockModel = 6, $blockLayout, $style, $dir_rtl){

		$positions = array();
		
		$isFixed = intval($this->params->get($blockName.'_isFixed', 0));
		$fixedNumber = intval($this->params->get($blockName.'_fixedNumber', 6));
		
		
		$maxPos = ($isFixed == 1) ? $fixedNumber : $blockModel; // if fixed position number, got fixed number, otherwise check all position if have modules
		$numPosHavMod  = ($isFixed == 1) ? $fixedNumber : $this->countPosHaveModule($blockName, 6);
		if (JRequest::getInt('tp',0) == 1) $numPosHavMod = $blockModel; // view tp=1
		
		if($numPosHavMod < 1) return array();
		if(!isset($blockLayout[$numPosHavMod])) return array();
		$posWidthArray = array_map('intval', explode(',', $blockLayout[$numPosHavMod]['width']));
		$posPhoneArray = explode(',', $blockLayout[$numPosHavMod]['phone']);
		$posTabletArray = explode(',', $blockLayout[$numPosHavMod]['tablet']);
		$posDesktopArray = explode(',', $blockLayout[$numPosHavMod]['desktop']);
		
		$wi = 0;
		
		for ($pi = 1; $pi <= $maxPos; $pi++){
			$position = new StdClass();
			$position->name = $blockName.'-'.$pi;
			$position->countModules = $this->document->countModules($position->name);
			$position->content = '';
			$position->isShow = false;
			$position->classes = array('oPos');
			$position->classes[] = $position->name;
			
			$position->width = isset($posWidthArray[$wi]) ? (int)$posWidthArray[$wi] : 2;
			$position->classes[] = 'span'.$position->width;
			$position->classes[] = isset($posPhoneArray[$wi]) && (int)$posPhoneArray[$wi] == 1 ? 'visible-phone' : '';
			$position->classes[] = isset($posTabletArray[$wi]) && (int)$posTabletArray[$wi] == 1 ? 'visible-tablet' : '';
			$position->classes[] = isset($posDesktopArray[$wi]) && (int)$posDesktopArray[$wi] == 1 ? 'visible-desktop' : '';
			
			$position->isShow = $position->countModules > 0 || $isFixed;
			if ($position->isShow) {
				$wi++;
			}
			
			$position->content = '<jdoc:include type="modules" name="'.$position->name.'" style="'.$style.'" />';
			$positions[] = $position;
			
		}
			
		return $positions;
		
	}
	
	/* @desc: build the list of sidebars and component positions
	*  @params: 
	*  @output: (array)
	*/
	public function getMainBodyPositions($blockName, $blockModel, $blockLayout, $style, $dir_rtl){
		
		$component_on_home = intval($this->params->get('component_on_home', 1));
		$isFixed = intval($this->params->get($blockName.'_isFixed', 0));
		$fixedNumber = intval($this->params->get($blockName.'_fixedNumber', 4));
		$sidebarsLayout = preg_replace('/\s/', '', $this->params->get('sidebarLayout', 'sidebar-1,maincontent,sidebar-2,sidebar-3'));
		$sidebarsLayout = $sidebarsLayout != '' ? explode(',', $sidebarsLayout) : array('maincontent','sidebar-1','sidebar-2','sidebar-3'); 
		
		$mainbodyCount = 1;
		$maxPos = ($isFixed == 1) ? $fixedNumber : 4; // if fixed position number, got fixed number, otherwise check all position if have modules
		$numPosHavMod  = ($isFixed == 1) ? $fixedNumber : $this->countPosHaveModule('sidebar', 3) + $mainbodyCount;
		$posWidthArray = array_map('intval', explode(',', $blockLayout[$numPosHavMod]['width']));
		$posPhoneArray = explode(',', $blockLayout[$numPosHavMod]['phone']);
		$posTabletArray = explode(',', $blockLayout[$numPosHavMod]['tablet']);
		$posDesktopArray = explode(',', $blockLayout[$numPosHavMod]['desktop']);
		
		$positions = array();
		$wi = 0;
		
		foreach ($sidebarsLayout as $idx => $pos){
			if ($wi < $numPosHavMod){
				$position = new StdClass();
				$position->name = $pos;
				
				if ($position->name == 'maincontent'){
					$position->content = '<jdoc:include type="component" />';
					$position->countModules = (!$component_on_home && $this->isHomepage()) ? 0 : 1;
				}
				else{
					
					$position->content = '<jdoc:include type="modules" name="'.$position->name.'" style="'.$style.'" />';
					$position->countModules = $this->document->countModules($position->name);
					$position->classes = array('oPos');
					$position->classes[] = $position->name;
				}
				
				$position->isShow = $position->countModules > 0 || $isFixed;
				
				$position->width = isset($posWidthArray[$wi]) ? (int)$posWidthArray[$wi] : 2;
				$position->classes[] = 'span'.$position->width;
				$position->classes[] = isset($posPhoneArray[$wi]) && (int)$posPhoneArray[$wi] == 1 ? 'visible-phone' : '';
				$position->classes[] = isset($posTabletArray[$wi]) && (int)$posTabletArray[$wi] == 1 ? 'visible-tablet' : '';
				$position->classes[] = isset($posDesktopArray[$wi]) && (int)$posDesktopArray[$wi] == 1 ? 'visible-desktop' : '';
				if ($position->isShow || $position->name == 'maincontent') {
					$wi++;
				}
				$positions[] = $position;
				
			}
			
		}
		return $positions;
		
	}
	
	
	/* @desc: include the modules from positions with the grid layout get from back-end setting
	*  @params: 
	*  @output: modules html output OR html+jdoc:include output
	*/
	
	public function includeModules($blockName = "", $style="standard", $blockModel = 6, $posLayout = null){
		$blockName = trim($blockName);
		if ($blockName == '') return '';
		
		$content = array();

		$rtl_on = intval($this->params->get('dir_rtl_enable', 0));
		
		$blockParams = $this->params->get($blockName);
		
		if (is_object($blockParams) || is_array($blockParams)){
			// the param was saved by template manager
			$blockLayout = json_decode(json_encode($blockParams), true);
		}
		else{
			// the param was saved by extension installer, from templateDetail.xml
			if (!($blockLayout = json_decode($this->parseOemBlockParam($blockParams), true))){
				// no correct params saved from templateDetail, get the default declared above
				$blockLayout = json_decode($this->defaultBlockParams, true);
			}
		}
		if (!$blockLayout) return '';
		
		$positions = $this->getPositions($blockName, $blockModel, $blockLayout, $style, $rtl_on);
		
		if (count($positions) < 1){
			return '';
		}
		
		$show_message = intval($this->params->get('show_system_message', 1));
		$sysmessage_position = trim($this->params->get('system_message_position', 'maincontent'));
		$isFixed = intval($this->params->get($blockName.'_isFixed', 0));
		$totalMod = $this->countModulesInBlock($blockName, 6);
		
		if ($totalMod > 0 || $isFixed) $content[] = '<div class="oPosBlock row-fluid '.$blockName.'">';
		foreach($positions as $pi => $position){
			if ($position->isShow){
				$content[] = '<div class="'.implode(' ', $position->classes).'">';
				if ($show_message && $sysmessage_position == $position->name) $content[] = '<jdoc:include type="omessage" />';
				$content[] = $position->content;
				$content[] = '</div>';
			}
		}
		unset($pi, $position);
		if ($totalMod > 0 || $isFixed) $content[] = '</div>';
		
		return implode("\n", $content);
		
	}
	
	/* @desc: include the sidebar modules from positions
	*  @params: 
	*  @output: modules html output OR html+jdoc:include output
	*/
	
	public function includeSidebarsAndComponent($blockName = "", $sidebarStyle = "standard", $style="standard", $blockModel = "grid-manual"){
		
		$justComponent = '<div class="oPosBlock row-fluid '.$blockName.'"><jdoc:include type="component" /></div>';
		if (trim($blockName) == "") return $justComponent;
		
		$content = array();
		$show_message = intval($this->params->get('show_system_message', 1));
		$sysmessage_position = trim($this->params->get('system_message_position', 'maincontent'));
		$rtl_on = intval($this->params->get('dir_rtl_enable', 0));
		
		$blockParams = $this->params->get($blockName);
		
		if (is_object($blockParams) || is_array($blockParams)){
			// the param was saved by template manager
			$blockLayout = json_decode(json_encode($blockParams), true);
		}
		else{
			// the param was saved by extension installer, from templateDetail.xml
			if (!($blockLayout = json_decode($this->parseOemBlockParam($blockParams), true))){
				// no correct params saved from templateDetail, get the default declared above
				$blockLayout = json_decode($this->defaultMainbodyParams, true);
			}
		}
		if (!$blockLayout) return '';
		
		$positions = $this->getMainBodyPositions($blockName, $blockModel, $blockLayout, $sidebarStyle, $rtl_on);
		if (count($positions) < 1){
			return '';
		}
		
		$content[] = '<div class="oPosBlock row-fluid '.$blockName.'">';
		foreach($positions as $pi => $position){
			if ($position->name == 'maincontent'){
				$content[] = '<div class="oContentBlock '.implode(' ', $position->classes).'">';
					$content[] = $this->includeModules($blockName="content-top", $style, 3);
					if ($show_message && $sysmessage_position == $position->name){
						$content[] = '<jdoc:include type="omessage" />';
					}
					if ($position->isShow){
						$content[] = '<div class="oPos maincontent">';
							$content[] = '<div class="component">';
								$content[] = $position->content;
							$content[] = '</div>';
						$content[] = '</div>';
					}
					$content[] = $this->includeModules($blockName="content-bottom", $style, 3);
				$content[] = '</div>';
			}
			else{
				if ($position->isShow){
					$content[] = '<div class="'.implode(' ', $position->classes).'">';
					$content[] = $position->content;
					$content[] = '</div>';
				}
			}
		}
		unset($pi, $position);
		$content[] = '</div>';
		
		
		return implode("\n", $content);
	}
	
	
	
	/* @desc: include the template control box at front-end for demo purpose
	*  @params: 
	*  @output:
	*/
	public function includeTemplateControl(){
		$html = array();
		$session = JFactory::getSession();
		$form = new JForm('template_demo');
		$formFile	= JPath::clean($this->templatePath.'/demo.xml');
		
		$html[] = '<div id="o-control" class="span4">';
		$html[] = '<span id="o-control-handle" class="btn"><span class="icon-cog"> </span></span>';
		$html[] = '<div class="clearfix"></div>';
		$html[] = 	'<div id="o-control-box">';
		$html[] = 		'<div class="well well-small">';
		
		
		if (!$form->loadFile($formFile, false)) {
			$html[] = JText::_('XML file not found!');
		}
		else{
			$form_data = $session->get('template_demo');
			if (isset($form_data)){
				$form->bind($form_data);
			}
			
			$html[] = '<form id="template_demo" name="'.$form->getName().'" action="" method="POST">';
			
			$fieldSets = $form->getFieldsets();
			foreach ($fieldSets as $name => $fieldSet) {
				foreach ($form->getFieldset($name) as $field){
					$html[] = $field->label;
					$html[] = $field->input;
				}
			}
			$html[] = '<button class="btn btn-small btn-primary" type="submit" name="submit_preset" value="1"><span class="icon-ok icon-white"></span> '.JText::_('Apply').'</button>';
			$html[] = '</form>';
		}
		$html[] = 		'</div>';
		$html[] = 	'</div>';
		$html[] = '</div>';
		
		JFactory::getDocument()->addStyleDeclaration('
			#o-control-handle{
				left: 0;
				position: fixed;
				top: 0;
				z-index: 35101;
			}
			#o-control-box{
				position: fixed;
				top: 30px;
				left: -999em;
				z-index: 35101;
			}
		');
		JFactory::getDocument()->addScriptDeclaration('
			jQuery(document).ready(function($){
				var $thecontrolBox = $("#o-control-box");
				$("#o-control-box").css({left: parseInt(0 - $thecontrolBox.outerWidth())});
				$("#o-control-handle").click(function() {
					$thecontrolBox.animate({
						left: parseInt($thecontrolBox.css("left"), 10) == 0 ? -$thecontrolBox.outerWidth() : 0
					}, 1000, function(){});
				});

			});
		');
		
		return implode($html);
	}
	
	
	/* @desc: count number of modules in a block (row) of position
	*  @params: (string) $blockName name of position block
	*			(int) $posNum number of position
	*			(array) $posMapUnlock 
	*  @output: (int)
	*/
	
	public function countPosHaveModule($blockName, $maxPos){
		$total = 0;
		for($i = 1; $i <= $maxPos; $i++){
			if($this->document->countModules($blockName.'-'.$i) > 0){
				$total++;
			}
		}
		return $total;
	}
	
	/* @desc: count number of modules in a block (row) of position
	*  @params: (string) $blockName name of position block
	*			(int) max pos number
	*  @output: (int)
	*/
	public function countModulesInBlock($blockName, $maxPos = 6){
		$total = 0;
		
		for($pi = 1; $pi <= $maxPos; $pi++){
			$total += $this->document->countModules($blockName.'-'.$pi);
		}
		
		return $total;
	}
	
	
	public function parseOemBlockParam($paramStr = '')
	{
		if ($paramStr == '') return false;
		$savedValue = array();
		$defaultValue = preg_replace('/[^0-9,|:;]/s', '', $paramStr);
		$layoutArray = explode(';', $defaultValue);
		foreach ($layoutArray as $layout){
			$layoutNum = explode(':', $layout);
			$deviceLayout = explode('|', $layoutNum[1]);
			$posN = $layoutNum[0];
			$savedValue[$posN] = array('width' => $deviceLayout[0], 'phone' => $deviceLayout[1], 'tablet' => $deviceLayout[2], 'desktop' => $deviceLayout[3]);
		}
		
		return json_encode($savedValue);
	}
	
	public function cleanPath($path)
	{
		if (!preg_match('#^/$#', $path)) {
			$path = preg_replace('#[/\\\\]+#', '/', $path);
			$path = preg_replace('#/$#', '', $path);
		}
		return $path;
	}
	
	
	
}