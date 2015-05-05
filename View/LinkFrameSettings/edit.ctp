<?php
/**
 * BbsSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$categorySeparators = Hash::combine(LinkFrameSetting::$categorySeparators, '{n}.key', '{n}');
$listStyles = Hash::combine(LinkFrameSetting::$listStyles, '{n}.key', '{n}');
?>

<?php echo $this->Html->css('/links/css/style.css', false); ?>
<?php echo $this->Html->script('/links/js/links.js', false); ?>

<div class="modal-body"
	ng-controller="LinkFrameSettings"
	ng-init="initialize(<?php echo h(json_encode(array(
		'frameId' => $frameId,
		'linkFrameSetting' => $linkFrameSetting,
		'currentCategorySeparatorLine' =>
						isset($categorySeparators[$linkFrameSetting['categorySeparatorLine']]) ?
							$categorySeparators[$linkFrameSetting['categorySeparatorLine']] : array(),
		'currentListStyle' =>
						isset($listStyles[$linkFrameSetting['listStyle']]) ?
							$listStyles[$linkFrameSetting['listStyle']] : array(),
	))); ?>)">

	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'LinkFrameSettings',
				'action' => 'edit' . '/' . $frameId,
				'callback' => 'Links.LinkFrameSettings/edit_form',
				'cancelUrl' => '/' . $cancelUrl,
			)); ?>
	</div>
</div>
