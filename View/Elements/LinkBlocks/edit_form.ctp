<?php
/**
 * ブロック編集フォームElement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->element('Blocks.form_hidden'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkSetting.block_key'); ?>

<?php echo $this->NetCommonsForm->hidden('LinkBlock.id'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkBlock.key'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkBlock.language_id'); ?>
<?php echo $this->NetCommonsForm->input('LinkBlock.name', array(
		'type' => 'text',
		'label' => __d('links', 'Link list Title'),
		'required' => true
	)); ?>

<?php echo $this->element('Blocks.public_type'); ?>

<?php echo $this->element('Categories.edit_form');