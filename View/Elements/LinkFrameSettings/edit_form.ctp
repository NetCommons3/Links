<?php
/**
 * 表示方法変更用編集フォームElement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$LinkFrameSetting = ClassRegistry::init('Links.LinkFrameSetting');
?>

<?php echo $this->NetCommonsForm->hidden('LinkFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkFrameSetting.frame_key'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.key'); ?>

<?php
	$displayTypeDomId = $this->NetCommonsForm->domId('LinkFrameSetting.display_type');
?>
<div ng-init="<?php echo $displayTypeDomId . '=' . Hash::get($this->data, 'LinkFrameSetting.display_type'); ?>">
	<div class="form-group row link-frame-setting-display-type">
		<div class="col-xs-12">
			<?php echo $this->NetCommonsForm->input('LinkFrameSetting.display_type', array(
					'label' => __d('links', 'Display method'),
					'type' => 'radio',
					'div' => false,
					'options' => array(
						$LinkFrameSetting::TYPE_DROPDOWN => __d('links', 'Show by dropdown'),
						$LinkFrameSetting::TYPE_LIST_ONLY_TITLE => __d('links', 'Show list'),
						//$LinkFrameSetting::TYPE_LIST_WITH_DESCRIPTION => __d('links', 'Show list (Description)'),
					),
					'ng-model' => $displayTypeDomId
				)); ?>
		</div>

		<div class="col-xs-offset-1 col-xs-11 form-inline">
			<?php echo $this->NetCommonsForm->checkbox('LinkFrameSetting.has_description', array(
					'label' => __d('links', 'Show description'),
					'type' => 'checkbox',
					'ng-disabled' => $displayTypeDomId . ' == ' . $LinkFrameSetting::TYPE_DROPDOWN
				)); ?>
		</div>
	</div>

	<div class='form-group row'>
		<div class="col-xs-offset-1 col-xs-11 form-inline">
			<?php echo $this->NetCommonsForm->label('LinkFrameSetting.category_separator_line',
					__d('links', 'Line')
				); ?>
			<?php echo $this->NetCommonsForm->hidden('LinkFrameSetting.category_separator_line', array(
					'ng-value' => 'linkFrameSetting.categorySeparatorLine'
				)); ?>
			<?php $this->NetCommonsForm->unlockField('LinkFrameSetting.category_separator_line'); ?>

			<div class="btn-group nc-input-dropdown">
				<button type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false"
							ng-disabled="<?php echo $displayTypeDomId . ' == ' . $LinkFrameSetting::TYPE_DROPDOWN; ?>">
					<div class="clearfix">
						<div class="pull-left">
							<span ng-if="currentCategorySeparatorLine.name">
								{{currentCategorySeparatorLine.name}}
							</span>
							<hr class="nc-links-edit-line" ng-if="(currentCategorySeparatorLine.style !== null)"
								style="{{currentCategorySeparatorLine.style}}" ng-cloak>
						</div>
						<div class="pull-right">
							<span class="caret"> </span>
						</div>
					</div>
				</button>

				<ul class="dropdown-menu text-left" role="menu"
					ng-init="categorySeparatorLines = <?php echo h(json_encode($LinkFrameSetting->categorySeparators)); ?>">

					<li ng-repeat="line in categorySeparatorLines track by $index" ng-class="{active: (line.key===currentCategorySeparatorLine.key)}">
						<a class="text-left" href="" ng-click="selectCategorySeparatorLine(line)">
							<span ng-if="line.name">
								{{line.name}}
							</span>
							<hr class="nc-links-edit-line" ng-if="(line.style !== null)" style="{{line.style}}">
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class='form-group row'>
		<div class="col-xs-offset-1 col-xs-11 form-inline">
			<?php echo $this->NetCommonsForm->label('LinkFrameSetting.list_style',
					__d('links', 'Marker')
				); ?>
			<?php echo $this->NetCommonsForm->hidden('LinkFrameSetting.list_style', array(
					'ng-value' => 'linkFrameSetting.listStyle'
				)); ?>
			<?php $this->NetCommonsForm->unlockField('LinkFrameSetting.list_style'); ?>

			<div class="btn-group nc-input-dropdown">
				<button type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false"
							ng-disabled="<?php echo $displayTypeDomId . ' == ' . $LinkFrameSetting::TYPE_DROPDOWN; ?>">
					<div class="clearfix">
						<div class="pull-left">
							<span ng-if="currentListStyle.name">
								{{currentListStyle.name}}
							</span>
							<ul ng-if="currentListStyle.style" class="nc-links-edit-mark">
								<li style="{{currentListStyle.style}}" ng-cloak>
									<?php echo __d('links', 'Sample'); ?>
								</li>
							</ul>
						</div>
						<div class="pull-right">
							<span class="caret"> </span>
						</div>
					</div>
				</button>

				<ul class="dropdown-menu" role="menu"
					ng-init="listStyles = <?php echo h(json_encode($LinkFrameSetting->listStyles)); ?>">

					<li ng-repeat="mark in listStyles track by $index" ng-class="{active: (mark.key===currentListStyle.key)}" ng-cloak>
						<a href="" ng-click="selectListStyle(mark)">
							<span ng-if="mark.name">
								{{mark.name}}
							</span>
							<ul ng-if="mark.style" class="nc-links-edit-mark">
								<li style="{{mark.style}}" ng-cloak>
									<?php echo __d('links', 'Sample'); ?>
								</li>
							</ul>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<?php echo $this->NetCommonsForm->inlineCheckbox('LinkFrameSetting.open_new_tab', array(
			'label' => __d('links', 'Open as a new tab'),
			'type' => 'checkbox',
		)); ?>

	<?php echo $this->NetCommonsForm->inlineCheckbox('LinkFrameSetting.display_click_count', array(
			'label' => __d('links', 'Count view'),
			'type' => 'checkbox',
		)); ?>
</div>
