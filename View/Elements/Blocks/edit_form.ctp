<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Frame.id', array(
		'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('Block.id', array(
		'value' => $block['id'],
	)); ?>

<?php echo $this->Form->hidden('Block.key', array(
		'value' => $block['key'],
	)); ?>

<?php echo $this->Form->hidden('Block.language_id', array(
		'value' => $languageId,
	)); ?>

<?php echo $this->Form->hidden('Block.room_id', array(
		'value' => $roomId,
	)); ?>

<?php echo $this->Form->hidden('Block.plugin_key', array(
		'value' => $this->params['plugin'],
	)); ?>

<?php echo $this->Form->hidden('LinkSetting.id', array(
		'value' => isset($linkSetting['id']) ? (int)$linkSetting['id'] : null,
	)); ?>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->input(
				'Block.name', array(
					'type' => 'text',
					'label' => __d('links', 'Link list Title') . $this->element('NetCommons.required'),
					'error' => false,
					'class' => 'form-control',
					'autofocus' => true,
					'value' => (isset($block['name']) ? $block['name'] : '')
				)
			); ?>
	</div>

	<div class="col-xs-12">
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'Block',
				'field' => 'name',
			]); ?>
	</div>
</div>

<?php echo $this->element('Blocks.public_type'); ?>

<?php echo $this->element('Categories.edit_form', array(
		'categories' => isset($categories) ? $categories : null
	));
