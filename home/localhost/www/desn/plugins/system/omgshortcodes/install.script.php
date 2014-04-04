<?php
/**
*	@version	$Id: install.script.php 49 2013-04-23 01:37:21Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	plg_omgshortcodes plugin for shortcodes
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// no direct access 
if((int)JVERSION == 3){
	defined('JPATH_PLATFORM') or die;
}else{
	defined('_JEXEC') or die ('Restricted access');
}

class plgSystemOmgShortcodesInstallerScript{
 
    public function postflight($type, $parent){
		if(!JPluginHelper::getPlugin('system', 'omgshortcodes') && JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'omgshortcodes'.DIRECTORY_SEPARATOR.'omgshortcodes.php')){
			$db = JFactory::getDBO();
			$query = "UPDATE #__extensions SET enabled='1' WHERE element='omgshortcodes'";
			$db->setQuery($query);
			$db->query();
		}
    }
}