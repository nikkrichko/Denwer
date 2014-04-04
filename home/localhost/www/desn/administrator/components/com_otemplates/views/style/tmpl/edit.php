<?php
/**
*	@version	$Id: edit.php 24 2013-04-02 09:59:35Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	com_otemplates
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

//jimport('joomla.html.pane');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$session = JFactory::getSession();
$user = JFactory::getUser();
$document = JFactory::getDocument();

$canDo = $this->getActions();

$safeMode = $session->get('safemode') ? (bool)$session->get('safemode') : false;
$fieldSets = $this->form->getFieldsets('params');

?>
<script type="text/javascript">
	/*
	Joomla.submitbutton = function(task)
	{
		if (task == 'style.cancel' || document.formvalidator.isValid(document.id('style-form'))) {
			Joomla.submitform(task, document.getElementById('style-form'));
		}
	}
	*/
	
	jQuery(document).ready(function($) {
		<?php if(!$safeMode): ?>
		// radio buttons
		$(".oTemplateAdmin").find("fieldset.radio").buttonset();
		<?php endif; ?>
		
		/* $('#style-import').click(function(){}); */
	});
	
</script>
<div class="main-infobox">
<?php if ($safeMode) echo '<span class="badge badge-warning">'.JText::_('OTEMPLATES_SAFEMODE_ON').'</span>';?>
</div>
<div class="clr"></div>
<!--div class="otemplates-actions toolbar-list">
	<ul>
		<li id="style-import" class="button">
			<a class="toolbar" onclick="" href="#"><span class="icon-32-upload"></span>Import</a>
		</li>
		<li id="style-export" class="button">
			<a class="toolbar" onclick="" href="#"><span class="icon-32-export"></span>Export</a>
		</li>
	</ul>
</div-->
<div class="clr"></div>

<div class="clr"></div>
<form action="<?php echo JRoute::_('index.php?option=com_otemplates&view=style&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="style-form" class="form-validate">
	<div class="oTemplateAdmin <?php echo $safeMode ? 'safemode' : '' ?>" id="oTemplateAdminFormWrapper">
	<?php 
		foreach ($fieldSets as $name => $fieldSet) {
			if (isset($fieldSet->type) && $fieldSet->type == 'hidden')
			{
				foreach ($this->form->getFieldset($name) as $field){
					echo $field->input;
				}
			}
		}
	?>
	<?php echo JHtml::_('tabs.start', 'OTAdminTabs');?>
		
		<?php echo JHtml::_('tabs.panel', JText::_('JDETAILS'), 'OTAdminTabsGeneral');?>
			<div class="config-general">
				<fieldset class="adminform">
					<ul class="adminformlist">
					<li><?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?></li>

					<li><?php echo $this->form->getLabel('template'); ?>
					<?php echo $this->form->getInput('template'); ?>
					<?php echo $this->form->getLabel('client_id'); ?>
					<?php echo $this->form->getInput('client_id'); ?>
					<input type="text" size="35" value="<?php echo $this->item->client_id == 0 ? JText::_('JSITE') : JText::_('JADMINISTRATOR'); ?>	" class="readonly" readonly="readonly" /></li>

					<li><?php echo $this->form->getLabel('home'); ?>
					<?php echo $this->form->getInput('home'); ?></li>

					<?php if ($this->item->id) : ?>
						<li><?php echo $this->form->getLabel('id'); ?>
						<span class="readonly"><?php echo $this->item->id; ?></span></li>
					<?php endif; ?>
					</ul>
					<?php echo $this->form->getInput('main'); ?>
					<div class="clr"></div>
					<?php if ($this->item->xml) : ?>
						<?php if ($text = trim($this->item->xml->description)) : ?>
							<label>
								<?php echo JText::_('COM_TEMPLATES_TEMPLATE_DESCRIPTION'); ?>
							</label>
							<span class="readonly mod-desc">
								<img src="<?php echo JURI::root(); ?>/templates/<?php echo $this->item->template; ?>/template_thumbnail.png" style="float: right; margin: 0px 0px 10px 10px;" alt="<?php echo $this->item->template; ?>" />
								<?php echo JText::_($text); ?>
							</span>
						<?php endif; ?>
					<?php else : ?>
						<p class="error"><?php echo JText::_('COM_TEMPLATES_ERR_XML'); ?></p>
					<?php endif; ?>
					<div class="clr"></div>
				</fieldset>
			</div>
		
		<?php 
		foreach ($fieldSets as $name => $fieldSet) {
			if (!isset($fieldSet->type) || $fieldSet->type != 'hidden')
			{
				$label = !empty($fieldSet->label) ? $fieldSet->label : 'COM_OTEMPLATES_'.JString::strtoupper($name).'_FIELDSET_LABEL';
				
				echo JHtml::_('tabs.panel', JText::_($label), 'OTAdminTabs'.JString::ucfirst($name)); ?>
					<div class="config-<?php echo $name; ?>">
						<?php
						if (isset($fieldSet->description) && trim($fieldSet->description)) :
							echo '<div class="config-tip box-info ui-corner-all">'.$this->escape(JText::_($fieldSet->description)).'</div>';
						endif;
						?>
						<fieldset class="panelform">
							<ul class="adminformlist">
							<?php foreach ($this->form->getFieldset($name) as $field) : ?>
								<li>
									<?php if (!$field->hidden) : ?>
										<?php echo $field->label; ?>
									<?php endif; ?>
									<?php echo $field->input; ?>
								</li>
							<?php endforeach; ?>
							</ul>
						</fieldset>
						<div class="clr"></div>
					</div>
		<?php
			} 
		}  
		?>

		<?php echo JHtml::_('tabs.panel', JText::_('Menu Assignment'), 'OTAdminTabsAssignment');?>
			<div class="config-assignment">
				<?php if ($user->authorise('core.edit', 'com_menu') && $this->item->client_id==0):?>
					<?php if ($canDo->get('core.edit.state')) : ?>
						<div class="">
						<?php echo $this->loadTemplate('assignment'); ?>
						</div>
						<?php endif; ?>
					<?php endif;?>
				<div class="clr"></div>
			</div>
	<?php echo JHtml::_('tabs.end'); ?>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
