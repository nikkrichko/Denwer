<?php
/**
*	@version	$Id: omgshortcodes.php 56 2013-04-24 08:30:41Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	plg_omgshortcodes plugin for shortcodes
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

/* plugin based on prototype of Intellispire/Nick Temple and use shortcode API of WordPress http://codex.wordpress.org/Shortcode_API */

// no direct access
if((int)JVERSION == 3){
	defined('JPATH_PLATFORM') or die;
}else{
	defined('_JEXEC') or die ('Restricted access');
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.html.parameter' );

require_once JPATH::clean(dirname(__FILE__) . "/inc/api/shortcodes.php");
require_once JPATH::clean(dirname(__FILE__) . "/inc/shortcodesfuncs.php");

class plgSystemOmgShortcodes extends JPlugin {
	var $document;
	var $_pluginPath;
	var $_pluginUri;
	var $_runmode;
	
	function __construct(&$subject, $config){
		parent::__construct($subject, $config);
		$this->document = JFactory::getDocument();
		$this->_pluginPath = JPATH_PLUGINS.DS."system".DS."omgshortcodes".DS;
		$this->_pluginUri = JURI::root()."plugins/system/omgshortcodes/";
		$this->_runmode = intval($this->params->get('runmode', 0));
		
		$language = JFactory::getLanguage();
		$language->load('plg_system_omgshortcodes');
		
	}
	
	public function onBeforeRender(){
		$app = JFactory::getApplication();
		$this->document->addStyleSheet($this->_pluginUri . "assets/css/all.css");
		if($app->isSite())
		{
			$this->document->addScript($this->_pluginUri . "assets/js/all.js");
		}
		
	}
	
	public function onAfterRender(){
		$app = JFactory::getApplication();
		if ($app->isSite()) {
			if ($this->_runmode != 0){
				$page = JResponse::GetBody();
				$page = do_shortcode($page);
				JResponse::SetBody($page);
			}
		}
		$this->initShortcodesBtn();
    }
	
    public function onContentPrepare( $context, $article, $params, $page=0 ){
		if ($this->_runmode != 0) return;
		$app = JFactory::getApplication();
		if ($app->isSite()) {
			$article->text = do_shortcode($article->text);
		}
		return true;
    }
	
	public function initShortcodesBtn(){
		$page = JResponse::GetBody();
		$button = $this->getShortCodes();
		
		$stext  = '<script language="javascript" type="text/javascript">
						function jInsertShortcode(syntax) {
							syntax = syntax.replace(/\'/g, \'"\');
							if(document.getElementById(\'jform_articletext\') != null) {
								jInsertEditorText(syntax, \'jform_articletext\');
							}
							if(document.getElementById(\'text\') != null) {
								jInsertEditorText(syntax, \'text\');
							}
							if(document.getElementById(\'jform_description\') != null) {
								jInsertEditorText(syntax, \'jform_description\');
							}
							if(document.getElementById(\'jform_content\') != null) {
								jInsertEditorText(syntax, \'jform_content\');
							} 
						}
				   </script>';
		
		$page = str_replace('<div class="toggle-editor">', '<div class="clr"></div><div class="shortcode-buttons">'.$button . '</div><div class="clr"></div><div class="toggle-editor">', $page);
		$page = str_replace('</body>', $stext.'</body>', $page);
		
		JResponse::SetBody($page);
	}
	
	
	public function getShortCodes(){
		$shortcodes = array(
			'badge' => array(
				'name'		=> "Badge",
				'desc'		=> "Bootstrap badges",
				'syntax'	=> "[badge type=\'info\' class=\'\']CONTENT[/badge]"
			),
			'button' => array(
				'name'		=> "Button",
				'desc'		=> "Bootstrap buttons",
				'syntax'	=> "[button type=\'primary\' size=\'default\' url=\'#\' disabled=\'false\' class=\'\']CONTENT[/button]"
			),
			'carousel' => array(
				'name'		=> "Carousel",
				'desc'		=> "Bootstrap carousel",
				'syntax'	=> "<div class=\'sc-wrapper\'>[carousel max_width=\'400px\' class=\'\']<br/>[carousel_item title=\'TITLE\' class=\'active\' image=\'IMAGE_SRC\']DESCRIPTION[/carousel_item]<br/>[carousel_item title=\'TITLE\' class=\'\' image=\'IMAGE_SRC\']DESCRIPTION[/carousel_item]<br/>[carousel_item title=\'TITLE\' class=\'\' image=\'IMAGE_SRC\']DESCRIPTION[/carousel_item]<br/>[/carousel]</div><p></p>"
			),
			'column' => array(
				'name'		=> "Column",
				'desc'		=> "Column",
				'syntax'	=> "<div class=\'sc-wrapper\'>[columns]<br />[column width=\'4\' offset=\'0\' class=\'\']<div>ADD_CONTENT_HERE</div>[/column]<br />[column width=\'4\' offset=\'0\' class=\'\']<div>ADD_CONTENT_HERE</div>[/column]<br />[column width=\'4\' offset=\'0\' class=\'\']<div>ADD_CONTENT_HERE</div>[/column]<br />[/columns]</div><p></p>"
			),
			'dropcap' => array(
				'name'		=> "Dropcap",
				'desc'		=> "Dropcap on first character of paragraph",
				'syntax'	=> "[dropcap color=\'#000000\' background=\'#\' type=\'default\' class=\'\']CHARACTER[/dropcap]"
			),
			'icon' => array(
				'name'		=> "Icon",
				'desc'		=> "Bootstrap icons",
				'syntax'	=> "[icon type=\'heart\' color=\'default\' class=\'\' /]"
			),
			'label' => array(
				'name'		=> "Label",
				'desc'		=> "Bootstrap labels",
				'syntax'	=> "[label type=\'info\' class=\'\']CONTENT[/label]"
			),
			'message' => array(
				'name'		=> "Message box",
				'desc'		=> "Bootstrap alert message box",
				'syntax'	=> "<div class=\'sc-wrapper\'>[message title=\'TITLE\' type=\'info\' block=\'false\' showclose=\'true\' class=\'\']CONTENT[/message]</div><p></p>"
			),
			'modals' => array(
				'name'		=> "Modal-static",
				'desc'		=> "Bootstrap modal box with static content",
				'syntax'	=> "<div class=\'sc-wrapper\'>[modal type=\'static\' id=\'\' class=\'btn\' title=\'BUTTON_TEXT\' header=\'HEADER_TEXT_OF_MODAL\' footer=\'true\']<p>CONTENT</p><p></p>[/modal]</div><p></p>"
			),
			'modalu' => array(
				'name'		=> "Modal-url",
				'desc'		=> "Bootstrap Modal box load content from an internal url and put in modal div",
				'syntax'	=> "[modal type=\'url\' id=\'\' class=\'btn\' title=\'BUTTON_TEXT\' header=\'HEADER_TEXT_OF_MODAL\' href=\'index.php?tmpl=component\' /]"
			),
			'modali' => array(
				'name'		=> "Modal-iframe",
				'desc'		=> "Bootstrap Modal box load the content from url via an iframe",
				'syntax'	=> "[modal type=\'iframe\' id=\'\' class=\'btn\' title=\'BUTTON_TEXT\' header=\'HEADER_TEXT_OF_MODAL\' href=\'http://www.\' /]"
			),
			'oprettycode' => array(
				'name'		=> "PrettyCode",
				'desc'		=> "Display code snippets in pretty format",
				'syntax'	=> "<div class=\'sc-wrapper\'>[oprettycode lang=\'css\' linenums=\'true\' startnum=\'1\']<div>PASTE_YOUR_CODE_HERE</div>[/oprettycode]</div><p></p>"
			),
			'spacer' => array(
				'name'		=> "Spacer",
				'desc'		=> "Add a spacer with specified amount",
				'syntax'	=> "<div class=\'sc-wrapper\' style=\'clear:both;\'>[spacer height=\'20px\'/]</div><p></p>"
			),
			'tabs' => array(
				'name'		=> "Tabs",
				'desc'		=> "Bootstrap Tabs",
				'syntax'	=> "<div class=\'sc-wrapper\'>[tabs max_width=\'\' class=\'\']<br/>[tab title=\'TITLE\']<div>CONTENT</div>[/tab]<br/>[tab title=\'TITLE\']<div>CONTENT</div>[/tab]<br/>[tab title=\'TITLE\']<div>CONTENT</div>[/tab]<br/>[/tabs]</div><p></p>"
			),
			'tooltip' => array(
				'name'		=> "Tooltip",
				'desc'		=> "Bootstrap tooltip",
				'syntax'	=> "[tooltip position=\'top\' mode=\'text\' title=\'TOOLTIP_TEXT\' container=\'false\']CONTENT[/tooltip] "
			),
			'well' => array(
				'name'		=> "Well text box",
				'desc'		=> "Bootstrap WELL text box",
				'syntax'	=> "<div class=\'sc-wrapper\'>[well type=\'default\' class=\'\']<div>CONTENT</div>[/well]</div><p></p>"
			),
			'vimeo' => array(
				'name'		=> "Vimeo",
				'desc'		=> "Add a Vimeo video in content",
				'syntax'	=> "<div class=\'sc-wrapper\'>[vimeo width=\'400\' height=\'300\' video_id=\'\']VIDEO_LINK[/vimeo]</div><p></p>"
			),
			'youtube' => array(
				'name'		=> "Youtube",
				'desc'		=> "Youtube",
				'syntax'	=> "<div class=\'sc-wrapper\'>[youtube width=\'400\' height=\'300\' video_id=\'\']VIDEO_LINK[/youtube]</div><p></p>"
			)			
		);
		
		$html  = '';
		if(count($shortcodes) > 0){
			foreach($shortcodes as $key => $shortcode){
				$html .= '<div class="button2-left">';
					$html .= '<div class="bsc-'.$key.'">';
						$html .= '<a href="javascript: void(0);" onclick="jInsertShortcode(\'' . $shortcode['syntax'] . '\')" title="' . $shortcode['desc'] . '">';
							$html .= $shortcode['name'];
						$html .= '</a>';
					$html .= '</div>';
				$html .= '</div>';	
			}
		}
		
		return $html;
	}
	
}


?>