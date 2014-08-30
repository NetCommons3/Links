<div class="linksCategories index">
	<h2><?php echo __('Links Categories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('links_block_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('language_id'); ?></th>
			<th><?php echo $this->Paginator->sort('is_auto_translated'); ?></th>
			<th><?php echo $this->Paginator->sort('translation_engine'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($linksCategories as $linksCategory): ?>
	<tr>
		<td><?php echo h($linksCategory['LinksCategory']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($linksCategory['LinksBlock']['id'], array('controller' => 'links_blocks', 'action' => 'view', $linksCategory['LinksBlock']['id'])); ?>
		</td>
		<td><?php echo h($linksCategory['LinksCategory']['status']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($linksCategory['Language']['id'], array('controller' => 'languages', 'action' => 'view', $linksCategory['Language']['id'])); ?>
		</td>
		<td><?php echo h($linksCategory['LinksCategory']['is_auto_translated']); ?>&nbsp;</td>
		<td><?php echo h($linksCategory['LinksCategory']['translation_engine']); ?>&nbsp;</td>
		<td><?php echo h($linksCategory['LinksCategory']['title']); ?>&nbsp;</td>
		<td><?php echo h($linksCategory['LinksCategory']['created_user']); ?>&nbsp;</td>
		<td><?php echo h($linksCategory['LinksCategory']['created']); ?>&nbsp;</td>
		<td><?php echo h($linksCategory['LinksCategory']['modified_user']); ?>&nbsp;</td>
		<td><?php echo h($linksCategory['LinksCategory']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $linksCategory['LinksCategory']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $linksCategory['LinksCategory']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $linksCategory['LinksCategory']['id']), null, __('Are you sure you want to delete # %s?', $linksCategory['LinksCategory']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Links Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Links Blocks'), array('controller' => 'links_blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Links Block'), array('controller' => 'links_blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Languages'), array('controller' => 'languages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Language'), array('controller' => 'languages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Links'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
	</ul>
</div>
