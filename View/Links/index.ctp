<?php
/**
 * Links index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$this->Token->unlockField('Link.id');
$tokens = $this->Token->getToken('Link', '/links/links/link/' . $frameId . '.json', $tokenFields, $hiddenFields);
?>

<?php echo $this->Html->css('/links/css/style.css', false); ?>
<?php echo $this->Html->script('/links/js/links.js', false); ?>

<div class="frame">
	<div class="nc-content-list" ng-controller="LinksIndex"
		 ng-init="initialize(<?php echo h(json_encode(Hash::merge(['frameId' => $frameId], $tokens))); ?>)">

		<article>
			<div class="clearfix">
				<h1 class="pull-left">
					<small><?php echo h($linkBlock['name']); ?></small>
				</h1>
				<div class="pull-right h1">
					<?php if ($contentEditable) : ?>
						<span class="nc-tooltip " tooltip="<?php echo __d('links', 'Sort link'); ?>">
							<a href="<?php echo $this->Html->url('/links/link_orders/edit/' . $frameId); ?>" class="btn btn-default">
								<span class="glyphicon glyphicon-sort"> </span>
							</a>
						</span>
					<?php endif; ?>
					<?php if ($contentCreatable) : ?>
						<span class="nc-tooltip " tooltip="<?php echo __d('links', 'Create link'); ?>">
							<a href="<?php echo $this->Html->url('/links/links/add/' . $frameId); ?>" class="btn btn-success">
								<span class="glyphicon glyphicon-plus"> </span>
							</a>
						</span>
					<?php endif; ?>
				</div>
			</div>

			<hr>
			<?php if ($linkFrameSetting['displayType'] === LinkFrameSetting::TYPE_DROPDOWN) : ?>
				<?php echo $this->element('Links/index_dropdown'); ?>

			<?php elseif ($linkFrameSetting['displayType'] === LinkFrameSetting::TYPE_LIST_ONLY_TITLE) : ?>
				<?php echo $this->element('Links/index_list_only_title'); ?>

			<?php elseif ($linkFrameSetting['displayType'] === LinkFrameSetting::TYPE_LIST_WITH_DESCRIPTION) : ?>
				<?php echo $this->element('Links/index_list_with_description'); ?>

			<?php endif; ?>
		</article>
	</div>
</div>
