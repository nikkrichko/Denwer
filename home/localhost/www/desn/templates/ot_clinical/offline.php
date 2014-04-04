<?php
/**
*	@version	$Id: offline.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	template ot_clinical
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die;
$app = JFactory::getApplication();
JHtml::_('bootstrap.framework');
JHtmlBootstrap::loadCss($includeMaincss = true, $this->direction);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="HandheldFriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="YES" />
	<jdoc:include type="head" />
	<style type="text/css">
		#offline{margin: 20px auto; min-width: 280px; max-width: 460px;}
		label{ text-align: right;}
	</style>
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/PIE_IE678.js"></script>
	<![endif]-->
	<!--[if IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/PIE_IE9.js"></script>
	<![endif]-->
	</head>
<body>
	<jdoc:include type="message" />
	<div id="offline">
		<div class="well">
			<?php if ($app->getCfg('offline_image')) : ?>
			<img src="<?php echo $app->getCfg('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->getCfg('sitename')); ?>" />
			<?php endif; ?>
			<h1>
				<?php echo htmlspecialchars($app->getCfg('sitename')); ?>
			</h1>
			<?php if ($app->getCfg('display_offline_message', 1) == 1 && str_replace(' ', '', $app->getCfg('offline_message')) != '') : ?>
				<p>
					<?php echo $app->getCfg('offline_message'); ?>
				</p>
			<?php elseif ($app->getCfg('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != '') : ?>
				<p>
					<?php echo JText::_('JOFFLINE_MESSAGE'); ?>
				</p>
			<?php endif; ?>
			<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login" class="form-inline">
			<fieldset class="input">
				<div class="control-group" id="form-login-username">
					<div class="controls">
						<div class="input-prepend input-append">
							<span class="add-on">
								<span class="icon-user" title="<?php echo JText::_('JGLOBAL_USERNAME') ?>"></span>
								<label for="username" class="element-invisible"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
							</span>
							<input id="username" type="text" name="username" class="input" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_USERNAME') ?>" />
						</div>
					</div>
				</div>
				<div id="form-login-password" class="control-group">
					<div class="controls">
						<div class="input-prepend input-append">
							<span class="add-on">
								<span class="icon-lock" title="<?php echo JText::_('JGLOBAL_PASSWORD') ?>">
								</span>
									<label for="passwd" class="element-invisible"><?php echo JText::_('JGLOBAL_PASSWORD'); ?>
								</label>
							</span>
							<input id="passwd" type="password" name="password" class="input" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
						</div>
					</div>
				</div>
				<div id="form-login-remember" class="control-group checkbox">
					<label for="remember" class="control-label"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label> <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
				</div>
				<div id="form-login-submit" class="control-group">
					<div class="controls">
						<button type="submit" tabindex="0" name="Submit" class="btn btn-primary btn"><?php echo JText::_('JLOGIN') ?></button>
					</div>
				</div>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.login" />
				<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</fieldset>
			</form>
		</div>
	</div>
</body>
</html>
