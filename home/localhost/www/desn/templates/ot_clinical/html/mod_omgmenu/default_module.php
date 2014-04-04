<?php
/**
*	@version	$Id: default_module.php 61 2013-06-05 10:04:55Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	mod_omgmenu
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die;

$moduleid = $item->params->get('module_id');
$database = JFactory::getDBO();
$database->setQuery("SELECT * FROM #__modules WHERE id='$moduleid'");
$moduleLoad = $database->loadObject();
$moduleLoad->user = '';
?>
<div class="item-modules">
<?php if (JModuleHelper::isEnabled($moduleLoad->module)): ?>
{omnloadmodule <?php echo $moduleLoad->module; ?>, <?php echo $moduleLoad->title; ?>, <?php echo $item->params->get('module_style', 'xhtml'); ?>, <?php echo $moduleid; ?>}
<?php endif; ?>
</div>
<?php unset($moduleid, $moduleLoad); ?>