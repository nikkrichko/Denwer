<?php
/**
*	@version	$Id$
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
 *	Load jscolor
 * @since	2.0 (change from color to ocolor to be different from Joomla core field )
 *
 */
class JFormFieldPositionsLayout extends JFormField
{
	// Name of Element
	protected $type = 'PositionsLayout';
	
	const DEFAULT_GRID_SIZE = 12;
	
	// all cases of grid width 
	protected $gridSysWidthMaps = array(
		'6' => array(
			'2,2,2,2,2,2'
		),
		'5' => array(
			'4,2,2,2,2', 
			'3,3,2,2,2', '3,2,3,2,2', '3,2,2,3,2', '3,2,2,2,3', 
			'2,4,2,2,2', '2,3,3,2,2', '2,3,2,3,2', '2,3,2,2,3', '2,2,4,2,2', '2,2,3,3,2', '2,2,3,2,3', '2,2,2,4,2', '2,2,2,3,3', '2,2,2,2,4' 
		),
		'4' => array(
			'6,2,2,2',
			'5,3,2,2', '5,2,3,2', '5,2,2,3',
			'4,4,2,2', '4,3,3,2', '4,3,2,3', '4,2,4,2', '4,2,2,4', '4,2,3,3',
			'3,5,2,2', '3,4,3,2', '3,4,2,3', '3,3,4,2', '3,3,3,3', '3,3,2,4', '3,2,5,2','3,2,4,3', '3,2,3,4', '3,2,2,5',
			'2,6,2,2', '2,5,3,2', '2,5,2,3', '2,4,4,2', '2,4,3,3', '2,4,2,4', '2,3,5,2', '2,3,4,3', '2,3,3,4', '2,3,2,5', '2,2,6,2', '2,2,5,3', '2,2,4,4', '2,2,3,5', '2,2,2,6'
		),
		'3' => array(
			'8,2,2',
			'7,3,2', '7,2,3',
			'6,4,2', '6,3,3', '6,2,4',
			'5,5,2', '5,4,3', '5,3,4', '5,2,5',
			'4,6,2', '4,5,3', '4,4,4', '4,3,5', '4,2,6',
			'3,7,2', '3,6,3', '3,5,4', '3,4,5', '3,3,6', '3,2,7',
			'2,8,2', '2,7,3', '2,6,4', '2,5,5', '2,4,6', '2,3,7', '2,2,8'
		),
		'2' => array(
			'10,2', '9,3', '8,4', '7,5', '6,6', '5,7', '4,8', '3,9', '2,10'
		),
		'1' => array(
			'12'
		)
	);
	
	// default value for fallback 
	protected $defaultGridMaps = array(
		'6' => array('width' => '2,2,2,2,2,2', 'phone' => '1,1,1,1,1,1', 'tablet' => '1,1,1,1,1,1', 'desktop' => '1,1,1,1,1,1'),
		'5' => array('width' => '4,2,2,2,2', 'phone' => '1,1,1,1,1', 'tablet' => '1,1,1,1,1', 'desktop' => '1,1,1,1,1'),
		'4' => array('width' => '6,2,2,2', 'phone' => '1,1,1,1', 'tablet' => '1,1,1,1', 'desktop' => '1,1,1,1'),
		'3' => array('width' => '8,2,2', 'phone' => '1,1,1', 'tablet' => '1,1,1', 'desktop' => '1,1,1'),
		'2' => array('width' => '10,2', 'phone' => '1,1', 'tablet' => '1,1', 'desktop' => '1,1'),
		'1' => array('width' => '12', 'phone' => '1', 'tablet' => '1', 'desktop' => '1')
	);
	
	// Function to create an element
	protected function getInput()
	{
		$html = array();
		$session = JFactory::getSession();
		$safeMode = $session->get('safemode') ? (bool)$session->get('safemode') : false;
		$node = $this->element;
		$blockName = $node->getAttribute('name');
		
		$savedValue = array();
		
		if (!is_array($this->value)){
			$defaultValue = preg_replace('/[^0-9,|:;]/s', '', $this->value);
			$layoutArray = explode(';', $defaultValue);
			foreach ($layoutArray as $layout){
				$layoutNum = explode(':', $layout);
				$deviceLayout = explode('|', $layoutNum[1]);
				$posN = $layoutNum[0];
				$savedValue[$posN] = array('width' => $deviceLayout[0], 'phone' => $deviceLayout[1], 'tablet' => $deviceLayout[2], 'desktop' => $deviceLayout[3]);
			}
		}
		else {
			$savedValue = $this->value;
		}
		
		$html[] = '<div class="fltlft">';
		
		$html[] = '<div class="omgposition" id="'.$blockName.'">';
		
		$showDeviceIcon = true;
		foreach ($savedValue as $count => $layout)
		{
			if (!isset($layout['width']) || empty($layout['width'])) $layout['width'] = $this->defaultGridMaps[$count]['width'];
			
			$theWidth = explode(',', $layout['width']);
			
			$html[] = '<div class="clr"></div>';
			$html[] = '<div class="posNumCase case-'.$count.'">';
			$html[] = '<div class="layout-width layout-width-'.$count.'">';
			$html[] = $showDeviceIcon ? '<span class="icon-32 icon-width">&nbsp;</span>' : '';
			$html[] = '<span class="posNum rounded-6">'.$count.'</span>';
			if ($safeMode){
				$html[] = '<input type="text" name="' . $this->name . '['.$count.'][width]" value="'.htmlspecialchars($layout['width'], ENT_COMPAT, 'UTF-8').'" id="' . $this->id . $count .'_width" class="clear-view" />';
			}
			else{
				$html[] = '<span class="posSpinnerBtn">';
				$html[] = '<a class="posSpinnerUp ui-corner-tl ui-button ui-widget ui-state-default" tabindex="-1" role="button" aria-disabled="false">
								<span class="ui-icon ui-icon-triangle-1-n">▲</span>
							</a>
							<a class="posSpinnerDown ui-corner-bl ui-button ui-widget ui-state-default" tabindex="-1" role="button" aria-disabled="false">
								<span class="ui-icon ui-icon-triangle-1-s">▼</span>
							</a>';
				$html[] = '</span>';
				$html[] = JHTML::_('select.genericlist', $this->getLayoutOptions($count, true), $this->name . '['.$count.'][width]', array('class'=>'pos-width-select clear-view'), 'value', 'text', htmlspecialchars($layout['width'], ENT_COMPAT, 'UTF-8'), $this->id . $count .'_width');
			}
			$html[] = '</div>';
			
			$html[] = '<div class="position-view phone-view phone-view-'.$count.'">';
			$html[] = $showDeviceIcon ? '<span class="icon-32 icon-phone hasTip" title="'
				. htmlspecialchars(	trim(JText::_('VISIBLE_PHONE_SETTING'), ':') . '::' . JText::_('VISIBLE_PHONE_SETTING_DESC'), ENT_COMPAT, 'UTF-8' ) . '">&nbsp;<span class="ui-icon ui-icon-help"></span></span>' : '';
			if ($safeMode){
				
				$html[] = '<input type="text" name="' . $this->name . '['.$count.'][phone]" value="'.$layout['phone'].'" id="' . $this->id . $count .'_phone" class="clear-view" />';
			}
			else{
				$phone = @explode(',', $layout['phone']);
				$html[] = '<input type="hidden" name="' . $this->name . '['.$count.'][phone]" value="'.$layout['phone'].'" id="' . $this->id . $count .'_phone" class="position-view-value" />';
				$html[] = 		'<div class="checkboxes position-block">';
								for($i = 0; $i < $count; $i++){
									$html[] = '
										<div class="posW '.($i%2 == 1 ? 'odd' : 'even').' '.($i == (int)$count-1 ? 'last' : '').' span'.$theWidth[$i].'">
										<input type="checkbox"  id="' . $this->id . $count .'_phone_'.$i.'"' . ' '.(@intval($phone[$i]) == 1 ? 'checked="checked"' : '').' />
										<label for="' . $this->id . $count .'_phone_'.$i.'"' . '">'.($blockName != 'sidebar' ? $blockName.'-'.($i+1) : '').'</label>
										</div>
										';
								}
								unset($i);
				$html[] = 		'</div>';
			}
			
			$html[] = '</div>';
			
			$html[] = '<div class="position-view tablet-view tablet-view-'.$count.'">';
			$html[] = $showDeviceIcon ? '<span class="icon-32 icon-tablet hasTip" title="'
				. htmlspecialchars(	trim(JText::_('VISIBLE_TABLET_SETTING'), ':') . '::' . JText::_('VISIBLE_TABLET_SETTING_DESC'), ENT_COMPAT, 'UTF-8'	) . '">&nbsp;<span class="ui-icon ui-icon-help"></span></span>' : '';
			if ($safeMode){
				
				$html[] = '<input type="text" name="' . $this->name . '['.$count.'][tablet]" value="'.$layout['tablet'].'" id="' . $this->id . $count .'_tablet" class="clear-view" />';
			}
			else{
				$tablet = @explode(',', $layout['tablet']);
				$html[] = '<input type="hidden" name="' . $this->name . '['.$count.'][tablet]" value="'.$layout['tablet'].'" id="' . $this->id . $count .'_tablet" class="position-view-value" />';
				$html[] = 		'<div class="checkboxes position-block">';
								for($i = 0; $i < $count; $i++){
									$html[] = '
										<div class="posW '.($i%2 == 1 ? 'odd' : 'even').' '.($i == (int)$count-1 ? 'last' : '').' span'.$theWidth[$i].'">
										<input type="checkbox" value="1" id="' . $this->id . $count .'_tablet_'.$i.'"' . ' '.(@intval($tablet[$i]) == 1 ? 'checked="checked"' : '').' />
										<label for="' . $this->id . $count .'_tablet_'.$i.'"' . '">'.($blockName != 'sidebar' ? $blockName.'-'.($i+1) : '').'</label>
										</div>
										';
								}
								unset($i);
				$html[] = 		'</div>';
			}
			$html[] = '</div>';
			
			$html[] = '<div class="position-view desktop-view desktop-view-'.$count.'">';
			$html[] = $showDeviceIcon ? '<span class="icon-32 icon-desktop hasTip" title="'
				. htmlspecialchars( trim(JText::_('VISIBLE_DESKTOP_SETTING'), ':') . '::' . JText::_('VISIBLE_DESKTOP_SETTING_DESC'), ENT_COMPAT, 'UTF-8' ) . '">&nbsp;<span class="ui-icon ui-icon-help"></span></span>' : '';
			if ($safeMode){
				
				$html[] = '<input type="text" name="' . $this->name . '['.$count.'][desktop]" value="'.$layout['desktop'].'" id="' . $this->id . $count .'_desktop" class="clear-view" />';
			}
			else{
				$desktop = @explode(',', $layout['desktop']);
				$html[] = '<input type="hidden" name="' . $this->name . '['.$count.'][desktop]" value="'.$layout['desktop'].'" id="' . $this->id . $count .'_desktop" class="position-view-value" />';
				$html[] = 		'<div class="checkboxes position-block">';
								
								for($i = 0; $i < $count; $i++){
									$html[] = '
										<div class="posW '.($i%2 == 1 ? 'odd' : 'even').' '.($i == (int)$count-1 ? 'last' : '').' span'.$theWidth[$i].'">
										<input type="checkbox" value="1" id="' . $this->id . $count .'_desktop_'.$i.'"' . ' '.(@intval($desktop[$i]) == 1 ? 'checked="checked"' : '').' />
										<label for="' . $this->id . $count .'_desktop_'.$i.'"' . '">'.($blockName != 'sidebar' ? $blockName.'-'.($i+1) : '').'</label>
										</div>
										';
								}
								unset($i);
				$html[] = 		'</div>';
			}
			$html[] = '</div>';
			$html[] = '</div>';
			$showDeviceIcon = false;
			unset($layout);
		}
		unset($count, $layout);
		
		$html[] = '</div>';
		$html[] = '</div>';
		
		return implode($html);
	}
	
	/*
	*	Todo: desc
	*/
	protected function getLayoutOptions($countPos = 6, $keyEval = false){
		$options = array();
		foreach($this->gridSysWidthMaps[$countPos] as $idx => $layout){
			$options[] = JHTML::_('select.option', $keyEval ? $layout : $idx, $layout);
		}
		return $options;
	}
	
}