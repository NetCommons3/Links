<div class="panel panel-default">

	<div class="panel-body">
		<div class="row">
			<?php echo $this->element('Links/content_move_btn', array('size' => '2 col-md-2', 'upDisabled' => true)); ?>

			<div class="col-xs-7 col-md-8">
				<?php
					//カテゴリー名
					echo $this->Form->input('category_name.1', array(
								'label' => false,
								'type' => 'text',
								'class' => 'form-control',
								'value' => 'カテゴリ１１１１１１',
							)
						);
				?>
			</div>

			<?php echo $this->element('Links/content_edit_btn_category', array('published' => false, 'size' => '2 col-md-1')); ?>
		</div>
	</div>

	<div class="panel-body">
		<div class="row">
			<?php echo $this->element('Links/content_move_btn', array('size' => '2 col-md-2', 'downDisabled' => true)); ?>

			<div class="col-xs-7 col-md-8">
				<?php
					//カテゴリー名
					echo $this->Form->input('category_name.2', array(
								'label' => false,
								'type' => 'text',
								'class' => 'form-control',
								'value' => 'カテゴリ２２２２２２',
							)
						);
				?>
			</div>

			<?php echo $this->element('Links/content_edit_btn_category', array('published' => false, 'size' => '2 col-md-1')); ?>
		</div>
	</div>

	<div class="panel-body">

		<div class="text-right row">
			<div class="col-xs-offset-2 col-md-offset-2 col-xs-7 col-md-8">
				<?php
					//カテゴリー名
					echo $this->Form->input('category_name.0', array(
								'label' => false,
								'type' => 'text',
								'class' => 'form-control',
								'value' => '',
							)
						);
				?>

			</div>
			<div class="text-left col-xs-2 col-md-1">
				<button class="btn btn-success btn-xs">
					<span class="glyphicon glyphicon-plus hidden">	</span>
					<span class="">追加</span>
				</button>
			</div>

		</div>
	</div>

</div>


<p class="text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal">
		設定する
	</button>
</p>
