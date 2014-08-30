<?php
/**
 * setting/form_button template elements
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author SkeletonAuthorName <SkeletonAuthorEMail>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 * @package app.Plugin.AccessCounters.View.Elements.setting
 */
?>

<div class="text-center ng-hide" ng-show="Form.button">
	<button class="btn btn-default"
			ng-disabled="sendLock" ng-click="hideSetting()">
		<span> <?php echo __d('notepads', 'Cancel'); ?> </span>
	</button>

	<button class="btn btn-default"
			ng-click="showPreview()" ng-hide="Preview.display" ng-disabled="sendLock">

		<span class="glyphicon glyphicon-file"></span>
		<span><?php echo __d('notepads', 'Preview'); ?></span>
	</button>

	<button class="btn btn-default"
			ng-click="hidePreview()" ng-show="Preview.display" ng-disabled="sendLock">

		<span class="glyphicon glyphicon-file"></span>
		<span><?php echo __d('notepads', 'Close Preview'); ?></span>
	</button>

	<button class="btn btn-default"
			ng-click="post(<?php echo Notepad::STATUS_DRAFTED; ?>)" ng-hide="Label.approval" ng-disabled="sendLock">

		<span class="glyphicon glyphicon-pencil"></span>
		<span><?php echo __d('notepads', 'Draft'); ?></span>
	</button>

	<button class="btn btn-default"
			ng-click="post(<?php echo Notepad::STATUS_DISAPPROVED; ?>)" ng-show="Label.approval" ng-disabled="sendLock">

		<span class="glyphicon glyphicon-pencil"></span>
		<span><?php echo __d('notepads', 'Disapproval'); ?></span>
	</button>

	<?php if (! $contentPublishable) : ?>
		<button class="btn btn-primary"
				ng-click="post(<?php echo Notepad::STATUS_APPROVED; ?>)" ng-disabled="sendLock">
			<span class="glyphicon glyphicon-share-alt"></span>
			<span><?php echo __d('notepads', 'Approval'); ?></span>
		</button>
	<?php else : ?>
		<button class="btn btn-primary"
				ng-click="post(<?php echo Notepad::STATUS_PUBLISHED; ?>)"	ng-disabled="sendLock">

			<span class="glyphicon glyphicon-share-alt"></span>
			<span><?php echo __d('notepads', 'Publish'); ?></span>
		</button>
	<?php endif; ?>
</div>