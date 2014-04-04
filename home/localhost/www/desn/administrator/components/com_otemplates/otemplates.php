<?php
/**
*	@version	$Id: otemplates.php 7 2013-03-21 09:33:47Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined( '_JEXEC' ) or die( 'Restricted Access' );

if (!JFactory::getUser()->authorise('core.manage', 'com_templates')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

jimport('joomla.application.component.controller');

if (file_exists(JPATH_LIBRARIES . DS . 'omg' . DS . 'OMG.php')) {
	require_once(JPATH_LIBRARIES . DS . 'omg' . DS . 'OMG.php');
}
if (!defined('OMG_VERSION')) JFactory::getApplication()->enqueueMessage(JText::_('OMG_LIBRARY_FILE_NOT_FOUND'), 'error'); 

$session = JFactory::getSession();
if (JRequest::getCmd('task') == 'style.edit'){
	$session->set('safemode', JRequest::getInt('safemode', 0));
}

$controller	= JControllerLegacy::getInstance('OTemplates');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>

