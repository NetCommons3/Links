<?php
/**
 * index/status_label template elements
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author SkeletonAuthorName <SkeletonAuthorEMail>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 * @package app.Plugin.Notepads.View.Elements.index
 */
?>
<div class="text-right" ng-show="displayHeaderBtn">
	<?php if ($blockEditable) : ?>
		<button class="btn btn-default ng-disabled"
				ng-click="showBlockSetting()" ng-disabled="sendLock">
			<span class="glyphicon glyphicon-cog">
				<?php echo __d('notepads', 'Block setting'); ?>
			</span>
		</button>
	<?php endif; ?>

	<?php if ($contentEditable) : ?>
		<button class="btn btn-primary"
				ng-click="showAddForm()" ng-disabled="sendLock">
			<span class="glyphicon glyphicon-pencil">
				<?php echo __d('links', 'Add'); ?>
			</span>
		</button>
	<?php endif; ?>

	<?php if ($contentPublishable) : ?>
		<button class="btn btn-danger ng-hide"
				ng-show="Label.approval" ng-click="post('Publish')" ng-disabled="sendLock">
			<span class="glyphicon glyphicon-share-alt">
				<?php echo __d('notepads', 'Publish'); ?>
			</span>
		</button>
	<?php endif; ?>
</div>

