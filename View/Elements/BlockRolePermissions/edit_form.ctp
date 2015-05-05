<?php
/**
 * Link edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('LinkSetting.id', array(
		'value' => isset($linkSetting['id']) ? (int)$linkSetting['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('LinkSetting.block_key', array(
		'value' => isset($linkSetting['blockKey']) ? $linkSetting['blockKey'] : null,
	)); ?>

<?php echo $this->Form->hidden('Block.id', array(
		'value' => $blockId,
	)); ?>

<?php echo $this->element('Blocks.content_role_setting', array(
		'roles' => $roles,
		'permissions' => isset($blockRolePermissions) ? $blockRolePermissions : null,
		'useWorkflow' => array(
			'name' => 'LinkSetting.use_workflow',
			'value' => $linkSetting['useWorkflow']
		),
	));
