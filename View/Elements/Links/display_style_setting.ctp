<div class="panel panel-default">
  	<div class="panel-body">
		<div class='form-group'>
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
								1 => '一覧で表示する(説明なし)',
								2 => '一覧で表示する(説明付き)',
							),
							//'before' => '<br />'
							'separator' => '<br />',
							'after' => '<div style="margin-bottom: 30px;"> </div>',
							'selected' => 0,
							'div' => array('class' => 'input radio', 'style' => 'margin-left: 30px;'),
							//'class' => 'form-control',
						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				//リンククリック時、新規ウィンドウで表示する
				echo $this->Form->input('click_open_window', array(
							//'label' => false,
							'type' => 'checkbox',
							'label' => 'リンクをクリック時、新規ウィンドウで表示する',
							'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
							'checked' => true,
						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				//リンク先参照回数を表示する
				echo $this->Form->input('click_count', array(
							//'label' => false,
							'type' => 'checkbox',
							'label' => 'リンク先参照回数を表示する',
							'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
							'checked' => true,
						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				//カテゴリ間の区切り線
				echo $this->Form->label('category_separater', __('カテゴリ間の区切り線'));

				echo $this->Form->input('category_separater', array(
							'label' => false,
							'type' => 'textarea',
							'rows' => 2,
							'value' => '',
							'class' => 'form-control',
						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				//リストマーカー
				echo $this->Form->label('list_marker', __('リストマーカー'));

				echo $this->Form->input('list_marker', array(
							'label' => false,
							'type' => 'textarea',
							'rows' => 2,
							'value' => '',
							'class' => 'form-control',
						)
					);
			?>
		</div>
	</div>
</div>

	<p class="text-center">
		<button type="button" class="btn btn-default">
			キャンセル
		</button>
		<button type="button" class="btn btn-primary"
				ng-click="postDisplayStyle()">
			設定する
		</button>
	</p>
