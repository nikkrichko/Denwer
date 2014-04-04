<?php
/**
*	@version	$Id: controller.php 18 2013-04-01 05:16:20Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined( '_JEXEC' ) or die( 'Restricted Access' ); // remove this if implement ajax

jimport('joomla.application.component.controller');

class OTemplatesController extends JControllerLegacy
{

    protected $default_view = 'style';
	
	function display($cachable = false, $urlparams = false) 
	{	
		$view		= JRequest::getCmd('view', '');
		$layout 	= JRequest::getCmd('layout', '');
		$id			= JRequest::getInt('id');
		
		// redirect to com_templates if view = default | styles | style-default
		if (
			($view == '' && $layout != 'edit') ||
			($view == 'style' && $layout == 'default') ||
			$view == 'styles'
		){
			$this->setRedirect(JRoute::_('index.php?option=com_templates&view=styles', false));
			return false;
		}
		

		// Check for edit form.
		if ($view == 'style' && $layout == 'edit' && !$this->checkEditId('com_otemplates.edit.style', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_templates&view=styles', false));

			return false;
		}
		
		// call parent behavior
		parent::display($cachable);
	}

}
