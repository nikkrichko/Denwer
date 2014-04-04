<?php
/**
*	@version	$Id: paramheading.php 31 2013-04-04 02:09:38Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

//No direct access!
defined( 'JPATH_BASE' ) or die();

jimport('joomla.html.html');
jimport('joomla.form.formfield');
 /**
 *	
 * @since	2.0
 *
 */
class JFormFieldParamHeading extends JFormField
{
	// Name of Element
	protected $type = 'ParamHeading';

	// Function to create an element
	protected function getInput()
	{
		return '';
	}
	
	protected function getLabel()
	{
		$html = array();
		$class = $this->element['class'] ? (string) $this->element['class'] : 'paramheading';
		$html[] = '<div class="clr"></div>';
		$html[] = '<h' . ($this->element['level'] ? (string)$this->element['level'] : '3'). ' class="'.$class.'">';
		$html[] = JText::_($this->element['label']);
		$html[] = '</h' . ($this->element['level'] ? (string)$this->element['level'] : '3'). '>';
		return implode('', $html);
	}
}