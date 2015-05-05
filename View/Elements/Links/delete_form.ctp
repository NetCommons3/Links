<?php
/**
 * Element of Question delete form
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->create('Link', array(
			'type' => 'delete',
			'controller' => 'links',
			'action' => 'delete/' . $frameId . '/' . h($link['key'])
		)); ?>

	<?php echo $this->Form->hidden('Block.id', array(
			'value' => $blockId,
		)); ?>

	<?php echo $this->Form->hidden('Block.key', array(
			'value' => $block['key'],
		)); ?>

	<?php echo $this->Form->hidden('Link.id', array(
			'value' => isset($link['id']) ? (int)$link['id'] : null,
		)); ?>

	<?php echo $this->Form->hidden('Link.key', array(
			'value' => $link['key'],
		)); ?>

	<?php echo $this->Form->button('<span class="glyphicon glyphicon-trash"> </span>', array(
			'name' => 'delete',
			'class' => 'btn btn-danger',
			'onclick' => 'return confirm(\'' . sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('links', 'Link')) . '\')'
		)); ?>
<?php echo $this->Form->end();
