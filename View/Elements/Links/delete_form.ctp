<?php
/**
 * 削除フォームElement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->create('Link', array('type' => 'delete', 'url' => NetCommonsUrl::blockUrl(array('action' => 'delete')))); ?>
	<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>
	<?php echo $this->NetCommonsForm->hidden('Link.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('Link.key'); ?>
	<?php echo $this->NetCommonsForm->hidden('LinkOrder.id'); ?>

	<?php echo $this->Button->delete('',
			sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('links', 'Link'))
		); ?>

<?php echo $this->NetCommonsForm->end();
