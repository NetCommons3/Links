<?php $link = array() ?>
<?php echo $this->Html->script('/links/js/links.js'); ?>
<div ng-controller="Links"
	ng-init="initialize(<?php echo h(json_encode($link)); ?>,
	<?php echo (int)$frameId; ?>)">



<?php
echo $this->element('header_buttons');
echo $this->element('link_list');

?>
	<?php
	//プレビューの表示
//	echo $this->element('index/preview');

	//状態ラベルの表示
//	echo $this->element('index/status_label');

	//入力フォームの表示
	echo $this->element('link_form');

	?>

	<div class="hidden" id="nc-links-post-form-area-<?php echo (int)$frameId; ?>">
		<?php
		//登録POST用のフォーム
		?>
	</div>

</div>
