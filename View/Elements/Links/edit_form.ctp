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

<div class="form-group" ng-class="{'has-error': urlError}"
		ng-init="urlError='<?php echo $this->Form->error('Link.url', null, ['wrap' => false]); ?>'">

	<?php echo $this->NetCommonsForm->input('Link.url', array(
			'type' => 'text',
			'label' => __d('links', 'URL'),
			'div' => false,
			'required' => true,
			'error' => false
		)); ?>

	<div class="help-block" ng-show="urlError" ng-cloak>
		{{urlError}}
	</div>
</div>

<div class="form-group text-center">
	<button class="btn btn-default btn-sm link-getbtn" type="button" ng-click="getUrl(<?php echo Current::read('Frame.id'); ?>)">
		<?php echo __d('links', 'GO!'); ?>
	</button>
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
