<?php
/**
*	@version	$Id: edit_assignment.php 6 2013-03-20 09:20:55Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// No direct access.
defined('_JEXEC') or die;

// Initiasile related data.
require_once JPATH_ADMINISTRATOR.'/components/com_menus/helpers/menus.php';
$menuTypes = MenusHelper::getMenuLinks();
$user = JFactory::getUser();
?>
<script type="text/javascript">
	function toggleMenuSelection(){
		jQuery('.chk-menulink').each(function(i,el) {el.checked = !el.checked; });
	}
	function allMenuSelection(){
		jQuery('.chk-menulink').each(function(i,el) {el.checked = true; });
	}
	function noneMenuSelection(){
		jQuery('.chk-menulink').each(function(i,el) {el.checked = false; });
	}
</script>

<fieldset class="adminform">
	<legend><?php echo JText::_('COM_TEMPLATES_MENUS_ASSIGNMENT'); ?></legend>
		<label id="jform_menuselect-lbl" for="jform_menuselect"><?php echo JText::_('JGLOBAL_MENU_SELECTION'); ?></label>
		
		<button type="button" class="jform-rightbtn" onclick="javascript: noneMenuSelection();">
			<?php echo JText::_('JGLOBAL_SELECTION_NONE'); ?>
		</button>
		<button type="button" class="jform-rightbtn" onclick="javascript: toggleMenuSelection();">
			<?php echo JText::_('JGLOBAL_SELECTION_INVERT'); ?>
		</button>
		<button type="button" class="jform-rightbtn" onclick="javascript: allMenuSelection();">
			<?php echo JText::_('JGLOBAL_SELECTION_ALL'); ?>
		</button>
		<div class="clr"></div>
		<div id="menu-assignment">

		<?php foreach ($menuTypes as &$type) : ?>
			<ul class="menu-links">
				<h3><?php echo $type->title ? $type->title : $type->menutype; ?></h3>
				<?php foreach ($type->links as $link) :?>
				<li class="menu-link">
					<input type="checkbox" name="jform[assigned][]" value="<?php echo (int) $link->value;?>" id="link<?php echo (int) $link->value;?>"<?php if ($link->template_style_id == $this->item->id):?> checked="checked"<?php endif;?><?php if ($link->checked_out && $link->checked_out != $user->id):?> disabled="disabled"<?php else:?> class="chk-menulink "<?php endif;?> />
					<label for="link<?php echo (int) $link->value;?>" >
						<?php echo $link->text; ?>
					</label>
				</li>
				<?php endforeach; ?>
			</ul>
		<?php endforeach; ?>
		</div>

</fieldset>
