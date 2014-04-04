<?php
/**
*	@version	$Id: component.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	template ot_clinical
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

//No direct access!
defined( '_JEXEC' ) or die( 'Restricted access' );

global $omg;
require_once(dirname(__FILE__) . DS . 'lib' . DS . 'omg.tpl.php');
$omg->document->addScript(OURI_JUI_MEDIA_JS.'/respond.min.js');
JHtml::_('bootstrap.framework');
JHtmlBootstrap::loadCss($includeMaincss = true, $this->direction);

// load main template CSS file
omg_loadTemplateMainCss();
// load preset CSS file
omg_loadPresetCss();
// load custom css for background and typo
omg_renderCustomBgCss();
omg_renderCustomTypoCss();

?><!doctype html>
<!--[if IEMobile]> <html class="iemobile" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 7]> <html class="no-js ie7 oldie" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 8]> <html class="no-js ie8 oldie" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"><!--<![endif]-->
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="HandheldFriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="YES" />
	<jdoc:include type="head" />
	<!--[if lt IE 9]>
		<?php if($loadHTML5Shiv): ?>
		<script src="<?php echo OURI_JUI_MEDIA_JS; ?>/html5.js"></script>
		<?php endif; ?>
		
		<?php if ($loadPIE) : ?>
		<script src="<?php echo OURI_JUI_MEDIA_JS; ?>/PIE_IE678.js"></script>
		<?php endif; ?>
	<![endif]-->
	<!--[if IE 9]>
		<?php if ($loadPIE) : ?>
		<script src="<?php echo OURI_JUI_MEDIA_JS; ?>/PIE_IE9.js"></script>
		<?php endif; ?>
	<![endif]-->
	<script type="text/javascript">
		<?php 
			if ($omg->isIE('==', 7)) echo 'var browser="IE7"';
			if ($omg->isIE('==', 8)) echo 'var browser="IE8"';
			if ($omg->isIE('==', 9)) echo 'var browser="IE9"';
		?>
	</script>
	
	<?php if ($omg->isIE('<=', 9) && $loadPIE) : ?>
		<script type="text/javascript">
		// attach PIE to selectors which we want to apply CSS3 to
		jQuery(function($) {
			if (window.PIE) {
				$('.oPos').each(function() {
					PIE.attach(this);
				});
			}
		});
		</script>
	<?php endif; ?>
	
	<?php if ($ga_enabled && $uacode != ''){ echo omg_includeGA($uacode); } // Google Analytics ?>
</head>
<body id="ot-body-component" class="<?php echo $omg->getBodyClass(); ?>">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</body>
</html>