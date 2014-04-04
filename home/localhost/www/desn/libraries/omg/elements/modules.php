<?php
/**
*	@version	$Id: modules.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldModules extends JFormField
{
    protected $type = 'Modules'; //the form field type
    
    protected function getInput()
    {
    // Initialize variables.
        $html = array();
        $attr = '';
        
        $options = array();
        $db	= JFactory::getDbo();
		
        $query = $db->getQuery(true);
        $query->select('id, title, module, position');
        $query->from('#__modules AS m');
        $query->where('m.client_id = 0');
        $query->order('position, ordering');

        
        $db->setQuery($query);
        if (!($modules = $db->loadObjectList())) {
            JError::raiseWarning(500, JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $db->getErrorMsg()));
            return false;
        }

        foreach($modules as $module){
            $options[] = JHtml::_('select.option', $module->id, $module->title . ' (' . $module->module . ')');
        }
		
        array_unshift ( $options, JHTML::_('select.option', '', JText::_('OMG_SELECT_MODULE'), 'value', 'text', false));
        
        $attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
        
        $attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
        $attr .= $this->multiple ? ' multiple="multiple"' : '';
        
        // Create a regular list.
        $html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
        return implode($html);
    }
}
