<?php
/**
*	@version	$Id: shortcodesfuncs.php 54 2013-04-24 03:09:35Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	plg_omgshortcodes plugin for shortcodes
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/
/* plugin use shortcode API of WordPress 
* http://codex.wordpress.org/Shortcode_API
*/

if((int)JVERSION == 3){
	defined('JPATH_PLATFORM') or die;
}else{
	defined('_JEXEC') or die ('Restricted access');
}

if (function_exists('randomkeys') !== true){
	function randomkeys($length) {
		$pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$key = '';
		for($i = 0; $i < $length; $i++)	{
			$key .= $pattern{rand(0,strlen($pattern)-1)};
		}
		return $key;
	}
}

/* pretty format for code snippests in content */
add_shortcode('oprettycode', 'oprettycodeShortcode');
// handler function for oprettycode
function oprettycodeShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"lang"		=> '',
			"linenums" 	=> 'true',
			"startnum" => 1
	), $atts));
    
	$html[] = '<pre class="prettyprint'.(($lang != '') ? ' lang-' . $lang : '')
			. (($linenums == 'true') ? ' linenums' : '')
			. (($startnum && $linenums == 'true') ? ':' . $startnum : '').'">'
			. $content
			. '</pre>';
    
	
	if(!defined('OPRETTYCODE_KICKED')) {
		$html[] = '<script type="text/javascript">jQuery(document).ready(function($) { window.prettyPrint && prettyPrint(); });</script>';
		define('OPRETTYCODE_KICKED', true);
	}
	
	return implode($html);
}

/* bootstrap modal box */
add_shortcode('modal', 'omodalShortcode');
function omodalShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"type" => 'static', // can be static, url, iframe
			"id" => '', // id of modal box
			"class" => '', // link or button class
			"title" => '', // text of button or link
			"header" => '', // header text of modal box
			"href" => '', // if handler is iframe, must have url
			"footer" => 'true' // if true show the footer of modal box
	), $atts));
	
    if (trim($id) == "") $id = randomkeys(8);
	
	$html[] = '<div id="modal-'.$id.'" class="modal hide fade" tabindex="-1" role="dialog">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>'.((trim($header) != '') ? htmlspecialchars(trim($header), ENT_QUOTES, 'UTF-8') : '').'</h3>
				</div>
				<div class="modal-body">
					'.((trim($type) == 'iframe' && trim($href) != '') ? '<iframe width="100%" height="100%" frameborder="0" scrolling="no" allowtransparency="true" src="'.trim($href).'"></iframe>' : do_shortcode($content)).'
				</div>';
	if ($footer == 'true'){
		$html[] =	'<div class="modal-footer">
					<a href="javascript: void(0);" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
					</div>';
	}
	$html[] =	'</div>';
	$html[] = '<a href="'.((trim($type) == 'url' && trim($href) != '') ? trim($href) : '#modal-'.$id).'" data-target="#modal-'.$id.'" role="button" class="'.((trim($class) != '') ? htmlspecialchars(trim($class)) : '').'" data-toggle="modal">'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</a>';
	
	unset($type, $id, $class, $title, $header, $href);
	return implode($html);
}

/* bootstrap tooltip */
add_shortcode('tooltip', 'otooltipShortcode');
function otooltipShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"position" => 'top', // can be top|bottom|left|right
			"mode" => 'text', // text|html. if html will allow title in html mode instead of text
			"title" => '', // title of tooltip / tooltip text 
			"container" => 'false' // Container can be an element, eg: "body"
	), $atts));
	
	$html[] = '<a href="#" data-toggle="tooltip" data-placement="'.$position.'" data-html="'.(($mode == 'text') ? 'false' : 'true').'" data-container="'.$container.'" data-title="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'">'.$content.'</a>';
	if(!defined('OTOOLTIP_KICKED')) {
		$html[] = '<script type="text/javascript">jQuery(document).ready(function($) { $(\'a[data-toggle="tooltip"]\').tooltip(); });</script>';
		define('OTOOLTIP_KICKED', true);
	}
	unset($position, $mode, $title, $container);
	return implode($html);
}

/* bootstrap button */
add_shortcode('button', 'obuttonShortcode');
function obuttonShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"type" => '', // can be primary|info|success|warning|danger|inverse|link
			"size" => 'default', // large|default|small|mini
			"url" => '#',
			"disabled" => 'false', // state disabled, true|false
			"class" => '', // additional class
	), $atts));
	
	$html[] = '<a class="btn'
		.((trim($type) != '') ? ' btn-' . trim($type) : '')
		.((trim($size) != 'default' && trim($size) != '') ? ' btn-'. trim($size) : '')
		.((trim($disabled) == 'true') ? ' disabled' : '')
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.
		'" href="'
		.((trim($url) != '' && trim($url) != '#' && trim($disabled) != 'true') ? trim($url) : 'javascript:void(0)')
		.'" title="">'.do_shortcode($content).'</a>';
	unset($type, $size, $url, $disabled, $class);
	return implode($html);
}

/* bootstrap icon */
add_shortcode('icon', 'oiconShortcode');
function oiconShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"type" => '', // http://twitter.github.io/bootstrap/base-css.html#icons
			"color" => '', // default|white
			"class" => '', // additional class
	), $atts));
	
	$html[] = '<i class="'
		.((trim($type) != '') ? 'icon-' . trim($type) : '')
		.((trim($color) != 'default' && trim($color) != '') ? ' icon-white' : '')
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.
		'"> </i>';
	unset($type, $color, $class);
	return implode($html);
}

/* bootstrap label */
add_shortcode('label', 'olabelShortcode');
function olabelShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"type" => '', // http://twitter.github.io/bootstrap/components.html#labels-badges
			"class" => '', // additional class
	), $atts));
	
	$html[] = '<span class="label'
		.((trim($type) != '') ? ' label-' . trim($type) : '')
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.
		'">'.$content.'</span>';
	unset($type, $class);
	return implode($html);
}

/* bootstrap badge */
add_shortcode('badge', 'obadgeShortcode');
function obadgeShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"type" => '', // http://twitter.github.io/bootstrap/components.html#labels-badges
			"class" => '', // additional class
	), $atts));
	
	$html[] = '<span class="badge'
		.((trim($type) != '') ? ' badge-' . trim($type) : '')
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.
		'">'.$content.'</span>';
	unset($type, $class);
	return implode($html);
}

/* bootstrap message alert */
add_shortcode('message', 'omessageShortcode');
function omessageShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"title" => '', // http://twitter.github.io/bootstrap/components.html#alerts
			"type" => '', // http://twitter.github.io/bootstrap/components.html#alerts
			"block" => 'false', // if block, larger by padding
			"showclose" => 'true', // additional class
			"class" => '', // additional class
	), $atts));
	
	$content = preg_replace("/^(<\/[A-Za-z1-9]>)(.*?<[A-Za-z1-9][^>]*>)/s", "$2", $content);
	$content = preg_replace("/(<\/[A-Za-z1-9]>.*?)(<[A-Za-z1-9][^>]*>$)/s", "$1", $content);
	
	$html[] = '<div class="alert'
		.((trim($type) != '') ? ' alert-' . trim($type) : '')
		.((trim($block) != 'false') ? ' alert-block' : '')
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.
		'">';
		if (trim($showclose) != 'false') $html[] = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		if (trim($title) != '') $html[] = '<h4>'.htmlspecialchars(trim($title), ENT_QUOTES, 'UTF-8').'</h4>';
	$html[] = '<div>'.do_shortcode($content).'</div>';
	$html[] = '</div>';
	unset($title, $type, $block, $showclose, $class);
	return implode($html);
}

/* bootstrap well textbox */
add_shortcode('well', 'owellShortcode');
function owellShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"type" => 'default', // small|default(not specified)|large. http://twitter.github.io/bootstrap/components.html#misc
			"class" => '', // additional class
	), $atts));
	
	$content = preg_replace("/^(<\/[A-Za-z1-9]>)(.*?<[A-Za-z1-9][^>]*>)/s", "$2", $content);
	$content = preg_replace("/(<\/[A-Za-z1-9]>.*?)(<[A-Za-z1-9][^>]*>$)/s", "$1", $content);
	
	$html[] = '<div class="well'
		.((trim($type) != '' || trim($type) != 'default') ? ' well-' . trim($type) : '')
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.
		'">'.do_shortcode($content).'</div>';
	unset($type, $class);
	return implode($html);
}

/* bootstrap grid columns */

add_shortcode('column', 'ocolumnShortcode');
function ocolumnShortcode($atts, $content)
{	
	$html = array();
	
	extract(shortcode_atts(array(
			"width" => '', // span width. http://twitter.github.io/bootstrap/scaffolding.html
			"offset" => '', // offset
			"class" => '' // additional class
	), $atts));
	
	$html[] = '<div class="'
		.((trim($width) != '' && trim($width) != '0') ? 'span' . trim($width) : '')
		.((trim($offset) != '' && trim($offset) != '0') ? ' offset' . trim($offset) : '')
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.
		'">'.do_shortcode($content).'</div>';
	unset($width, $offset, $class);
	
	return implode($html);
}
/* bootstrap grid column */
add_shortcode('columns', 'ocolumnsShortcode');
function ocolumnsShortcode($atts, $content)
{
	if (preg_match_all('/\[column[^\]]*\].*?\[\/column[^\]]*\]/s', $content, $matches)) {
		$stripedContent = implode('', $matches[0]);
	}
	else{
		$stripedContent = $content;
	}
	
	$stripedContent = preg_replace("/(\[column[^\]]*\])(<\/[A-Za-z1-9]>)/s", "$1", $stripedContent);
	$stripedContent = preg_replace("/(<[A-Za-z1-9][^>]*>)(\[\/column\])/s", "$2", $stripedContent);
	
	return '<div class="row-fluid">'.do_shortcode($stripedContent).'</div>';
}


/* bootstrap tab */
add_shortcode('tab', 'otabShortcode');
function otabShortcode($atts, $content)
{	
	global $tabsArr;
	
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));
	
	$tabsArr[] = array("title" => $title , "content" => do_shortcode($content));
	unset($title);
}

/* bootstrap tabs */
$tabsArr = array(); // reset
add_shortcode('tabs', 'otabsShortcode');
function otabsShortcode($atts, $content)
{
	$html = '';
	$count = 0;
	global $tabsArr;
	$add_id = randomkeys(11);
	
	extract(shortcode_atts(array(
			"max_width" => '', // Apx or B%. If no specify, auto full.
			"class" => '' // additional class
	), $atts));
	
	if (preg_match_all('/\[tab[^\]]*\].*?\[\/tab[^\]]*\]/s', $content, $matches)) {
		$stripedContent = implode('', $matches[0]);
		$count = count($matches[0]);
	}
	else{
		$stripedContent = $content;
	}
	
	do_shortcode($stripedContent);
	
	if ($count < 1 || $count < count($tabsArr)) $count = count($tabsArr);
	
	$html .= '
		<div id="tabs-'.$add_id.'" class="'
			.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			.'"
			style="'
			.((trim($max_width) != '' && intval($max_width) != 0) ? ' max-width:'. trim($max_width) . ';' : '')
			.'">
			<ul class="nav nav-tabs">';
	for($i = 0; $i < $count; $i++){
		$html .= '<li'.(($i == 0) ? ' class="active"' : '').'><a data-toggle="tab" href="#tabs-'.$add_id.'-'.$i.'">'.$tabsArr[$i]['title'].'</a></li>';
	}
	$html .= '
			</ul>
			<div class="tab-content">';
	for($i = 0; $i < $count; $i++){
		$html .= '<div class="tab-pane'
		.($i == 0 ? ' active' : '')
		.'" id="tabs-'.$add_id.'-'.$i.'">' . $tabsArr[$i]['content'] . '</div>';
	}
	$html .= '
			</div>
		</div>
	';
	unset($max_width, $class);
	return $html;
}


/* Dropcap first char of paragraph */
add_shortcode('dropcap', 'odropcapShortcode');
function odropcapShortcode($atts, $content)
{
	extract(shortcode_atts(array(
			"color" => '#000000',
			"background" => '',
			"type" => 'default', // type of background: circle, square, none.
			"class" => '' // additional class
	), $atts));
	
	$color = str_replace(array('#', ' '), '', $color);
	$background = str_replace(array('#', ' '), '', $background);
	
	return '<span class="dropcap'
			.((trim($type) != '' && trim($type) != 'default') ? ' ' . trim($type) : '')
			.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			.'" style="'
			.(($color != '') ? ' color:#' . $color . ';' : '')
			.(($background != '' || $background != 'transparent') ? ' background-color:#' . $background . ';' : 'transparent;')
			.'">'.$content.'</span>';
}

/* Bootstrap carousel */
add_shortcode('carousel', 'ocarouselShortcode');
function ocarouselShortcode($atts, $content)
{
	$html = '';
	$count = 0;
	
	extract(shortcode_atts(array(
			"max_width" => '', // Apx or B%. If no specify, auto full.
			"class" => '' // additional class
	), $atts));
	
	if (preg_match_all('/\[carousel_item[^\]]*\].*?\[\/carousel_item[^\]]*\]/s', $content, $matches)) {
		$stripedContent = implode('', $matches[0]);
		$count = count($matches[0]);
	}
	else{
		$stripedContent = $content;
	}
	
	$add_id = randomkeys(10);
	$html .= '
		<div id="carousel-'.$add_id.'" class="carousel slide'
			.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			.'"
			style="'
			.((trim($max_width) != '' && intval($max_width) != 0) ? ' max-width:'. trim($max_width) . ';' : '')
			.'">
			<ol class="carousel-indicators">';
	for($i = 0; $i < $count; $i++){
		$html .= '<li data-target="#carousel-'.$add_id.'" data-slide-to="'.$i.'" '.(($i == 0) ? 'class="active"' : '').'></li>';
	}
	$html .= '
			</ol>
			<div class="carousel-inner">
				'.do_shortcode($stripedContent).'
			</div>
			<a class="carousel-control left" href="#carousel-'.$add_id.'" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#carousel-'.$add_id.'" data-slide="next">&rsaquo;</a>
		</div>
	';
	unset($max_width, $class);
	return $html;
}

add_shortcode('carousel_item', 'ocarouselitemShortcode');
function ocarouselitemShortcode($atts, $content)
{
	extract(shortcode_atts(array(
		'title' => '',
		'image' => '',
		"class" => '' // additional class
	), $atts));
	
	return '
		<div class="item'
		.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
		.'">
		<img src="'.$image.'" alt="'.$title.'" />
			<div class="carousel-caption">
				<h4>'.$title.'</h4>
				<p>'.do_shortcode(strip_tags($content)).'</p>
			</div>
		</div>
	';
}

/* Spacer */
add_shortcode('spacer', 'spacerShortcode');
function spacerShortcode($atts)
{
	extract(shortcode_atts(array(
		"height" => '20px'
	), $atts));	
	return '<div style="clear:both; height:' . $height . ';"></div>';
}

/* Vimeo video */
add_shortcode('vimeo', 'vimeoShortcode');
function vimeoShortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"width" => '',
		"height" => '',
		"video_id" => ''
	), $atts));	
	
	preg_match('/vimeo.com\/(\d+)$/', $content, $match);
	$vid = (trim($video_id) != '') ? trim($video_id) : $match[1];
	return '<div class="vimeo-sc" style="'
		.((trim($width) != '' && intval($width) != 0) ? ' max-width:'. trim($width) . ';' : '')
	.'">
		<iframe src="http://player.vimeo.com/video/'.$vid.'" width="'.intval($width).'" height="'.intval($height).'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	</div>';
}

/* youtube video */
add_shortcode('youtube', 'youtubeShortcode');
function youtubeShortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"width" => '',
		"height" => '',
		"video_id" => ''
	), $atts));	
	$prvID = '';
	
	if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $content, $match)){
		$prvID = $match[1];
	}
	else if (preg_match('/youtu.be\/([^\\?\\&]+)/', $content, $match)){
		$prvID = $match[1];
	}
	
	$vid = (trim($video_id) != '') ? trim($video_id) : $prvID;
	
	return '<div class="youtube-sc" style="'
		.((trim($width) != '' && intval($width) != 0) ? ' max-width:'. trim($width) . ';' : '')
	.'">
		<iframe src="http://www.youtube.com/embed/'.$vid.'" width="'.intval($width).'" height="'.intval($height).'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	</div>';
}

?>