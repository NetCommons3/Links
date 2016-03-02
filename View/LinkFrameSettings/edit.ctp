<?php
/**
 * 表示方法変更
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$LinkFrameSetting = new LinkFrameSetting();

$categorySeparators = Hash::combine($LinkFrameSetting->categorySeparators, '{n}.key', '{n}');
$listStyles = Hash::combine($LinkFrameSetting->listStyles, '{n}.key', '{n}');
$linkFrameSetting = NetCommonsAppController::camelizeKeyRecursive(
	Hash::get($this->data, 'LinkFrameSetting', array())
);
?>

<?php echo $this->NetCommonsHtml->css('/links/css/style.css'); ?>
<?php echo $this->NetCommonsHtml->script('/links/js/links.js'); ?>

<div class="modal-body"
	ng-controller="LinkFrameSettings"
	ng-init="initialize(<?php echo h(json_encode(array(
		'linkFrameSetting' => $linkFrameSetting,
		'currentCategorySeparatorLine' => $categorySeparators[Hash::get($this->data, 'LinkFrameSetting.category_separator_line', '')],
		'currentListStyle' => $listStyles[Hash::get($this->data, 'LinkFrameSetting.list_style', '')],
	))); ?>)">

	<?php echo $this->BlockTabs->main(BlockTabsComponent::MAIN_TAB_FRAME_SETTING); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
				'model' => 'LinkFrameSetting',
				'action' => NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'edit',
					'frame_id' => Current::read('Frame.id')
				)),
				'callback' => 'Links.LinkFrameSettings/edit_form',
			)); ?>
	</div>
</div>
