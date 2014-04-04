<?php
/**
 * @package 	OT Scroller module for Joomla! 2.5
 * @version 	$Id: default.php - May 2013 00:00:00Z OmegaTheme
 * @author 		OmegaTheme Extensions (services@omegatheme.com) - http://omegatheme.com
 * @copyright 	Copyright(C) 2013 - OmegaTheme Extensions
 * @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
**/
// no direct access
defined('_JEXEC') or die; ?>
<?php
	$i = 0;
	$col = 1;
	$class = 'span' . floor (OGRID_SYS / $imgperframe);
?>

<div id="myCarousel-<?php echo $module->id; ?>" class="carousel slide">
	<div class="carousel-inner">
		<div class="item active" >
			<?php foreach($images as $image) : 
				$i++;?>
				<div class="<?php echo $class; ?>">
					<?php 
						$image->folder	= str_replace( '\\', '/', $image->folder );
						//$img = JHTML::_('image', $image->folder.'/'.$image->name, $image->name, array('width' => $image->width, 'height' => $image->height));
						// $img = JHTML::_('image', $image->folder.'/'.$image->name, $image->name);
						// echo $img;
					?>
					<img src="<?php echo $image->folder.'/'.$image->name; ?>" alt="<?php echo $image->name; ?>" style="width: 100%;" />
				</div>
				<?php if ($col == $imgperframe && $imgperframe && $i < count($images)) {
					echo '</div><div class="item">';
					$col = 1;
				} else {
					$col++;
				}?>
			<?php endforeach;?>
		</div>
	</div>
	<!-- "previous page" action -->
	<a class="carousel-control left" href="#myCarousel-<?php echo $module->id; ?>" data-slide="prev"></a>
	<!-- "next page" action -->
	<a class="carousel-control right" href="#myCarousel-<?php echo $module->id; ?>" data-slide="next"></a>
</div>

<script type="text/javascript">
<!--
	jQuery.noConflict();
	jQuery(document).ready(function($) {
		$('#myCarousel-<?php echo $module->id; ?>').carousel();
	});
-->
</script>
