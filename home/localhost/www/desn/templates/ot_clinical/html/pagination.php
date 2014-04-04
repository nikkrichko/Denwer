<?php
/**
*	@version	$Id: pagination.php 58 2013-04-27 08:15:44Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	pagination html overide for template ot_clinical
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

function pagination_list_footer($list)
{
	$html = '<div class="pagination">';
	$html .= $list['pageslinks'];
	$html .= '<input type="hidden" name="' . $list['prefix'] . 'limitstart" value="' . $list['limitstart'] . '" />';
	$html .= '</div>';

	return $html;
}

function pagination_list_render($list)
{
	// Initialize variables
	$lang = JFactory::getLanguage();
	$html = '';
	$html .= '<ul class="pagination-list">';
	// Reverse output rendering for right-to-left display
	if($lang->isRTL())
	{
		$html .= $list['start']['data'];
		$html .= $list['previous']['data'];
		$list['pages'] = array_reverse( $list['pages'] );
		foreach( $list['pages'] as $page ) {
		//if($page['data']['active']) {
		// $html .= '<strong>';
		//}
		$html .= $page['data'];
		//if($page['data']['active']) {
		// $html .= '</strong>';
		//}
		}
		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
	}
	else
	{
		$html .= $list['start']['data'];
		$html .= $list['previous']['data'];
		foreach( $list['pages'] as $page )
		{
		//if($page['data']['active']) {
		// $html .= '<strong>';
		//}
		$html .= $page['data'];
		//if($page['data']['active']) {
		// $html .= '</strong>';
		//}
		}
		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
	}
	$html .= '</ul>';
	return $html;
}
 
function pagination_item_active(&$item) {
	return '<li><a class="link-text" href="'.$item->link.'" title="'.$item->text.'">'.$item->text.'</a></li>';
}
 
function pagination_item_inactive(&$item) {
	return '<li class="disabled"><a>'.$item->text.'</a></li>';
}

?>