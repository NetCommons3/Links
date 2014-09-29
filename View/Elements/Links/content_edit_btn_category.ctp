<div class="text-left col-xs-<?php echo $size; ?>">
	<?php if ($published) : ?>
		<button class="btn btn-danger btn-xs">
			公開する
		</button>
	<?php endif; ?>
<!--
	<button class="btn btn-primary btn-xs">
		編集
	</button>
-->

	<button class="btn btn-default btn-xs"
			ng-click="deleteEditCategory()">
		削除
	</button>
</div>
