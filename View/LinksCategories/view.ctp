<div class="linksCategories view">
<h2><?php echo __('Links Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Links Block'); ?></dt>
		<dd>
			<?php echo $this->Html->link($linksCategory['LinksBlock']['id'], array('controller' => 'links_blocks', 'action' => 'view', $linksCategory['LinksBlock']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Language'); ?></dt>
		<dd>
			<?php echo $this->Html->link($linksCategory['Language']['id'], array('controller' => 'languages', 'action' => 'view', $linksCategory['Language']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Auto Translated'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['is_auto_translated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Translation Engine'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['translation_engine']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created User'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['created_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified User'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['modified_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($linksCategory['LinksCategory']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Links Category'), array('action' => 'edit', $linksCategory['LinksCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Links Category'), array('action' => 'delete', $linksCategory['LinksCategory']['id']), null, __('Are you sure you want to delete # %s?', $linksCategory['LinksCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Links Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Links Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Links Blocks'), array('controller' => 'links_blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Links Block'), array('controller' => 'links_blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Languages'), array('controller' => 'languages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Language'), array('controller' => 'languages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Links'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Links'); ?></h3>
	<?php if (!empty($linksCategory['Link'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Links Block Id'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Language Id'); ?></th>
		<th><?php echo __('Is Auto Translated'); ?></th>
		<th><?php echo __('Translation Engine'); ?></th>
		<th><?php echo __('Links Category Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Url'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Created User'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified User'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($linksCategory['Link'] as $link): ?>
		<tr>
			<td><?php echo $link['id']; ?></td>
			<td><?php echo $link['links_block_id']; ?></td>
			<td><?php echo $link['status']; ?></td>
			<td><?php echo $link['language_id']; ?></td>
			<td><?php echo $link['is_auto_translated']; ?></td>
			<td><?php echo $link['translation_engine']; ?></td>
			<td><?php echo $link['links_category_id']; ?></td>
			<td><?php echo $link['title']; ?></td>
			<td><?php echo $link['url']; ?></td>
			<td><?php echo $link['description']; ?></td>
			<td><?php echo $link['created_user']; ?></td>
			<td><?php echo $link['created']; ?></td>
			<td><?php echo $link['modified_user']; ?></td>
			<td><?php echo $link['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'links', 'action' => 'view', $link['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'links', 'action' => 'edit', $link['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'links', 'action' => 'delete', $link['id']), null, __('Are you sure you want to delete # %s?', $link['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
