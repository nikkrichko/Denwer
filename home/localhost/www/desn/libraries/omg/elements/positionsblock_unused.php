<?php
/**
*	@version	$Id: positionsblock_unused.php 18 2013-04-01 05:16:20Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('JPATH_BASE') or die;

class JFormFieldPositionsBlock extends JFormField
{
	protected $type = 'PositionsBlock';
	const DEFAULT_GRID_SIZE = 12;
	protected $gridSize;
	protected $gridMaps = array(
		'1' => array(12),
		'2' => array(10,2),
		'3' => array(8,2,2),
		'4' => array(6,2,2,2),
		'5' => array(4,2,2,2,2),
		'6' => array(2,2,2,2,2,2)
	);

	protected function getInput()
	{
		// if safemode is on, then just display position block field as a text input
		$session = JFactory::getSession();
		$safeMode = $session->get('safemode') ? (bool)$session->get('safemode') : false;
		if ($safeMode) {
			// Initialize some field attributes.
			$size = $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
			$maxLength = $this->element['maxlength'] ? ' maxlength="' . (int) $this->element['maxlength'] . '"' : '';
			$class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
			$readonly = ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
			$disabled = ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

			// Initialize JavaScript field attributes.
			$onchange = $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

			return '<input class="clear-view" type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="'
				. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . $class . $size . $disabled . $readonly . $onchange . $maxLength . '/>';
		}
		// otherwise
		
		$html = array();
		$schema = array();
		$ismainbody = false;
		$mainbodyOptions = array('ALL_LEFT', 'ALL_RIGHT', 'ONE_LEFT', 'ONE_RIGHT');
		$label = $this->getLabel();
		$node = $this->element;
		$blockName = $node->getAttribute('name');
		if ((boolean)$node->getAttribute('rule')){
			$ismainbody = ($node->getAttribute('rule') == 'main');
		}
		
		// get schema options
		if ((boolean)$node->getAttribute('schema')){
			$schema = explode(',', preg_replace('/[^0-9,]/s', '', $this->element["schema"]->__toString()));
		}
		if (!(is_array($schema) && count($schema) > 0)) $schema = array('1','2','3','4','5','6');
		
		$schemaOptions = array();
		foreach ($schema as $sch) {
			if (!empty($sch)) $schemaOptions[] = JHTML::_('select.option', $sch, JText::_($sch));
		}
		
		// get default value for schema options
		$this->value = preg_replace('/[^0-9A-Z,|_]/s', '', $this->value);
		$this->value = str_replace(',,', ',0,', $this->value);
		$defaultVal = explode('|', $this->value);
		$defaultLayout = explode(',', preg_replace('/[^0-9,]/s', '', $defaultVal[0]));
		$defaultUnlock = explode(',', preg_replace('/[^0-9,]/s', '', $defaultVal[1]));
		if ($ismainbody)
		{
			$defaultSidebarLayout = preg_replace('/[^A-Z_]/s', '', $defaultVal[2]);
			if ($defaultSidebarLayout == '') $defaultSidebarLayout = 'ONE_LEFT';
		}
		$countPos = 0;
		$countPos = count($defaultLayout);
		
		for ($i = 0; $i < $countPos -1; $i++){
			if ($defaultLayout[$i] == '' || (int)$defaultLayout[$i] == 0){
				$defaultLayout[$i] = (int)$this->GRID_SIZE - $this->countGrid($defaultLayout);
			}
		}
		
		$fix_value = implode(',', $defaultLayout).'|'.implode(',', $defaultUnlock);
		if ($ismainbody) $fix_value = $fix_value.'|'.$defaultSidebarLayout;
		$this->value = $fix_value;
		
		
		$html[] = '<div class="omgposition" id="'.$this->getFieldName().'">';
		if ($ismainbody)
		{
			
			$sidebarOptions = array();
			foreach ($mainbodyOptions as $sbOption) {
				if (!empty($sbOption)) $sidebarOptions[] = JHTML::_('select.option', $sbOption, JText::_('SIDEBAR_'.$sbOption));
			}
			
			$html[] = 	'<div class="mainbodyLayoutDetails">';
			$html[] = 		'<label>'.JText::_('SELECT_SIDEBAR_LAYOUT').'</label>';
			$html[] = 		JHTML::_('select.genericlist', $sidebarOptions, 'mainbodyLayout', 'class="mainbodyLayoutSel"', 'value', 'text', $defaultSidebarLayout, 'mainbodyLayout');
			$html[] = 		'<div class="clr"></div>';
			$html[] = 		'<div class="sidebarLayoutPreviewWrp rounded-6"><label>'.JText::_('Example: ').'</label>';
			$html[] = 		'<img class="sidebarLayoutPreview ALL_LEFT '.($defaultSidebarLayout == 'ALL_LEFT' ? 'default' : '').'" src="'.JURI::root().'libraries/omg/assets/images/sb_all_left.png" alt="'.JText::_('SIDEBAR_ALL_LEFT').'" />';
			$html[] = 		'<img class="sidebarLayoutPreview ALL_RIGHT '.($defaultSidebarLayout == 'ALL_RIGHT' ? 'default' : '').'" src="'.JURI::root().'libraries/omg/assets/images/sb_all_right.png" alt="'.JText::_('SIDEBAR_ALL_RIGHT').'" />';
			$html[] = 		'<img class="sidebarLayoutPreview ONE_LEFT '.($defaultSidebarLayout == 'ONE_LEFT' ? 'default' : '').'" src="'.JURI::root().'libraries/omg/assets/images/sb_one_left.png" alt="'.JText::_('SIDEBAR_ONE_LEFT').'" />';
			$html[] = 		'<img class="sidebarLayoutPreview ONE_RIGHT '.($defaultSidebarLayout == 'ONE_RIGHT' ? 'default' : '').'" src="'.JURI::root().'libraries/omg/assets/images/sb_one_right.png" alt="'.JText::_('SIDEBAR_ONE_RIGHT').'" />';
			$html[] = 		'</div>';
			$html[] = 		'<div class="clr"></div>
						</div>
						<div class="clr"></div>';
		}
		
		$html[] = 		'<div class="posNum">';
		$html[] = 			'<label>'.JText::_('SELECT_NUMBER_OF_POSITION').'</label>';
		$html[] =			JHTML::_('select.genericlist', $schemaOptions, $this->id.'_PosNum', 'class="posNumberSel"', 'value', 'text', $countPos, $this->id.'_PosNum');
		$html[] =			'<span class="posNumDefault rounded-6">'.$countPos.'</span>';
		$html[] = 			'<input type="hidden" class="posLayout" name="'.$this->name.'" value="'.$this->value.'" id="'.$this->id.'"/>';
		$html[] = 		'</div>';
		$html[] = 		'<div class="clr"></div>';
		
		if ($ismainbody) {
			foreach ($schema as $sch){
				if (!empty($sch)){
					$html[] = 	'<div class="clr"></div>
								<div class="position-block-wrapper '.((int)$sch == $countPos ? 'default' : '').'">
									<div class="position-block pos_'.$sch.'">';
										switch($defaultSidebarLayout){
											case 'ALL_LEFT':
												$cmp = (int)$sch;
											break;
											case 'ALL_RIGHT':
												$cmp = 1;
											break;
											case 'ONE_LEFT':
												$cmp = 2;
											break;
											case 'ONE_RIGHT':
												$cmp = (int)$sch - 1;
											break;
										}
										
										if ((int)$sch == $countPos){
											for ($i = 1; $i <= (int)$sch; $i++){
												$html[] = 		'<div class="resizable '.(($i == $cmp || (int)$sch == 1) ? '' : 'sb').' '.($i == (int)$sch ? 'last' : '').'">
																<input class="posUL" type="checkbox" name="'.$this->id.'posf'.$sch.''.$i.'" value="0" id="'.$this->id.'fc_'.$sch.'_'.$i.'" '.((int)$defaultUnlock[$i-1] == 1 ? 'checked="checked"' : '').'/><label for="'.$this->id.'fc_'.$sch.'_'.$i.'"> </label>
																<span class="pos" >'.$defaultLayout[$i-1].'</span>
															</div>';
											}
										}
										else{
											for ($i = 1; $i <= (int)$sch; $i++){
												$html[] = 		'<div class="resizable '.(($i == $cmp || (int)$sch == 1) ? '' : 'sb').' '.($i == (int)$sch ? 'last' : '').'">
																<input class="posUL" type="checkbox" name="'.$this->id.'posf'.$sch.''.$i.'" value="0" id="'.$this->id.'fc_'.$sch.'_'.$i.'" '.((int)$defaultUnlock[$i-1] == 1 ? 'checked="checked"' : '').'/><label for="'.$this->id.'fc_'.$sch.'_'.$i.'"> </label>
																<span class="pos" >'.$this->gridMaps[$sch][$i-1].'</span>
															</div>';
											}
											
										}
										
					$html[] = 		'</div>
								</div>';
				}
			}
		}
		else {
			foreach ($schema as $sch){
				if (!empty($sch)){
					$html[] = 	'<div class="clr"></div>
								<div class="position-block-wrapper '.((int)$sch == $countPos ? 'default' : '').'">
									<div class="position-block pos_'.$sch.'">';
					if ((int)$sch == $countPos){
						for ($i = 1; $i <= (int)$sch; $i++){
							$html[] = 		'<div class="resizable '.($i%2 == 1 ? 'odd' : 'even').' '.($i == (int)$sch ? 'last' : '').'">
												<input class="posUL" type="checkbox" name="'.$this->id.'posf'.$sch.''.$i.'" value="0" id="'.$this->id.'fc_'.$sch.'_'.$i.'" '.((int)$defaultUnlock[$i-1] == 1 ? 'checked="checked"' : '').'/>
												<label for="'.$this->id.'fc_'.$sch.'_'.$i.'">'.$blockName.'-'.$i.'</label>
												<span class="pos" >'.$defaultLayout[$i-1].'</span>
											</div>';
						}
					}
					else{
						for ($i = 1; $i <= (int)$sch; $i++){
							$html[] = 		'<div class="resizable '.($i%2 == 1 ? 'odd' : 'even').' '.($i == (int)$sch ? 'last' : '').'">
												<input class="posUL" type="checkbox" name="'.$this->id.'posf'.$sch.''.$i.'" value="0" id="'.$this->id.'fc_'.$sch.'_'.$i.'" /><label for="'.$this->id.'fc_'.$sch.'_'.$i.'">'.$blockName.'-'.$i.'</label>
												<span class="pos" >'.$this->gridMaps[$sch][$i-1].'</span>
											</div>';
						}
					}
					$html[] = 		'</div>
								</div>';
				}
			}
		}
		$html[] = 		'</div>';
		
		return implode('', $html);
	}
	
	protected function countGrid($posLayout, $exId = null){
		$count = 0;
		
		foreach($posLayout as $idx => $pL){
			if (!(isset($exId) && $exId == $idx)) $count += (int)$pL;
		}
		return $count;
	}
}
