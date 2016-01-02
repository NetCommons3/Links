<?php
/**
 * 編集フォームElement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Link.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Link.block_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Link.key'); ?>
<?php echo $this->NetCommonsForm->hidden('Link.language_id'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkOrder.id'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkOrder.block_key'); ?>
<?php echo $this->NetCommonsForm->hidden('LinkOrder.link_key'); ?>

<div class="form-group">
	<div>
		<?php echo $this->NetCommonsForm->label('Link.url', __d('links', 'URL') . $this->element('NetCommons.required')); ?>
	</div>
	<div class="input-group">
		<?php echo $this->NetCommonsForm->input('Link.url', array(
				'type' => 'text',
				'error' => false,
				'label' => false,
				'div' => false,
				'placeholder' => 'http://',
			)); ?>

		<span class="input-group-btn">
			<button class="btn btn-default" type="button" ng-click="getUrl(<?php echo Current::read('Frame.id'); ?>)">
				<?php echo __d('links', 'GO!'); ?>
			</button>
		</span>
	</div>
	<div>
		<div class="has-error">
			<?php echo $this->NetCommonsForm->error('Link.url', null, array('class' => 'help-block')); ?>
		</div>

		<div class="has-error" ng-show="urlError" ng-cloak>
			<div class="help-block">
				{{urlError}}
			</div>
		</div>
	</div>
</div>

<?php echo $this->NetCommonsForm->input('Link.title', array(
		'type' => 'text',
		'label' => __d('links', 'Title'),
		'required' => true,
	)); ?>

<?php echo $this->Category->select('Link.category_id', array('empty' => true)); ?>

<?php echo $this->NetCommonsForm->input('Link.description', array(
		'type' => 'textarea',
		'label' => __d('links', 'Description'),
		'rows' => '3',
	));
