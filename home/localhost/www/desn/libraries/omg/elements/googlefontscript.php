<?php
/**
*	@version	$Id: googlefontscript.php 11 2013-03-25 03:09:55Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

/* currently not use this */

//No direct access!
defined( 'JPATH_BASE' ) or die();

jimport('joomla.html.html');
jimport('joomla.form.formfield');

 /**
 * @since		OMG 1.0
 */
class JFormFieldGoogleFontScript extends JFormField
{
	// Name of Element
	protected $type = 'GoogleFontScript';
	
	// Function to create an element
	protected function getInput()
	{
	
		$document = JFactory::getDocument();
		$protocol = JFactory::getURI()->getScheme();
		
		$document->addScript($protocol.'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');
		//$document->addScript(JURI::root().'libraries/omg/3rd/webfonts/webfont.js');
		
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
	
	protected function getLabel()
	{
		return '';
	}
}						