<div class="links view">
<h2><?php echo __('Link'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($link['Link']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Links Block'); ?></dt>
		<dd>
			<?php echo $this->Html->link($link['LinksBlock']['id'], array('controller' => 'links_blocks', 'action' => 'view', $link['LinksBlock']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($link['Link']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Language'); ?></dt>
		<dd>
			<?php echo $this->Html->link($link['Language']['id'], array('controller' => 'languages', 'action' => 'view', $link['Language']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Auto Translated'); ?></dt>
		<dd>
			<?php echo h($link['Link']['is_auto_translated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Translation Engine'); ?></dt>
		<dd>
			<?php echo h($link['Link']['translation_engine']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Links Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($link['LinksCategory']['title'], array('controller' => 'links_categories', 'action' => 'view', $link['LinksCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($link['Link']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($link['Link']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($link['Link']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created User'); ?></dt>
		<dd>
			<?php echo h($link['Link']['created_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($link['Link']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified User'); ?></dt>
		<dd>
			<?php echo h($link['Link']['modified_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($link['Link']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Link'), array('action' => 'edit', $link['Link']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Link'), array('action' => 'delete', $link['Link']['id']), null, __('Are you sure you want to delete # %s?', $link['Link']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Links'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Blocks'); ?></h3>
	<?php if (!empty($link['Block'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Room Id'); ?></th>
		<th><?php echo __('Created User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified User Id'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($link['Block'] as $block): ?>
		<tr>
			<td><?php echo $block['id']; ?></td>
			<td><?php echo $block['room_id']; ?></td>
			<td><?php echo $block['created_user_id']; ?></td>
			<td><?php echo $block['created']; ?></td>
			<td><?php echo $block['modified_user_id']; ?></td>
			<td><?php echo $block['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'blocks', 'action' => 'view', $block['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'blocks', 'action' => 'edit', $block['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'blocks', 'action' => 'delete', $block['id']), null, __('Are you sure you want to delete # %s?', $block['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
