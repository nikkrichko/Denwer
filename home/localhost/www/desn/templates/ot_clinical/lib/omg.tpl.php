<?php
/**
*	@version	$Id: omg.tpl.php 18 2013-04-01 05:16:20Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	template ot_clinical
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die();

if (!file_exists(JPATH_LIBRARIES . DS . 'omg' . DS . 'OMG.php')) {
	echo JText::_('OMG_LIBRARY_FILE_NOT_FOUND');
    die;
}
require_once(JPATH_LIBRARIES . DS . 'omg' . DS . 'OMG.php');
require_once(dirname(__FILE__) . DS . 'functions.php');

// register bootstrap
omg_reg_bootstrap();

// init core
omg_init();

// some parameters need to use in template
$ga_enabled = 		intval($omg->params->get('google_analytics_enabled', 0)) == 1;
$uacode = 			trim($omg->params->get('google_analytics_uacode', ''));
$loadPIE = 			intval($omg->params->get('loadPIE', 1)) == 1;
$loadHTML5Shiv = 	intval($omg->params->get('loadHTML5Shiv', 1)) == 1;
$showTempControl = 	intval($omg->params->get('show_template_control', 0)) == 1;

