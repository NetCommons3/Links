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

$LinkFrameSetting = ClassRegistry::init('Links.LinkFrameSetting');

$categorySeparators = $LinkFrameSetting->categorySeparators;
$listStyles = $LinkFrameSetting->listStyles;
if (isset($this->data['LinkFrameSetting'])) {
	$linkFrameSetting = $this->data['LinkFrameSetting'];
	$currentCategorySepaLine = $this->data['LinkFrameSetting']['category_separator_line'];
	$currentListStyle = $this->data['LinkFrameSetting']['list_style'];
} else {
	$linkFrameSetting = [];
	$currentCategorySepaLine = '';
	$currentListStyle = '';
}
?>

<?php echo $this->NetCommonsHtml->css('/links/css/style.css'); ?>
<?php echo $this->NetCommonsHtml->script('/links/js/links.js'); ?>

<article class="block-setting-body"
	ng-controller="LinkFrameSettings"
	ng-init="initialize(<?php echo h(json_encode(array(
		'linkFrameSetting' => $linkFrameSetting,
		'currentCategorySeparatorLine' => $categorySeparators[$currentCategorySepaLine],
		'currentListStyle' => $listStyles[$currentListStyle],
	))); ?>)">

	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_FRAME_SETTING); ?>

	<div class="tab-content">
		<?php echo $this->BlockForm->displayEditForm(array(
				'model' => 'LinkFrameSetting',
				'callback' => 'Links.LinkFrameSettings/edit_form',
				'cancelUrl' => NetCommonsUrl::backToPageUrl(true),
			)); ?>
	</div>
</article>
