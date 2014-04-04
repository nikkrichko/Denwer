<?php
/**
*	@version	$Id: omgmenu.php 61 2013-06-05 10:04:55Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	plug_omgmenu	plugin for OMG menu system (mod_omgmenu)
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// no direct access
defined( '_JEXEC' ) or die();

jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.html.parameter' );

class plgSystemOMGMenu extends JPlugin {
	var $_params;
	var $_pluginPath;
	protected static $modules = array();
	protected static $mods = array();
	
	function __construct( &$subject ) {
		parent::__construct( $subject );
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'omgmenu' );
		$this->_params = new JParameter( $this->_plugin->params );
		$this->_pluginPath = JPATH_PLUGINS.DS."system".DS."omgmenu".DS;
		$language = JFactory::getLanguage();
		$language->load('plg_system_omgmenu');
	}
	
	//Add main menu parameter
	function onContentPrepareForm($form, $data) {
		if ($form->getName()=='com_menus.item') {
			JForm::addFormPath($this->_pluginPath);
			$form->loadFile('parameters', false);
		}
	}
	
	public function onAfterRender()
	{
		$app = JFactory::getApplication();
		
		if ($app->isAdmin()) return;
		
		$regexmod	= '/{omnloadmodule\s+(.*?)}/i';
		$title		= null;
		$stylemod = 'none';
		
		// Find all instances of plugin and put in $matchesmod for loadmodule
		$body = JResponse::getBody();
		preg_match_all($regexmod, $body, $matchesmod, PREG_SET_ORDER);
		
		// If no matches, skip this
		if ($matchesmod){
			foreach ($matchesmod as $matchmod) {

				$matchesmodlist = explode(',', $matchmod[1]);
				//We may not have a specific module so set to null
				if (!array_key_exists(1, $matchesmodlist)) {
					$matchesmodlist[1] = null;
				}
				// We may not have a module style so fall back to the plugin default.
				if (!array_key_exists(2, $matchesmodlist)) {
					$matchesmodlist[2] = $stylemod;
				}

				$module = trim($matchesmodlist[0]);
				$name   = trim($matchesmodlist[1]);
				$style  = trim($matchesmodlist[2]);
				$mid  	= trim($matchesmodlist[3]);
				// $match[0] is full pattern match, $match[1] is the module,$match[2] is the title
				$output = $this->_loadmod($mid, $module, $name, $style);
				// We should replace only first occurrence in order to allow positions with the same name to regenerate their content:
				$body = preg_replace("|$matchmod[0]|", addcslashes($output, '\\$'), $body, 1);
			}
			JResponse::setBody($body);
		}
		
	}
	
	protected function _loadmod($mid, $module, $title, $style = 'none')
	{
		if (!isset(self::$mods[$mid])) {
			self::$mods[$mid] = '';
			$document	= JFactory::getDocument();
			$renderer	= $document->loadRenderer('module');
			$mod		= JModuleHelper::getModule($module, $title);
			// If the module without the mod_ isn't found, try it with mod_.
			// This allows people to enter it either way in the content
			if (!isset($mod)){
				$name = 'mod_'.$module;
				$mod  = JModuleHelper::getModule($name, $title);
			}
			$params = array('style' => $style);
			ob_start();

			echo $renderer->render($mod, $params);

			self::$mods[$mid] = ob_get_clean();
		}
		return self::$mods[$mid];
	}
}
?>