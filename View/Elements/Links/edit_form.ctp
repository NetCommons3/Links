<?php
/**
 * Element of Question edit form
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Block.id', array(
		'value' => $blockId,
	)); ?>

<?php echo $this->Form->hidden('Block.key', array(
		'value' => $blockKey,
	)); ?>

<?php echo $this->Form->hidden('Frame.id', array(
		'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('Link.id', array(
		'value' => isset($link['id']) ? (int)$link['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('Link.block_id', array(
		'value' => $blockId,
	)); ?>

<?php echo $this->Form->hidden('Link.key', array(
		'value' => $link['key'],
	)); ?>

<?php echo $this->Form->hidden('Link.language_id', array(
		'value' => $languageId,
	)); ?>

<?php echo $this->Form->hidden('LinkOrder.id', array(
		'value' => isset($linkOrder['id']) ? (int)$linkOrder['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('LinkOrder.block_key', array(
		'value' => $blockKey,
	)); ?>

<?php echo $this->Form->hidden('LinkOrder.link_key', array(
		'value' => isset($link['key']) ? $link['key'] : null,
	)); ?>

<div class="form-group">
	<div>
		<?php echo $this->Form->label('Link.url', __d('links', 'URL') . $this->element('NetCommons.required')); ?>
	</div>
	<div class="input-group">
		<?php echo $this->Form->input('Link.url', array(
				'type' => 'text',
				'label' => false,
				'error' => false,
				'div' => false,
				'class' => 'form-control',
				'value' => isset($link['url']) ? $link['url'] : null,
				'placeholder' => 'http://',
			)); ?>

		<span class="input-group-btn">
			<button class="btn btn-default" type="button" ng-click="getUrl()">
				<?php echo __d('links', 'GO!'); ?>
			</button>
		</span>
	</div>
	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'Link',
				'field' => 'url',
			]); ?>

		<div class="has-error" ng-show="urlError">
			<div class="help-block">
				{{urlError}}
			</div>
		</div>
	</div>
</div>

<div class="form-group">
	<?php echo $this->Form->input('Link.title', array(
			'type' => 'text',
			'label' => __d('links', 'Title') . $this->element('NetCommons.required'),
			'error' => false,
			'class' => 'form-control',
			'value' => isset($link['title']) ? $link['title'] : null,
		)); ?>

	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'Link',
				'field' => 'title',
			]); ?>
	</div>
</div>

<?php if (is_array($categories) && count($categories) > 0) : ?>
	<div class='form-group'>
		<?php $categories = Hash::combine($categories, '{n}.category.id', '{n}.category.name'); ?>

		<?php echo $this->Form->input('Link.category_id', array(
				'label' => __d('categories', 'Category'),
				'type' => 'select',
				'error' => false,
				'class' => 'form-control',
				'empty' => array(0 => __d('categories', 'Select Category')),
				'options' => $categories,
				'value' => (isset($link['categoryId']) ? $link['categoryId'] : '0')
			)); ?>
	</div>
<?php endif; ?>

<div class="form-group">
	<div>
		<?php echo $this->Form->input('Link.description', array(
				'type' => 'textarea',
				'label' => __d('links', 'Description'),
				'error' => false,
				'rows' => '3',
				'class' => 'form-control',
				'value' => isset($link['description']) ? $link['description'] : null,
			)); ?>
	</div>
</div>
