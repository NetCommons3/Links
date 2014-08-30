<div class="links form">
<?php echo $this->Form->create('Link'); ?>
	<fieldset>
		<legend><?php echo __('Edit Link'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('links_block_id');
		echo $this->Form->input('status');
		echo $this->Form->input('language_id');
		echo $this->Form->input('is_auto_translated');
		echo $this->Form->input('translation_engine');
		echo $this->Form->input('links_category_id');
		echo $this->Form->input('title');
		echo $this->Form->input('url');
		echo $this->Form->input('description');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
		echo $this->Form->input('Block');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Link.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Link.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Links'), array('action' => 'index')); ?></li>
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
