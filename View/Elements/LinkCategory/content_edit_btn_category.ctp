<div class="text-left col-xs-<?php echo $size; ?>">
	<?php if ($published) : ?>
		<button class="btn btn-danger btn-xs">
			公開する
		</button>
	<?php endif; ?>

	<button class="btn btn-default btn-xs"
			ng-click="deleteEditCategory($index)">
		削除
	</button>
</div>
