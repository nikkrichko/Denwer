<?php
/**
*	@version	$Id: style.php 18 2013-04-01 05:16:20Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// No direct access.
defined( '_JEXEC' ) or die( 'Restricted Access' );
jimport( 'joomla.filesystem.file' );
jimport('joomla.application.component.controllerform');

class OTemplatesControllerStyle extends JControllerForm
{
    /**
     * @var		string	The prefix to use with controller messages.
     * @since	1.6
     */
    protected $text_prefix = 'COM_OTEMPLATES_STYLE';
	
	function display($cachable = false, $urlparams = false) 
	{
		// call parent behavior
		parent::display($cachable);
	}
	
	/**
	 * Method to export template parameter to file for packaging progress.
	 */
	public function export()
	{
		$language = JFactory::getLanguage();
        $language->load('com_templates');
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$pk = JRequest::getInt('id');
		$model = $this->getModel();
		$table = $model->getTable();
		$table->load($pk);
		JFile::write(JPATH_ROOT . DS . 'templates' . DS . $table->template . DS . 'export' . DS . 'params_'.time().'.txt', $table->params);
		$this->setRedirect('index.php?option=com_otemplates&view=style&layout=edit&id='.$pk);
	}
	
	public function import()
	{
		$language = JFactory::getLanguage();
        $language->load('com_templates');
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$pk = JRequest::getInt('id');
		$model = $this->getModel();
		$table = $model->getTable();
		$table->load($pk);
		$registry = new JRegistry;
		
		if ($registry->loadFile(JPATH_ROOT . DS . 'templates' . DS . $table->template . DS . 'import' . DS . 'params.txt')){
			$table->params = $registry->toString();
			$table->store();
		}
		$this->setRedirect('index.php?option=com_otemplates&view=style&layout=edit&id='.$pk);
	}

	/**
	 * Method to clone and existing template style.
	 */
	public function duplicate()
	{
		$language = JFactory::getLanguage();
        $language->load('com_templates');
		
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$pks = JRequest::getVar('cid', array(), 'post', 'array');

		try
		{
			if (empty($pks)) {
				throw new Exception(JText::_('COM_TEMPLATES_NO_TEMPLATE_SELECTED'));
			}

			JArrayHelper::toInteger($pks);

			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(JText::_('COM_TEMPLATES_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		$this->setRedirect('index.php?option=com_templates&view=styles');
	}
	
	/*
	*	Delete a template style
	*/
	function delete()
	{
		$language = JFactory::getLanguage();
        $language->load('com_templates');
		
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$pks = JRequest::getVar('cid', array(), 'post', 'array');

		try
		{
			if (empty($pks)) {
				throw new Exception(JText::_('COM_TEMPLATES_NO_TEMPLATE_SELECTED'));
			}

			JArrayHelper::toInteger($pks);
			if (!is_array($pks) || count($pks) < 1) {
				JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
			} else {
				$model = $this->getModel();
				if ($model->delete($pks)) {
					$this->setMessage(JText::plural('COM_TEMPLATES_N_ITEMS_DELETED', count($pks)));
				} else {
					$this->setMessage($model->getError());
				}
			}
		}
		catch (Exception $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		$this->setRedirect('index.php?option=com_templates&view=styles');
		
	}

}