<?php
/**
 * ブロック一覧
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<div class="tab-content">
		<div class="text-right">
			<?php echo $this->Button->addLink(); ?>
		</div>

		<?php echo $this->NetCommonsForm->create('', array(
				'url' => NetCommonsUrl::actionUrl(array('plugin' => 'frames', 'controller' => 'frames', 'action' => 'edit'))
			)); ?>

			<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>

			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th>
							<?php echo $this->Paginator->sort('Link.name', __d('links', 'Link list Title')); ?>
						</th>
						<th>
							<?php echo $this->Paginator->sort('Block.modified', __d('net_commons', 'Updated date')); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($linkBlocks as $linkBlock) : ?>
						<tr<?php echo ($this->data['Frame']['block_id'] === $linkBlock['Block']['id'] ? ' class="active"' : ''); ?>>
							<td>
								<?php echo $this->BlockForm->displayFrame('Frame.block_id', $linkBlock['Block']['id']); ?>
							</td>
							<td>
								<?php echo $this->NetCommonsHtml->editLink($linkBlock['Block']['name'], array('block_id' => $linkBlock['Block']['id'])); ?>
							</td>
							<td>
								<?php echo $this->Date->dateFormat($linkBlock['Block']['modified']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php echo $this->NetCommonsForm->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>




