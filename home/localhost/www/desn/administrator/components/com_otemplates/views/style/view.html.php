<?php
/**
*	@version	$Id: view.html.php 11 2013-03-25 03:09:55Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/


defined('_JEXEC') or die('Restricted access');

class OTemplatesViewStyle extends JViewLegacy
{
	protected $item;
	protected $form;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$language = JFactory::getLanguage();
		$language->load('com_templates');
		
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root().'libraries/omg/3rd/jquery-ui.custom/css/flick/jquery-ui.custom.min.css');
		$document->addStyleSheet(JURI::root().'libraries/omg/assets/css/adm_otemplates.css?t='.time());
		
		$document->addScript(JURI::root().'media/jui/js/jquery.min.js');
		$document->addScript(JURI::root().'media/jui/js/jquery-noconflict.js');
		$document->addScript(JURI::root().'libraries/omg/3rd/jquery-ui.custom/js/jquery-ui.custom.min.js');
		$document->addScript(JURI::root().'libraries/omg/assets/js/otemplates.js');
		
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		$this->form		= $this->get('Form');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();
		parent::display($tpl);
	}
	
	public function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$actions = JAccess::getActions('com_templates');

		foreach ($actions as $action) {
			$result->set($action->name, $user->authorise($action->name, 'com_templates'));
		}

		return $result;
	}


	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$canDo		= $this->getActions();

		JToolBarHelper::title(
			$isNew ? JText::_('COM_TEMPLATES_MANAGER_ADD_STYLE')
			: JText::_('COM_TEMPLATES_MANAGER_EDIT_STYLE'), 'thememanager'
		);

		// If not checked out, can save the item.
		if ($canDo->get('core.edit')) {
			JToolBarHelper::apply('style.apply');
			JToolBarHelper::save('style.save');
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::save2copy('style.save2copy');
		}
		
		if (empty($this->item->id))  {
			JToolBarHelper::cancel('style.cancel');
		} else {
			JToolBarHelper::cancel('style.cancel', 'JTOOLBAR_CLOSE');
		}
		JToolBarHelper::divider();
		// Get the help information for the template item.

		$lang = JFactory::getLanguage();

		$help = $this->get('Help');
		if ($lang->hasKey($help->url)) {
			$debug = $lang->setDebug(false);
			$url = JText::_($help->url);
			$lang->setDebug($debug);
		}
		else {
			$url = null;
		}
		JToolBarHelper::help($help->key, false, $url);
	}
}
