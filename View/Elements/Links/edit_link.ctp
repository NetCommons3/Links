<?php
/**
 * 編集リンクElement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if ($this->Workflow->canEdit('Links.Link', $link)) : ?>
	<?php echo $this->LinkButton->edit('', array('key' => $link['Link']['key']), array(
			'tooltip' => true,
			'iconSize' => 'btn-xs'
		)); ?>
<?php endif;
