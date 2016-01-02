<?php
/**
 * ブロック編集
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsComponent::MAIN_TAB_BLOCK_INDEX); ?>

	<div class="tab-content">
		<?php echo $this->BlockTabs->block(BlockTabsComponent::BLOCK_TAB_SETTING); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'model' => 'LinkBlock',
				'callback' => 'Links.LinkBlocks/edit_form',
				'cancelUrl' => NetCommonsUrl::backToIndexUrl('default_setting_action'),
			)); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'model' => 'LinkBlock',
					'action' => NetCommonsUrl::actionUrl(array(
						'controller' => $this->params['controller'],
						'action' => 'delete',
						'block_id' => Current::read('Block.id'),
						'frame_id' => Current::read('Frame.id')
					)),
					'callback' => 'Links.LinkBlocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</article>
