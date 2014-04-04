<?php
/**
*	@version	$Id: jquery.php 9 2013-03-21 09:47:13Z linhnt $
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
 *	Load jQuery via element
 * @since	2.0
 *
 */
class JFormFieldJQuery extends JFormField
{
	// Name of Element
	protected $type = 'JQuery';

	// Function to create an element
	protected function getInput()
	{
		JHtml::_('script', 'jui/jquery.min.js', false, true, false, false, false);
		JHtml::_('script', 'jui/jquery-noconflict.js', false, true, false, false, false);
		return '';
	}
	
	protected function getLabel()
	{
		return '';
	}
}