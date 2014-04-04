<?php
/**
*	@version	$Id: ocolor.php 32 2013-04-04 02:15:22Z linhnt $
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
 *	Load jscolor
 * @since	2.0 (change from color to ocolor to be different from Joomla core field )
 *
 */
class JFormFieldOColor extends JFormField
{
	// Name of Element
	protected $type = 'OColor';

	// Function to create an element
	protected function getInput()
	{
		$document = JFactory::getDocument();
		$document->addScript(JURI::root().'/libraries/omg/3rd/colorchooser/jscolor.js');
		return '';
	}
	
	protected function getLabel()
	{
		return '';
	}
}