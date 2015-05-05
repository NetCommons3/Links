<?php
/**
 * LinkOrders edit
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/links/js/links.js'); ?>

<div class="frame">
	<div class="nc-content-list" ng-controller="LinkOrders"
		 ng-init="initialize(<?php echo h(json_encode(['links' => $links, 'categories' => $categories])); ?>)">

		<h1>
			<small><?php echo h($linkBlock['name']); ?></small>
		</h1>

		<?php echo $this->Form->create('LinkOrder', array('novalidate' => true)); ?>
			<?php $this->Form->unlockField('LinkOrders'); ?>

			<?php echo $this->Form->hidden('Block.id', array(
					'value' => $blockId,
				)); ?>

			<?php echo $this->Form->hidden('Block.key', array(
					'value' => $blockKey,
				)); ?>

			<div ng-hide="links">
				<p><?php echo __d('links', 'No link.'); ?></p>
			</div>

			<div ng-show="links">
				<article ng-repeat="cate in categories">
					<h2>
						{{cate.category.name}}
					</h2>
					<ul class="list-group" ng-show="links[cate.category.id]">
						<li class="list-group-item" ng-repeat="linksPerCategory in links[cate.category.id]">
							<div class="row">
								<div class="col-xs-2">
									<button type="button" class="btn btn-default btn-sm"
											ng-click="move(cate.category.id, 'up', $index)" ng-disabled="$first">
										<span class="glyphicon glyphicon-arrow-up"></span>
									</button>

									<button type="button" class="btn btn-default btn-sm"
											ng-click="move(cate.category.id, 'down', $index)" ng-disabled="$last">
										<span class="glyphicon glyphicon-arrow-down"></span>
									</button>

									<input type="hidden" name="data[LinkOrders][{{linksPerCategory.linkOrder.id}}][LinkOrder][id]" ng-value="linksPerCategory.linkOrder.id">
									<input type="hidden" name="data[LinkOrders][{{linksPerCategory.linkOrder.id}}][LinkOrder][block_key]" ng-value="linksPerCategory.linkOrder.blockKey">
									<input type="hidden" name="data[LinkOrders][{{linksPerCategory.linkOrder.id}}][LinkOrder][category_key]" ng-value="linksPerCategory.linkOrder.categoryKey">
									<input type="hidden" name="data[LinkOrders][{{linksPerCategory.linkOrder.id}}][LinkOrder][link_key]" ng-value="linksPerCategory.linkOrder.linkKey">
									<input type="hidden" name="data[LinkOrders][{{linksPerCategory.linkOrder.id}}][LinkOrder][weight]" ng-value="{{$index + 1}}">
								</div>

								<div class="col-xs-9">
									<a ng-href="{{linksPerCategory.link.url}}" target="_blank">
										{{linksPerCategory.link.title}}
									</a>
								</div>

								<div class="col-xs-1 text-right">
									<a class="btn btn-xs btn-primary nc-links-edit-anchor" ng-href="/links/links/edit/<?php echo $frameId; ?>/{{linksPerCategory.link.key}}">
										<span class="glyphicon glyphicon-edit"> </span>
									</a>
								</div>
							</div>
						</li>
					</ul>
				</article>
			</div>

			<div class="text-center">
				<button type="button" class="btn btn-default btn-workflow" onclick="location.href = '/<?php echo $cancelUrl; ?>'">
					<span class="glyphicon glyphicon-remove"></span>
					<?php echo __d('net_commons', 'Cancel'); ?>
				</button>

				<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
						'class' => 'btn btn-primary btn-workflow',
						'name' => 'save',
					)); ?>
			</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>
