<?php
/**
*	@version	$Id: tips.php 9 2013-03-21 09:47:13Z linhnt $
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
 *	Load jsposition
 * @since	2.0 (script loader for position settings)
 *
 */
class JFormFieldTips extends JFormField
{
	// Name of Element
	protected $type = 'Tips';

	// Function to create an element
	protected function getInput()
	{
		if (isset($this->element['description']))
		return JText::_($this->element['description']);
		
	}
	
	protected function getLabel()
	{
		return '';
	}
}