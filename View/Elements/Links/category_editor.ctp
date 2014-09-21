<div>
	<button class="btn btn-success">
		<span class="glyphicon glyphicon-plus-sign">
			カテゴリー追加
		</span>
	</button>
</div>

<div style="padding: 15px;">

	<div class="list-group">
		<div class="list-group-item row">
			<?php echo $this->element('Links/content_move_btn', array('size' => 3)); ?>

			<div class="col-xs-5">
				カテゴリ１
			</div>

			<?php echo $this->element('Links/content_edit_btn', array('published' => false, 'size' => 4)); ?>
		</div>
	</div>

	<div class="list-group">
		<div class="list-group-item row">
			<?php echo $this->element('Links/content_move_btn', array('size' => 3)); ?>

			<div class="col-xs-5">
				カテゴリ２
			</div>

			<?php echo $this->element('Links/content_edit_btn', array('published' => false, 'size' => 4)); ?>
		</div>
	</div>
</div>
