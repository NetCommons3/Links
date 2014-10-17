<div class="panel panel-default">
	<div class="panel-body">
		<div class='form-group'>
			<?php
				//リンクURL
				echo $this->Form->label('link_url', __('リンクURL'));

				echo $this->Form->input('link_url', array(
							'label' => false,
							'type' => 'text',
							'class' => 'form-control',
							'value' => '{{Form.link_url}}'
						)
					);
			?>
			<div class="text-right" style="margin-top: 2px;">
				<button class="btn btn-info btn-xs">
					サイト情報取得
				</button>
			</div>

		</div>

		<div class='form-group'>
			<?php
				//カテゴリー
				echo $this->Form->label('category', __('カテゴリー'));

				echo $this->Form->input('category', array(
							'label' => false,
							'type' => 'select',
							'options' => array(1 => 'カテゴリー1', '2' => 'カテゴリー2', '3' => 'カテゴリー3'),
							'selected' => 1,
							'class' => 'form-control',
						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				//タイトル
				echo $this->Form->label('title', __('タイトル'));

				echo $this->Form->input('title', array(
							'label' => false,
							'type' => 'text',
							'class' => 'form-control',
							'value' => '{{Form.title}}'
						)
					);
			?>
		</div>


		<div class='form-group'>
			<?php
				//説明
				echo $this->Form->label('description', __('説明'));

				echo $this->Form->input('description', array(
							'label' => false,
							'type' => 'textarea',
							'rows' => 2,
							'class' => 'form-control',
							'value' => '{{Form.description}}'
						)
					);
			?>
		</div>

	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="<?php echo $ngClick; ?>">
		キャンセル
	</button>
	<button type="button" class="btn btn-default" ng-click="<?php echo $ngClick; ?>">
		下書き
	</button>
	<button type="button" class="btn btn-primary" ng-click="<?php echo $ngClick; ?>">
		公開する
	</button>
</p>
