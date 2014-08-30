<div class="links index">
	<h2><?php echo __('Links'); ?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('links_block_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('language_id'); ?></th>
			<th><?php echo $this->Paginator->sort('is_auto_translated'); ?></th>
			<th><?php echo $this->Paginator->sort('translation_engine'); ?></th>
			<th><?php echo $this->Paginator->sort('links_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($links as $link): ?>
			<tr>
				<td><?php echo h($link['Link']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($link['LinksBlock']['id'], array('controller' => 'links_blocks', 'action' => 'view', $link['LinksBlock']['id'])); ?>
				</td>
				<td><?php echo h($link['Link']['status']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($link['Language']['id'], array('controller' => 'languages', 'action' => 'view', $link['Language']['id'])); ?>
				</td>
				<td><?php echo h($link['Link']['is_auto_translated']); ?>&nbsp;</td>
				<td><?php echo h($link['Link']['translation_engine']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($link['LinksCategory']['title'], array('controller' => 'links_categories', 'action' => 'view', $link['LinksCategory']['id'])); ?>
				</td>
				<td><?php echo h($link['Link']['title']); ?>&nbsp;</td>
				<td><?php echo h($link['Link']['url']); ?>&nbsp;</td>
				<td><?php echo h($link['Link']['description']); ?>&nbsp;</td>
				<td><?php echo h($link['Link']['created_user']); ?>&nbsp;</td>
				<td><?php echo h($link['Link']['created']); ?>&nbsp;</td>
				<td><?php echo h($link['Link']['modified_user']); ?>&nbsp;</td>
				<td><?php echo h($link['Link']['modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $link['Link']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $link['Link']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $link['Link']['id']), null, __('Are you sure you want to delete # %s?', $link['Link']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<p>
		<?php
		echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
		?>	</p>
	<div class="paging">
		<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Link'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Links Blocks'), array('controller' => 'links_blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Links Block'), array('controller' => 'links_blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Languages'), array('controller' => 'languages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Language'), array('controller' => 'languages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Links Categories'), array('controller' => 'links_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Links Category'), array('controller' => 'links_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
