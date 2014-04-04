<?php
/**
*	@version	$Id: functions.php 33 2013-04-05 01:42:03Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	template ot_clinical
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('OMG_VERSION') or die();

/*
*	Load main template css
*/
function omg_loadTemplateMainCss($url = '/css/template.css')
{
	global $omg;
	$omg->document->addStyleSheet($omg->templateUrl . $url);
}

/*
*	Load main template css
*/
function omg_loadPresetCss()
{
	global $omg;
	$session = JFactory::getSession();
	// if have post, set to session
	if (JRequest::getVar('submit_preset')){
		$post = JRequest::get('post');
		if (isset($post['params_demo'])) $session->set('template_demo', array('params_demo' => $post['params_demo']));
	}
	//get from session
	$template_demo = $session->get('template_demo');
	$preset = (intval($omg->params->get('show_template_control', 0)) == 1 && isset($template_demo['params_demo']['preset'])) ? $template_demo['params_demo']['preset'] : trim($omg->params->get('preset', '1'));
	if (isset($preset) && $preset != '') $omg->document->addStyleSheet($omg->templateUrl . '/css/preset-style-' . $preset . '.css');
}

/*
* @desc:	Render custom background css
* @params:
* @output: style tag and css already add to head
*/
function omg_renderCustomBgCss(){
	global $omg;
	
	$customBgOutput = array();
	$rootUri = JURI::root();
	/* 
	// OLD versions
	$customBg = (array)$omg->params->get('background');
	if (isset($customBg) && is_array($customBg) && count($customBg) > 0){
		
		foreach($customBg as $selector => $cssValue)
		{
			if(isset($cssValue->bg_overide) && (int)$cssValue->bg_overide == 1)
			{
				$bg = array();
				$bg[] = '.'.$selector;
				$bg[] = ' {';
				if (isset($cssValue->bg_image) && trim($cssValue->bg_image) != "") $bg[] = 'background-image:url("' . $rootUri . trim($cssValue->bg_image) . '");';
				if (isset($cssValue->bg_repeat) && trim($cssValue->bg_repeat) != "") $bg[] = 'background-repeat:' . trim($cssValue->bg_repeat) . ';';
				$tranparent = (isset($cssValue->bg_transparent) && (int)$cssValue->bg_transparent == 1);
				if (isset($cssValue->bg_color) && trim($cssValue->bg_color) != "" && !$tranparent) {
					$bg[] = 'background-color:' . trim($cssValue->bg_color) . ';';
				} else {
					$bg[] = 'background-color:transparent;';
				}
				$bg[] = '}';
				$customBgOutput[] = implode('', $bg);
			}
		}
		unset($selector, $cssValue);
	}
	 */
	
	// New version of templateDetail
	
	//body custom background
	if (intval($omg->params->get('oBody_bg_overide', 0)) == 1){
		$bg = array();
		$bg[] = 'body';
		$bg[] = ' {';
		$bg[] = 'background-image:url("' . $rootUri . trim($omg->params->get('oBody_bg_image','')) . '");';
		$bg[] = 'background-repeat:' . trim($omg->params->get('oBody_bg_repeat', 'repeat')) . ';';
		$tranparent = intval($omg->params->get('oBody_bg_transparent', 0)) == 1;
		$bgc = trim($omg->params->get('oBody_bg_color',''));
		if ($bgc != "" && !$tranparent) {
			$bg[] = 'background-color:' . $bgc . ';';
		} else {
			$bg[] = 'background-color:transparent;';
		}
		$bg[] = ' }';
		$customBgOutput[] = implode('', $bg);
	}
	
	// oTopBlock custom background
	if (intval($omg->params->get('oTopBlock_bg_overide', 0)) == 1){
		$bg = array();
		$bg[] = '.oTopBlock';
		$bg[] = ' {';
		$bg[] = 'background-image:url("' . $rootUri . trim($omg->params->get('oTopBlock_bg_image','')) . '");';
		$bg[] = 'background-repeat:' . trim($omg->params->get('oTopBlock_bg_repeat', 'repeat')) . ';';
		$tranparent = intval($omg->params->get('oTopBlock_bg_transparent', 0)) == 1;
		$bgc = trim($omg->params->get('oTopBlock_bg_color',''));
		if ($bgc != "" && !$tranparent) {
			$bg[] = 'background-color:' . $bgc . ';';
		} else {
			$bg[] = 'background-color:transparent;';
		}
		$bg[] = ' }';
		$customBgOutput[] = implode('', $bg);
	}
	
	// oMiddleBlock custom background
	if (intval($omg->params->get('oMiddleBlock_bg_overide', 0)) == 1){
		$bg = array();
		$bg[] = '.oMiddleBlock';
		$bg[] = ' {';
		$bg[] = 'background-image:url("' . $rootUri . trim($omg->params->get('oMiddleBlock_bg_image','')) . '");';
		$bg[] = 'background-repeat:' . trim($omg->params->get('oMiddleBlock_bg_repeat', 'repeat')) . ';';
		$tranparent = intval($omg->params->get('oMiddleBlock_bg_transparent', 0)) == 1;
		$bgc = trim($omg->params->get('oMiddleBlock_bg_color',''));
		if ($bgc != "" && !$tranparent) {
			$bg[] = 'background-color:' . $bgc . ';';
		} else {
			$bg[] = 'background-color:transparent;';
		}
		$bg[] = ' }';
		$customBgOutput[] = implode('', $bg);
	}
	
	// oMainBlock custom background
	if (intval($omg->params->get('oMainBlock_bg_overide', 0)) == 1){
		$bg = array();
		$bg[] = '.oMainBlock';
		$bg[] = ' {';
		$bg[] = 'background-image:url("' . $rootUri . trim($omg->params->get('oMainBlock_bg_image','')) . '");';
		$bg[] = 'background-repeat:' . trim($omg->params->get('oMainBlock_bg_repeat', 'repeat')) . ';';
		$tranparent = intval($omg->params->get('oMainBlock_bg_transparent', 0)) == 1;
		$bgc = trim($omg->params->get('oMainBlock_bg_color',''));
		if ($bgc != "" && !$tranparent) {
			$bg[] = 'background-color:' . $bgc . ';';
		} else {
			$bg[] = 'background-color:transparent;';
		}
		$bg[] = ' }';
		$customBgOutput[] = implode('', $bg);
	}
	
	// oBottomBlock custom background
	if (intval($omg->params->get('oBottomBlock_bg_overide', 0)) == 1){
		$bg = array();
		$bg[] = '.oBottomBlock';
		$bg[] = ' {';
		$bg[] = 'background-image:url("' . $rootUri . trim($omg->params->get('oBottomBlock_bg_image','')) . '");';
		$bg[] = 'background-repeat:' . trim($omg->params->get('oBottomBlock_bg_repeat', 'repeat')) . ';';
		$tranparent = intval($omg->params->get('oBottomBlock_bg_transparent', 0)) == 1;
		$bgc = trim($omg->params->get('oBottomBlock_bg_color',''));
		if ($bgc != "" && !$tranparent) {
			$bg[] = 'background-color:' . $bgc . ';';
		} else {
			$bg[] = 'background-color:transparent;';
		}
		$bg[] = ' }';
		$customBgOutput[] = implode('', $bg);
	}
	
	// oFooterBlock custom background
	if (intval($omg->params->get('oFooterBlock_bg_overide', 0)) == 1){
		$bg = array();
		$bg[] = '.oFooterBlock';
		$bg[] = ' {';
		$bg[] = 'background-image:url("' . $rootUri . trim($omg->params->get('oFooterBlock_bg_image','')) . '");';
		$bg[] = 'background-repeat:' . trim($omg->params->get('oFooterBlock_bg_repeat', 'repeat')) . ';';
		$tranparent = intval($omg->params->get('oFooterBlock_bg_transparent', 0)) == 1;
		$bgc = trim($omg->params->get('oFooterBlock_bg_color',''));
		if ($bgc != "" && !$tranparent) {
			$bg[] = 'background-color:' . $bgc . ';';
		} else {
			$bg[] = 'background-color:transparent;';
		}
		$bg[] = ' }';
		$customBgOutput[] = implode('', $bg);
	}
	
	if(count($customBgOutput)) $omg->document->addStyleDeclaration(implode("\n", $customBgOutput));
}

/*
*	Render custom typo css
*/
function omg_renderCustomTypoCss(){
	global $omg;
	
	$customTypoOutput = array();
	$fontArray = array();
	$gFontArray = array();
	
	/* 
	// OLd version
	$typography = omg_object2ArrayRescue($omg->params->get('typography'));
	
	if (isset($typography) && is_array($typography) && count($typography) > 0){
		foreach ($typography as $selector => $cssValue){
			if (isset($cssValue['typo_overide']) && (int)$cssValue['typo_overide'] == 1){
				$css = array();
				if (is_array($cssValue) && count($cssValue) > 0){
					$css[] = $selector . ' {';
					foreach($cssValue as $attr => $value){
						if ($attr != 'typo_overide' && $value != 'none') {
							if ($attr == 'font-family'){
								$font_family = explode(':', trim($value));
								if (isset($font_family[0]) && isset($font_family[1])){
									if ($font_family[0] == 'w'){
										$gFontArray[] = $font_family[1];
										$css[] = $attr . ':"' . $font_family[1] . '";';
									}
									else{
										$css[] = $attr . ':' . $font_family[1] . ';';
									}
								}
							}
							else {
								$css[] = $attr . ':' . $value . ';';
							}
						}
					}
					$css[] = '}';
				}
				else{
					// no idea
				}
				$customTypoOutput[] = implode('', $css);
			}
		}
	}
	 */
	
	// New version of templateDetail
	
	//body typo
	if (intval($omg->params->get('body_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'body';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('body_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('body_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('body_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	
	//anchor typo
	if (intval($omg->params->get('a_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'a';
		$tp[] = ' {';
		$color = trim($omg->params->get('a_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	if (intval($omg->params->get('a_hover_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'a:hover';
		$tp[] = ' {';
		$color = trim($omg->params->get('a_hover_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	
	//heading typo
	if (intval($omg->params->get('h1_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'h1';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('h1_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('h1_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('h1_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	if (intval($omg->params->get('h2_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'h2';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('h2_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('h2_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('h2_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	if (intval($omg->params->get('h3_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'h3';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('h3_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('h3_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('h3_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	if (intval($omg->params->get('h4_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'h4';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('h4_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('h4_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('h4_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	if (intval($omg->params->get('h5_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'h5';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('h5_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('h5_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('h5_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	if (intval($omg->params->get('h6_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'h6';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('h6_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('h6_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('h6_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
	
	//blockquote typo
	if (intval($omg->params->get('blockquote_typo_overide', 0)) == 1){
		$tp = array();
		$tp[] = 'h6';
		$tp[] = ' {';
		$font_family = explode(':', trim($omg->params->get('blockquote_font_family','')));
		if (isset($font_family[0]) && isset($font_family[1])){
			if ($font_family[0] == 'w'){
				$gFontArray[] = $font_family[1];
				$tp[] = 'font-family:"' . $font_family[1] . '";';
			}
			else{
				$tp[] = 'font-family:' . $font_family[1] . ';';
			}
		}
		$fontsize = trim($omg->params->get('blockquote_font_size',''));
		if ($fontsize != '') $tp[] = 'font-size:'.$fontsize.';';
		$color = trim($omg->params->get('blockquote_color',''));
		if ($color != '') $tp[] = 'color:'.$color.';';
		
		$tp[] = ' }';
		$customTypoOutput[] = implode('', $tp);
	}
		
	if (count($gFontArray) > 0){
		omg_loadGWebfontCss($gFontArray);
	}
	
	if(count($customTypoOutput)) $omg->document->addStyleDeclaration(implode("\n", $customTypoOutput));
}


/*
*	render google analytics code
*/
function omg_includeGA($uacode)
{
	//global $omg;
	ob_start();
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $uacode; ?>']);
		_gaq.push(['_trackPageview']);
		
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async
		= true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www')
		+ '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga,
		s);
		})();
	</script>
	<?php
	return ob_get_clean();
}


/*
*	render apple touch icons
*/
function omg_includeAppleTouchIcons()
{
	global $omg;
	ob_start();
	?>
	<link rel="apple-touch-icon-precomposed" href="<?php echo $omg->templateUrl; ?>/images/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $omg->templateUrl; ?>/images/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $omg->templateUrl; ?>/images/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $omg->templateUrl; ?>/images/apple-touch-icon-144x144-precomposed.png">
	<?php
	return ob_get_clean();
}

?>