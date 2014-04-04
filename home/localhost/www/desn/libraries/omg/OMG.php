<?php 
/**
*	@version	$Id: OMG.php 37 2013-04-05 07:29:24Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('JPATH_BASE') or die('Restricted Access');

/*
* OMG input stage
*/
if (!defined('OMG_VERSION'))
{
	/*
	* framework name&version
	*/
	define('OMG_VERSION', '2.0');
	// for safe, check again DS defined
	if (!defined('OGRID_SYS')) {
		define('OGRID_SYS', 12);
	}
	
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}
	// define the OMG lib path
	if (!defined('OPATH_LIB_BASE')) {
		define('OPATH_LIB_BASE', dirname(__FILE__));
	}
	if (!defined('OPATH_LIB_CORE')) {
		define('OPATH_LIB_CORE', OPATH_LIB_BASE . DS . 'core');
	}
	if (!defined('OPATH_LIB_CLASS')) {
		define('OPATH_LIB_CLASS', OPATH_LIB_BASE . DS . 'classes');
	}
	if (!defined('OPATH_LIB_LAYOUTS')) {
		define('OPATH_LIB_LAYOUTS', OPATH_LIB_BASE . DS . 'layouts');
	}
	if (!defined('OPATH_LIB_3RD')) {
		define('OPATH_LIB_3RD', OPATH_LIB_BASE . DS . '3rd');
	}
	if (!defined('OPATH_LIB_J3HTML')) {
		define('OPATH_LIB_J3HTML', OPATH_LIB_BASE . DS . 'joomla' . DS . 'html');
	}
	if (!defined('OPATH_LIB_BOOTSTRAP')) {
		define('OPATH_LIB_BOOTSTRAP', OPATH_LIB_BASE . DS . 'joomla' . DS . 'cms' . DS . 'html');
	}
	if (!defined('OPATH_LIB_OVERIDE')) {
		define('OPATH_LIB_OVERIDE', OPATH_LIB_BASE . DS . 'overide');
	}
	if (!defined('OPATH_LIB_LESS')) {
		define('OPATH_LIB_LESS', OPATH_LIB_3RD . DS . 'less');
	}
	
	// define uri
	if (!defined('OURI_COMPONENT_MEDIA')) {
		define('OURI_COMPONENT_MEDIA', JURI::root(true) . '/media/com_otemplates');
	}
	if (!defined('OURI_JUI_MEDIA')) {
		define('OURI_JUI_MEDIA', JURI::root(true) . '/media/jui');
	}
	if (!defined('OURI_JUI_MEDIA_JS')) {
		define('OURI_JUI_MEDIA_JS', JURI::root(true) . '/media/jui/js');
	}
	if (!defined('OURI_JUI_MEDIA_CSS')) {
		define('OURI_JUI_MEDIA_CSS', JURI::root(true) . '/media/jui/css');
	}
	if (!defined('OURI_JUI_MEDIA_LESS')) {
		define('OURI_JUI_MEDIA_LESS', JURI::root(true) . '/media/jui/less');
	}
	if (!defined('OURI_JUI_MEDIA_IMG')) {
		define('OURI_JUI_MEDIA_IMG', JURI::root(true) . '/media/jui/img');
	}
	
	global $omg;
	
	// register core and other omg classes
	JLoader::discover('OMG', OPATH_LIB_CORE, $force = false, $recurse = true);
	JLoader::discover('OMG', OPATH_LIB_CLASS, $force = false, $recurse = true);
	
	// register overiding class
	JLoader::discover('OMG', OPATH_LIB_CLASS, $force = false, $recurse = true);
	
	// Register overide / extends renderer classes
	foreach(JFolder::files(OPATH_LIB_OVERIDE . DS . 'documentrenderer') as $file) {
		JLoader::register('JDocumentRenderer'.JString::ucfirst(JFile::stripExt($file)), OPATH_LIB_OVERIDE . DS . 'documentrenderer' . DS . $file);
	}
	unset($file);
	
	/*
	*	init omg core
	*/
	function omg_init(){
		global $omg;
		$omg = new OMGCore();
	}
	
	/*
	*	Register bootstrap classes
	*/
	function omg_reg_bootstrap(){
		foreach(JFolder::files(OPATH_LIB_BOOTSTRAP) as $file) {
			JLoader::register('Jhtml'.JString::ucfirst(JFile::stripExt($file)), OPATH_LIB_BOOTSTRAP . DS . $file, true);
		}
	}
	
	
	/* Other template functions here */
	
	/*
	*	Convert object to multi-dimension array
	*/
	function omg_object2ArrayRescue($object)
	{
		if(!is_object( $object ) && !is_array( $object ))
		{
			return $object;
		}
		if(is_object($object) )
		{
			$object = get_object_vars( $object );
		}
		return array_map('omg_object2ArrayRescue', $object );
	} 
	
	
	/*
	*	Load all google webfonts at once
	*/
	function omg_loadGWebfontCss($gFontArray = array())
	{
		global $omg;
		if (count($gFontArray) < 1) return;
		
		$font = implode('|', $gFontArray);
		$font = str_replace(' ', '+', trim($font));
		
		$omg->document->addStyleSheet('http://fonts.googleapis.com/css?family=' . $font);
	}
	
	/*
	*	Load bootstrap css
	*/
	function omg_loadBootstrapCss($includeMainCss = true, $direction = 'ltr', $attribs = array())
	{
		global $omg;
		
		// Load Bootstrap main CSS
		if ($includeMainCss)
		{
			JHtml::_('stylesheet', 'media/jui/css/bootstrap.min.css', $attribs, false);
			if (!$omg->isIE() || $omg->isIE('>', 7)) JHtml::_('stylesheet', 'media/jui/css/bootstrap-responsive.min.css', $attribs, false);
			JHtml::_('stylesheet', 'media/jui/css/bootstrap-extended.css', $attribs, false);
		}

		// Load Bootstrap RTL CSS
		if ($direction === 'rtl')
		{
			// Todo: Test more and add minified files after
			//JHtml::_('stylesheet', 'media/jui/css/j3original_bootstrap-rtl.css', $attribs, false);
			JHtml::_('stylesheet', 'media/jui/css/bootstrap-rtl.css', $attribs, false);
			if (!$omg->isIE() || $omg->isIE('>', 7)) JHtml::_('stylesheet', 'media/jui/css/bootstrap-responsive-rtl.css', $attribs, false);
		}
	}

}
?>