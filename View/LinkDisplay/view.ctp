<div class="panel panel-default">
  	<div class="panel-body">
		<div class='form-group'>
			{{FrameSetting.display_type}}
			<?php
				//表示方法変更
				echo $this->Form->label('display_type', __('表示方法変更'));

				echo $this->Form->input('display_type', array(
							//'label' => false,
							//'label' => true,
							'legend' => false,
							'type' => 'radio',
							'options' => array(
								0 => 'ドロップダウンで表示する',
								1 => '一覧で表示する',
								//2 => '一覧で表示する(説明付き)',
							),
							//'before' => '<br />'
							'separator' => '<br />',
							//'after' => '<div style="margin-bottom: 30px;"> </div>',
							'selected' => 0,
						'ng-model' => 'FrameSetting.display_type',
							'div' => array('class' => 'input radio', 'style' => 'margin-left: 30px;'),
							//'class' => 'form-control',

						)
					);

				//リンククリック時、新規ウィンドウで表示する
				echo $this->Form->input('display_description', array(
							//'label' => false,
							'type' => 'checkbox',
							'label' => '説明を表示する',
							'div' => array('style' => 'font-weight: normal; margin-left: 70px;'),
							'checked' => true,
						'value' => 3,
						'ng-model' => 'FrameSetting.display_description',
						)
					);
			?>

			<div style="margin-bottom: 30px;"> </div>
		</div>

		<div class='form-group'>
			<?php
				//リンククリック時、新規ウィンドウで表示する
				echo $this->Form->input('open_new_tab', array(
							//'label' => false,
							'type' => 'checkbox',
							'label' => 'リンクをクリック時、新規ウィンドウで表示する',
							'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
							'checked' => true,
						'ng-model' => 'FrameSetting.open_new_tab',

						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				//リンク先参照回数を表示する
				echo $this->Form->input('display_click_number', array(
							//'label' => false,
							'type' => 'checkbox',
							'label' => 'リンク先参照回数を表示する',
							'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
							'checked' => true,
						'ng-model' => 'FrameSetting.display_click_number',
						)
					);
			?>
		</div>

		<div class='form-group'>

			<?php
				//カテゴリ間の区切り線
				echo $this->Form->label('category_separator_line', __('カテゴリ間の区切り線'));

				echo $this->Form->input('category_separator_line', array(
							'label' => false,
							'type' => 'textarea',
							'rows' => 2,
							'value' => 'MyTodo',
							'class' => 'form-control',
						'ng-model' => 'FrameSetting.category_separator_line',
						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				//リストマーカー
				echo $this->Form->label('list_style', __('リストマーカー'));

				echo $this->Form->input('list_style', array(
							'label' => false,
							'type' => 'textarea',
							'rows' => 2,
							'value' => 'MyTodo',
							'class' => 'form-control',
						'ng-model' => 'FrameSetting.list_style',
						)
					);
			?>
		</div>
	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary" ng-click="postDisplayStyle()">
		設定する
	</button>
</p>
