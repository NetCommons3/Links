<div class="text-right col-xs-<?php echo $size; ?>">
	<?php if ($published) : ?>
		<button class="btn btn-danger btn-xs">
			公開する
		</button>
	<?php endif; ?>
	<button class="btn btn-primary btn-xs"
			ng-click="showEditLink()">
		編集
	</button>

	<button class="btn btn-default btn-xs">
		削除
	</button>
</div>
