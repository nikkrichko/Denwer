<?php
/**
*	@version	$Id: index.php 40 2013-04-10 09:02:38Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	template ot_clinical
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access!' );
$this->direction = JRequest::getVar('dir', 'ltr'); // for testing or demo only
global $omg;
require_once(dirname(__FILE__) . DS . 'lib' . DS . 'omg.tpl.php');
//$omg->document->addScript(OURI_JUI_MEDIA_JS.'/respond.min.js');
JHtml::_('bootstrap.framework');
//JHtmlBootstrap::loadCss($includeMaincss = true, $this->direction);
omg_loadBootstrapCss($includeMaincss = true, $this->direction);

// load main template CSS file
omg_loadTemplateMainCss();
// load preset CSS file
omg_loadPresetCss();
// load custom css for background and typo
omg_renderCustomBgCss();
omg_renderCustomTypoCss();

?><!doctype html>
<html class="no-js <?php 
	if ($omg->isIE('==', 7)) echo 'ie7 oldie';
	if ($omg->isIE('==', 8)) echo 'ie8 oldie';
?>" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="HandheldFriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="YES" />
	<?php echo omg_includeAppleTouchIcons(); ?>
	<jdoc:include type="head" />
	<?php 	$omg->document->addScript($omg->templateUrl.'/js/otscript.js'); ?>
	<?php 	$omg->document->addStyleSheet($omg->templateUrl.'/css/no-space.css'); ?>
	<?php 	$omg->document->addStyleSheet($omg->templateUrl.'/css/fonts.css'); ?>
	
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
			if ($omg->isIE('==', 7)) echo 'var browser="IE7";';
			if ($omg->isIE('==', 8)) echo 'var browser="IE8";';
			if ($omg->isIE('==', 9)) echo 'var browser="IE9";';
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
	<script type="text/javascript">
		window.addEvent('domready', function(){
			if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined' ) {
				Element.implement({
					slide: function(how, mode){
						return this;
					}
				});
			}
		});
	</script>
	
</head>
<body id="ot-body" class="<?php echo $omg->getBodyClass(); ?>">
	<?php 
		/* Syntax to load positions block:
				echo $omg->includeModules($blockName="BLOCKNAME", $style="STYLE"); 
				Where:
					+ $blockName: name of block decleared in templateDetails.xml
					+ $style: xhtml|raw|etc. Note that we can define these style (chrome style) in /html/module.php
				Example:
					echo $omg->includeModules("bottom1", "xhtml"); 
			
			For mainbody block:
				echo $omg->includeSidebarsAndComponent($blockName="sidebar", $sidebarStyle="xhtml", $style="xhtml";
				Where:
					+ $sidebarStyle: Chrome style of modules in sidebar
					+ $style: Chrome style of modules in other positions block, such as: content-top, content-bottom
		*/
	?>
	<div class="body-bg">
		<div class="wrapper">
			<div class="oTopBlock">
				<div class="container">
					<?php echo $omg->includeModules("top1", "standard"); ?>
					<?php echo $omg->includeModules("top2", "standard"); ?>
					<?php echo $omg->includeModules("top3", "standard"); ?>
					<?php echo $omg->includeModules("top4", "standard"); ?>
					<?php echo $omg->includeModules("top5", "standard"); ?>
				</div>
			</div>
			
			<?php if($omg->countModulesInBlock("middle1")||$omg->countModulesInBlock("middle2")||$omg->countModulesInBlock("middle3")) {?>
			<div class="oMiddleBlock">
				<?php if($omg->countModulesInBlock("middle1")) {?>
					<div class="oMiddleBlock1">
							<?php echo $omg->includeModules("middle1", "standard"); ?>
					</div>
				<?php } ?>
				<?php if($omg->countModulesInBlock("middle2")) {?>
					<div class="oMiddleBlock2">
						<div class="container">
							<?php echo $omg->includeModules("middle2", "standard"); ?>
						</div>
					</div>
				<?php } ?>
				<?php if($omg->countModulesInBlock("middle3")) {?>
					<div class="oMiddleBlock3">
						<div class="container">
							<?php echo $omg->includeModules("middle3", "standard"); ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php } ?>
			
			<div class="oMainBlock">
				<div class="container">
					<?php echo $omg->includeModules("maintop1", "standard"); ?>
					<?php echo $omg->includeModules("maintop2", "standard"); ?>
					
					<?php echo $omg->includeSidebarsAndComponent("sidebar", "standard", "standard"); ?>
					
					<?php echo $omg->includeModules("mainbottom1", "standard"); ?>
					<?php echo $omg->includeModules("mainbottom2", "standard"); ?>
				</div>
			</div>
			
			<?php if($omg->countModulesInBlock("bottom1")||$omg->countModulesInBlock("bottom2")||$omg->countModulesInBlock("bottom3")) {?>
			<div class="oBottomBlock">
				<div class="container">
					<?php echo $omg->includeModules("bottom1", "standard"); ?>
					<?php echo $omg->includeModules("bottom2", "standard"); ?>
					<?php echo $omg->includeModules("bottom3", "standard"); ?>
				</div>
			</div>
			<?php } ?>
			
			<?php if($omg->countModulesInBlock("footer1")||$omg->countModulesInBlock("footer2")) {?>
			<div class="oFooterBlock">
				<div class="container">
					<?php echo $omg->includeModules("footer1", "standard"); ?>
					<?php echo $omg->includeModules("footer2", "standard"); ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="oTemplateControl"><?php if ($showTempControl) echo $omg->includeTemplateControl(); ?></div>
</body>
</html>