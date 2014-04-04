<?php
/**
*	@version	$Id: default.php 6 2013-03-20 09:20:55Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
$app = JFactory::getApplication();
$app->redirect(JRoute::_('index.php?option=com_templates&view=styles', false));
?>