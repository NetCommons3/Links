<?php
/**
 * 表示順序変更
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
echo $this->NetCommonsHtml->script('/links/js/links.js');

$camelizeLinks = NetCommonsAppController::camelizeKeyRecursive($links);
$camelizeCategories = NetCommonsAppController::camelizeKeyRecursive($categories);

$editUrlFormat = $this->NetCommonsHtml->url(array('controller' => 'links', 'action' => 'edit', 'key' => '%s'));
?>

<div class="nc-content-list" ng-controller="LinkOrders"
	 ng-init="initialize(<?php echo h(json_encode(['links' => $camelizeLinks, 'categories' => $camelizeCategories])); ?>)">

	<?php echo $this->NetCommonsHtml->blockTitle($linkBlock['name']); ?>

	<?php echo $this->NetCommonsForm->create('LinkOrders', array('type' => 'put')); ?>
		<?php foreach (array_keys($this->data['LinkOrders']) as $linkOrderId) : ?>
			<?php echo $this->NetCommonsForm->hidden('LinkOrders.' . $linkOrderId . '.LinkOrder.id'); ?>
			<?php echo $this->NetCommonsForm->hidden('LinkOrders.' . $linkOrderId . '.LinkOrder.block_key'); ?>
			<?php echo $this->NetCommonsForm->hidden('LinkOrders.' . $linkOrderId . '.LinkOrder.category_key'); ?>
			<?php echo $this->NetCommonsForm->hidden('LinkOrders.' . $linkOrderId . '.LinkOrder.link_key'); ?>
			<?php $this->NetCommonsForm->unlockField('LinkOrders.' . $linkOrderId . '.LinkOrder.weight'); ?>
		<?php endforeach; ?>

		<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
		<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
		<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>

		<div ng-hide="links">
			<p><?php echo __d('links', 'No link found.'); ?></p>
		</div>

		<div ng-show="links" ng-cloak>
			<article ng-repeat="cate in categories" ng-cloak>
				<h2>
					{{cate.categoriesLanguage.name}}
				</h2>

				<ul class="list-group" ng-show="! links['_' + cate.category.id]">
					<li class="list-group-item">
						<?php echo __d('links', 'No link found.'); ?>
					</li>
				</ul>

				<ul class="list-group" ng-show="links['_' + cate.category.id]">
					<li class="list-group-item clearfix" ng-repeat="linksPerCategory in links['_' + cate.category.id]">
						<div class="pull-left">
							<button type="button" class="btn btn-default btn-xs"
									ng-click="move(cate.category.id, 'up', $index)" ng-disabled="$first">
								<span class="glyphicon glyphicon-arrow-up"></span>
							</button>

							<button type="button" class="btn btn-default btn-xs"
									ng-click="move(cate.category.id, 'down', $index)" ng-disabled="$last">
								<span class="glyphicon glyphicon-arrow-down"></span>
							</button>

							<input type="hidden" name="data[LinkOrders][{{linksPerCategory.linkOrder.id}}][LinkOrder][weight]" ng-value="{{$index + 1}}">
						</div>

						<div class="col-xs-9">
							<a ng-href="{{linksPerCategory.link.url}}" target="_blank">
								{{linksPerCategory.link.title}}
							</a>
						</div>

						<div class="pull-right">
							<a class="btn btn-xs btn-primary nc-btn-style"
								ng-href="<?php echo sprintf($editUrlFormat, '{{linksPerCategory.link.key}}'); ?>">

								<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>
								<span class="hidden-xs">
									<?php echo __d('net_commons', 'Edit'); ?>
								</span>
							</a>
						</div>
					</li>
				</ul>
			</article>
		</div>

		<div class="text-center">
			<?php echo $this->Button->cancelAndSave(__d('net_commons', 'Cancel'), __d('net_commons', 'OK')); ?>
		</div>

	<?php echo $this->NetCommonsForm->end(); ?>
</div>
