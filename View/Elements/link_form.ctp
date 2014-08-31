<?php
/**
 * setting/form_button template elements
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author SkeletonAuthorName <SkeletonAuthorEMail>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 * @package app.Plugin.AccessCounters.View.Elements.index
 */
?>

<form method="post" accept-charset="utf-8" class="ng-hide"
	  id="nc-links-input-form-<?php echo (int)$frameId; ?>"
	  ng-show="Form.display">

	<?php
	$links['Link'] = array(
		'title' => '',
		'url' => '',
		'description' => '',
	);
	//		タイトル(text ng-model=Form.title)、
	echo $this->LinksForm->input('Link.title',
		array('ng-init' =>'Form.title=\''. $links['Link']['title'].'\'',
			'ng-model' => 'Form.title'));

	echo $this->LinksForm->input('Link.url',
		array('ng-init' =>'Form.url=\''. $links['Link']['url'].'\'',
			'ng-model' => 'Form.url'));

	echo $this->LinksForm->input('Link.description',
		array('ng-init' =>'Form.description=\''. $links['Link']['description'].'\'',
			'ng-model' => 'Form.description', 'type' => 'textarea'));

	?>

</form>

<?php
//入力フォームのボタン表示
echo $this->element('form_buttons');
?>
