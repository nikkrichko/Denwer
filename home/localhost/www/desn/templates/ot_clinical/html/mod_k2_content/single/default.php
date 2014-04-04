<?php
/**
 * @version		$Id: default.php 1499 2012-02-28 10:28:38Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$slide = '';
$inner = '';
if (strpos( $params->get ('moduleclass_sfx'), 'slide')!==false){
	$slide = ' carousel slide';
	$inner = ' carousel-inner';
}
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock<?php echo $slide; ?>">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
	<div class="ot-items<?php echo $module->id; ?> ot-single<?php echo $inner; ?>" >
		<?php foreach ($items as $key=>$item):	?>
			<div class="item<?php echo strpos( $params->get ('moduleclass_sfx'), 'slide')!==false?$key==0?' active':'':''?>">
				<?php if($params->get('itemImage') && isset($item->image)): ?>
					<div class="moduleItemImage">
						<a href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
							<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width: 100%;" />
						</a>
					</div>
				<?php endif; ?>
				<?php if($params->get('itemTitle') || $params->get('itemIntroText')): ?>
					<div class="moduleItemOverlay">
						<?php if($params->get('itemTitle')): ?>
							<h3><a class="moduleItemTitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
						<?php endif; ?>
						<?php if($params->get('itemAuthor')): ?>
							<span class="moduleItemAuthor moduleItemAddition">
								<?php echo K2HelperUtilities::writtenBy($item->authorGender); ?>
								<?php if(isset($item->authorLink)): ?>
									<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo $item->author; ?></a>
								<?php else: ?>
									<?php echo $item->author; ?>
								<?php endif; ?>
							</span>
						<?php endif; ?>
						<?php if($params->get('itemDateCreated')): ?>
							<span class="moduleItemDateCreated moduleItemAddition"><?php echo JText::_('K2_WRITTEN_ON') ; ?> <?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?></span>
						<?php endif; ?>
						<?php if($params->get('itemCategory')): ?>
							<span class="moduleItemCategory moduleItemAddition"><?php echo JText::_('K2_IN') ; ?> <a href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a></span>
						<?php endif; ?>
						<?php if($params->get('itemIntroText')): ?>
							<div class="moduleItemIntrotext">
								<?php echo $item->introtext; ?>
							</div>
						<?php endif; ?>
						<?php if($params->get('itemTags') && count($item->tags)>0): ?>
							<div class="moduleItemTags moduleItemAddition">
								<b><?php echo JText::_('K2_TAGS'); ?>:</b>
								<?php foreach ($item->tags as $tag): ?>
									<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php if($params->get('itemAttachments') && count($item->attachments)): ?>
							<div class="moduleItemAttachments moduleItemAddition">
								<?php foreach ($item->attachments as $attachment): ?>
									<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>		
							<?php if(!empty($item->event->K2CommentsCounter)): ?>
								<?php echo $item->event->K2CommentsCounter; ?>
							<?php else: ?>
								<?php if($item->numOfComments>0): ?>
									<a class="moduleItemComments moduleItemAddition" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
										<?php echo $item->numOfComments; ?> <?php if($item->numOfComments>1) echo JText::_('K2_COMMENTS'); else echo JText::_('K2_COMMENT'); ?>
									</a>
								<?php else: ?>
									<a class="moduleItemComments moduleItemAddition" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
										<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
									</a>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
						<?php if($params->get('itemHits')): ?>
							<span class="moduleItemHits moduleItemAddition">
								<?php echo JText::_('K2_READ'); ?> <?php echo $item->hits; ?> <?php echo JText::_('K2_TIMES'); ?>
							</span>
						<?php endif; ?>
						<?php if($params->get('itemReadMore') && $item->fulltext): ?>
							<br />
							<a class="moduleItemReadMore" href="<?php echo $item->link; ?>">
								<?php echo JText::_('K2_READ_MORE'); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if (strpos( $params->get ('moduleclass_sfx'), 'slide')!==false){?>
		<!-- "previous page" action -->
		<a class="carousel-control control-large control-square control-light left" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="prev"><span class="icon-prev-bold"></span></a>
		<!-- "next page" action -->
		<a class="carousel-control control-large control-square control-light right" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="next"><span class="icon-next-bold"></span></a>
		<ol class="carousel-indicators">
			<?php foreach ($items as $key=>$item):	?>
			<li data-target="#k2ModuleBox<?php echo $module->id; ?>" data-slide-to="<?php echo $key; ?>"<?php echo $key==0?' class="active"':''?>></li>
			<?php endforeach; ?>
		</ol>
	<?php } ?>
  <?php endif; ?>

	<?php if($params->get('itemCustomLink')): ?>
	<a class="moduleCustomLink" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
	<div class="k2FeedIcon">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>
<?php if (strpos( $params->get ('moduleclass_sfx'), 'slide')!==false){?>
<script type="text/javascript">
<!--
	jQuery.noConflict();
	jQuery(document).ready(function($) {
		$('#k2ModuleBox<?php echo $module->id; ?>').carousel();
	});
-->
</script>
<?php } ?>
</div>
