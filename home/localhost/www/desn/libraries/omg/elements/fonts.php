<?php
/**
*	@version	$Id: fonts.php 9 2013-03-21 09:47:13Z linhnt $
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
 * @since	OMG 1.6
 */
class JFormFieldFonts extends JFormField
{
	// Name of Element
	protected $type = 'Fonts';
	
	// Construct an array of the HTML OPTION statements.
	var $_options = array();
	
	// Function to create an element
	protected function getInput()
	{
		
		$sans_safe = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"Tahoma, Geneva, sans-serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);
		$serif_safe = array(
			"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
			"Bookman, serif",
			"Garamond, serif",
			"Georgia, serif",
			"'MS Serif', 'New York', serif",
			"'Times New Roman', Times, serif"
		);
		$monospace_safe = array(
			"Courier, monospace",
			"'Courier New', Courier, monospace",
			"'Lucida Console', Monaco, monospace"
		);
		
		$html = array();
		$optionsHtml = array();
		
		$optionsHtml[] = '<optgroup label="Default">';
		$optionsHtml[] = '<option value="s:\'Helvetica Neue\',Helvetica,Arial,sans-serif">\'Helvetica Neue\', Arial, Helvetica, sans-serif</option>';
		$optionsHtml[] = '</optgroup>';
		
		$optionsHtml[] = '<optgroup label="Safe Fonts: Sans-Serif">';
		foreach($sans_safe as $sansfont){
			$selected = ($this->value == 's:'.htmlentities($sansfont)) ? ' selected="selected"' : '';
			$optionsHtml[] = '<option value="s:'.htmlentities($sansfont).'" '.$selected.'>'.htmlentities($sansfont).'</option>';
		}
		
		$optionsHtml[] = '<optgroup label="Safe Fonts: Serif">';
		foreach($serif_safe as $seriffont){
			$selected = ($this->value == 's:'.htmlentities($seriffont)) ? ' selected="selected"' : '';
			$optionsHtml[] = '<option value="s:'.htmlentities($seriffont).'" '.$selected.'>'.htmlentities($seriffont).'</option>';
		}
		
		$optionsHtml[] = '<optgroup label="Safe Fonts: Monospace">';
		foreach($monospace_safe as $monospace_font){
			$selected = ($this->value == 's:'.htmlentities($monospace_font)) ? ' selected="selected"' : '';
			$optionsHtml[] = '<option value="s:'.htmlentities($monospace_font).'" '.$selected.'>'.htmlentities($monospace_font).'</option>';
		}
		
		$optionsHtml[] = '</optgroup>';
		
		$optionsHtml[] = '<optgroup label="Google WebFonts">';
		
		if (!isset($_SESSION["gfontlist"]) || empty($_SESSION["gfontlist"])){
			$webfontJFile = JPATH_LIBRARIES . DS . 'omg' . DS . '3rd'. DS . 'webfonts' . DS .'gwebfonts.json';
			$fontsJson = $this->file_include_contents($webfontJFile);
			$_SESSION["gfontlist"] = $fontsJson;
		}
		$webfonts = $_SESSION["gfontlist"] ? $_SESSION["gfontlist"] : $fontsJson;
		
		
		$webfonts = @json_decode($webfonts, true);
		$wfontArray = $webfonts["items"];
		if (is_array($wfontArray) && count($wfontArray) > 0){
			foreach($wfontArray as $idx => $wfont){
				$subsets = implode(',', (array)$wfont["subsets"]);
				$selected = ($this->value == 'w:'.$wfont["family"]) ? ' selected="selected"' : '';
				$optionsHtml[] = '<option value="w:'.$wfont["family"].'" '.$selected.'>'.$wfont["family"] . ' (' .$subsets . ')'.'</option>';
			}
		}
		$optionsHtml[] = '</optgroup>';
		
		$html[] = '<div class="select-wrapper '.($this->element['class'] ? trim($this->element['class']->__toString()) : '').'">';
		$html[] = '<span class="savedValue rounded-6">'.str_replace(array('w:','s:'), '', $this->value).'</span>';
		$html[] = '		<select id="' . $this->id . '" data-value="' . $this->value . '" name="' . $this->name . '" class="selectbox-real" onchange="fontPreview(this.value);">';
		$html[] = implode("\n", $optionsHtml);
		$html[] = '		</select>';
		$html[] = '</div>';
		
		return implode('', $html);
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
}						