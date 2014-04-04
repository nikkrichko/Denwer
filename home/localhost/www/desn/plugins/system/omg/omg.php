<?php
/**
*	@version	$Id: omg.php 18 2013-04-01 05:16:20Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	plg_omg system plugin for com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die ('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemOMG extends JPlugin
{
	function plgSystemOMG($subject, $params){
		parent::__construct($subject, $params);
	}
	
	/**
	 * Catch the routed functions for
	 */
	public function onAfterRoute()
	{
		$app = JFactory::getApplication();
		
		// check if not library installed just tell and return
		if (!file_exists(JPATH_LIBRARIES . DS . 'omg' . DS . 'OMG.php')) {
			$app->enqueueMessage(JText::_('OMG_LIBRARY_FILE_NOT_FOUND'));
			return;
		}
		require_once(JPATH_LIBRARIES . DS . 'omg' . DS . 'OMG.php');
		
		if ($app->isSite()) {
			
			if(intval($this->params->get('loadRespondIE', 1))){
				$document = JFactory::getDocument();
				$document->addScript(OURI_JUI_MEDIA_JS.'/respond.min.js');
			}
			if(intval($this->params->get('autoload_bootstrap', 1))){
				// load jQuery and bootstrap before mootools and mootools script
				omg_reg_bootstrap();
				JHtml::_('bootstrap.framework');
			}
			
		} else {
			if (array_key_exists('option', $_REQUEST) && array_key_exists('task', $_REQUEST)) {
				$option = JRequest::getVar('option');
				$task   = JRequest::getVar('task');

				// overide the duplicate task
				if ($option == 'com_templates' && $task == 'styles.duplicate') {
					$this->setRequestOption('option', 'com_otemplates');
					$this->setRequestOption('task', 'style.duplicate');
				}

				// overide the delete task
				if ($option == 'com_templates' && $task == 'styles.delete') {
					$this->setRequestOption('option', 'com_otemplates');
					$this->setRequestOption('task', 'style.delete');
				}

				// overide the edit task
				if ($option == 'com_templates' && $task == 'style.edit') {
					$id = JRequest::getInt('id', 0);
					if ($id == 0) {
						// Initialise variables.
						$pks = JRequest::getVar('cid', array(), 'post', 'array');
						if (is_array($pks) && array_key_exists(0, $pks)) {
							$id = $pks[0];
						}
					}

					//redirect to own template component
					if ($this->isOMGTemplate($id)) {
						$this->setRequestOption('option', 'com_otemplates');
						$this->setRequestOption('task', 'style.edit');
						$this->setRequestOption('id', $id);
					}
				}
			}
		}

	}
	
	public function onAfterRender()
	{
		$app = JFactory::getApplication();

		if (!$app->isAdmin()) return;

		$option = JRequest::getString('option', '');
		$view   = JRequest::getString('view', '');
		$task   = JRequest::getString('task', '');

		if ($option == 'com_templates' && (($view == 'styles') || (empty($view) && empty($task)))) {
			$mainTemplates = $this->getOMGMainTemplates();
			$omgTemplates = $this->getOMGTemplates();
			if (!class_exists('phpQuery')) {
				require_once(JPATH_LIBRARIES . "/omg/3rd/phpQuery.php");
			}
			$document = JFactory::getDocument();
			$doctype  = $document->getType();
			if ($doctype == 'html') {
				$body = JResponse::getBody();
				$pq   = phpQuery::newDocument($body);

				foreach ($omgTemplates as $omgTemplate) {
					if (in_array($omgTemplate['id'], $mainTemplates)) {
						pq('td > input[value=' . $omgTemplate['id'] . ']')->parent()->next()->append('<span>('.JText::_('Original').')</span>');
					} else {
						pq('td > input[value=' . $omgTemplate['id'] . ']')->parent()->next()->append('<span>('.JText::_('Copy').')</span>');
					}

					$link  = pq('td > input[value=' . $omgTemplate['id'] . ']')->parent()->next()->find('a:not([title])');
					$value = str_replace('com_templates','com_otemplates', $link->attr('href'));
					
					$link->attr('href', $value);
					pq('td > input[value=' . $omgTemplate['id'] . ']')->parent()->next()->append('&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: #CC0000;font-size:12px;">To edit style in simple mode, click here: '.$link->clone()->attr('href', $value.'&safemode=1').' </span>');
				}


				$body = $pq->getDocument()->htmlOuter();
				JResponse::setBody($body);
			}
		}

		if ($option == 'com_otemplates') {


			if (!class_exists('phpQuery')) {
				require_once(JPATH_LIBRARIES . "/omg/3rd/phpQuery.php");
			}

			$body = JResponse::getBody();
			$pq   = phpQuery::newDocument($body);
			$body = $pq->getDocument()->htmlOuter();
			JResponse::setBody($body);
		}
	}

	public function onBeforeCompileHead()
	{
		// load jQuery and bootstrap after mootools and mootools script
		//JHtml::_('bootstrap.framework');
	}
	
	private function isOMGTemplate($id)
	{
		// Get a row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$return = $table->load($id);

		// Check for a table object error.
		if ($return === false && $table->getError()) {
			$this->setError($table->getError());
			return false;

		}
		$template = $table->template;
		return file_exists(JPATH_SITE . DS . 'templates' . DS . $template . DS . 'lib' . DS . 'omg.tpl.php');

	}
	
	private function setRequestOption($key, $value)
	{
		JRequest::set(array($key => $value), 'GET');
		JRequest::set(array($key => $value), 'POST');
	}
	
	public function getTable($type = 'Style', $prefix = 'TemplatesTable', $config = array())
	{
		JTable::addIncludePath(JPATH_ADMINISTRATOR . DS. 'components' . DS . 'com_templates' . DS . 'tables');
		return JTable::getInstance($type, $prefix, $config);
	}
	
	private function getTemplates()
	{
		$cache = JFactory::getCache('com_templates', '');
		$tag   = JFactory::getLanguage()->getTag();

		$templates = $cache->get('templates0' . $tag);

		if ($templates === false) {
			// Load styles
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id, home, template, s.params');
			$query->from('#__template_styles as s');
			$query->where('s.client_id = 0');
			$query->where('e.enabled = 1');
			$query->leftJoin('#__extensions as e ON e.element=s.template AND e.type=' . $db->quote('template') . ' AND e.client_id=s.client_id');

			$db->setQuery($query);
			$templates = $db->loadObjectList('id');

			foreach ($templates as &$template) {
				$registry = new JRegistry;
				$registry->loadString($template->params);
				$template->params = $registry;

				// Create home element
				if ($template->home == '1' && !isset($templates[0]) && $template->home == $tag) {
					$templates[0] = clone $template;
				}
			}
			$cache->store($templates, 'templates0' . $tag);
		}
		return $templates;
	}

	
	/**
	 * @return array
	 */
	private function getOMGMainTemplates()
	{
		$templates = $this->getTemplates();
		$mainTemplates = array();
		if (count($templates)){
			foreach ($templates as $template) {
				if ($template->params->get('main') == 'true') {
					$mainTemplates[] = $template->id;
				}
			}
		}
		return $mainTemplates;
	}

	/**
	 * @return array
	 */
	private function getOMGTemplates()
	{
		$templates = $this->getTemplates();
		$omgTemplates = array();
		foreach ($templates as $template) {
			if ($template->params->get('main') != null) {
				$omgTemplates[] = array('id' => $template->id, 'name' => ucfirst($template->template));
			}
		}

		return $omgTemplates;
	}

}
