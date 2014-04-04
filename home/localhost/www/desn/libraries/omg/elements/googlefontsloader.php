<?php
/**
*	@version	$Id: googlefontsloader.php 11 2013-03-25 03:09:55Z linhnt $
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
 * @since		OMG 1.0
 */
class JFormFieldGoogleFontsLoader extends JFormField
{
	// Name of Element
	protected $type = 'GoogleFontsLoader';
	
	/* Load google webfonts list
	 * @since	OMG 1.0
	 * @change	OMG 2.0 get local font file instead from our file server
	 *					load font list and js at once
	*/
	protected function getInput()
	{
		$fontsSeraliazed = '';
		if (!isset($_SESSION["gfontlist"])){
			
			// json file
			$webfontJFile = JPATH_LIBRARIES . DS . 'omg' . DS . '3rd'. DS . 'webfonts' . DS .'gwebfonts.json';
			$fontsJson = $this->file_include_contents($webfontJFile);
			
			$_SESSION["gfontlist"] = $fontsJson;
		}
		
		$document = JFactory::getDocument();
		$protocol = JFactory::getURI()->getScheme();
		
		//$document->addScript($protocol.'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');
		$document->addScript(JURI::root().'libraries/omg/3rd/webfonts/webfont.js');
		
		$script = 	'
					
					WebFont.load({
						google: {
							families: [ "Abel" ]
						}});
					
					function fontPreview(value){
						var font = value.split(":");
						var fontfamily = font[1];
						if (font[0] == "w"){
							WebFont.load({
								google: {
									families: [ fontfamily ]
								}
							});
						}
						if (font[0] == "w"){
							jQuery("span.span-font-preview").css("font-family", "\'"+fontfamily+"\'");
						}
						else{
							jQuery("span.span-font-preview").css("font-family", ""+fontfamily);
						}
						//jQuery("span.span-font-preview").html(fontfamily);
						jQuery("span.span-font-preview").html("The quick brown fox jumps over the lazy dog");
						
						jQuery("div.font-preview").css("display", "block");
						if(value == "none"){
							jQuery("div.font-preview").css("display", "none");
						}
					}
					
					function closePreview(){
						jQuery("div.font-preview").css("display", "none");
					}';
					
		$document->addScriptDeclaration($script);
        return '';
	}
	
	/* 
	 * @since	OMG 2.0
	*/
	protected function getLabel()
	{
		return '';
	}
	
	/* 
	 * @since	OMG 2.0
	*/
	function file_include_contents($filename) {
		if (is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		return false;
	}
	
	/* 
	 * @since	OMG 1.0
	*/
	function cURLcheck()
	{
		if( !function_exists("curl_init") &&
		!function_exists("curl_setopt") &&
		!function_exists("curl_exec") &&
		!function_exists("curl_close") ) return false;
		else return true;
	}
	
	/* 
	 * @since	OMG 1.0
	 * @use	deprecated
	*/
	function getContentCURL($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
