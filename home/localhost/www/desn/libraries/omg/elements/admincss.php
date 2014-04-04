<?php
/**
*	@version	$Id: admincss.php 9 2013-03-21 09:47:13Z linhnt $
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
 *	Load admin css via element
 * @since	2.0 (change from color to ocolor to be different from Joomla core field )
 *
 */
class JFormFieldAdminCss extends JFormField
{
	// Name of Element
	protected $type = 'AdminCss';

	// Function to create an element
	protected function getInput()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root().'/libraries/omg/assets/css/adm_otemplates.css');
		return '';
	}
	
	protected function getLabel()
	{
		return '';
	}
}