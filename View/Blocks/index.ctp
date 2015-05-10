<?php
/**
 * block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<div class="text-right">
			<a class="btn btn-success" href="<?php echo $this->Html->url('/links/blocks/add/' . $frameId);?>">
				<span class="glyphicon glyphicon-plus"> </span>
			</a>
		</div>

		<div id="nc-link-setting-<?php echo $frameId; ?>">
			<?php echo $this->Form->create('', array(
					'url' => '/frames/frames/edit/' . $frameId
				)); ?>

				<?php echo $this->Form->hidden('Frame.id', array(
						'value' => $frameId,
					)); ?>

				<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th>
								<?php echo $this->Paginator->sort('Link.name', __d('links', 'Link list Title')); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('Block.public_type', __d('blocks', 'Publishing setting')); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('Block.modified', __d('net_commons', 'Updated date')); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($linkBlocks as $linkBlock) : ?>
							<tr<?php echo ($blockId === $linkBlock['block']['id'] ? ' class="active"' : ''); ?>>
								<td>
									<?php echo $this->Form->input('Frame.block_id',
										array(
											'type' => 'radio',
											'name' => 'data[Frame][block_id]',
											'options' => array((int)$linkBlock['block']['id'] => ''),
											'div' => false,
											'legend' => false,
											'label' => false,
											'hiddenField' => false,
											'checked' => (int)$linkBlock['block']['id'] === (int)$blockId,
											'onclick' => 'submit()'
										)); ?>
								</td>
								<td>
									<a href="<?php echo $this->Html->url('/links/blocks/edit/' . $frameId . '/' . (int)$linkBlock['block']['id']); ?>">
										<?php echo h($linkBlock['linkBlock']['name']); ?>
									</a>
								</td>
								<td>
									<?php if ($linkBlock['block']['publicType'] === Block::TYPE_PRIVATE) : ?>
										<?php echo __d('blocks', 'Private'); ?>
									<?php elseif ($linkBlock['block']['publicType'] === Block::TYPE_PUBLIC) : ?>
										<?php echo __d('blocks', 'Public'); ?>
									<?php elseif ($linkBlock['block']['publicType'] === Block::TYPE_LIMITED) : ?>
										<?php echo __d('blocks', 'Limited'); ?>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $this->Date->dateFormat($linkBlock['block']['modified']); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo $this->Form->end(); ?>

			<div class="text-center">
				<?php echo $this->element('NetCommons.paginator', array(
						'url' => Hash::merge(
							array('controller' => 'blocks', 'action' => 'index', $frameId),
							$this->Paginator->params['named']
						)
					)); ?>
			</div>
		</div>
	</div>
</div>




