<div class="panel panel-default">
 	<div class="panel-heading">
		カテゴリー追加権限設定
	</div>
  	<div class="panel-body">
		<div class='form-group'>
			<span style="margin-left: 20px; font-weight: bold;">
				<span class="glyphicon glyphicon-ok"></span>
				ルーム管理者
			</span>

			<span style="margin-left: 20px;">
				<?php
					echo $this->Form->input('category_author[2]', array(
						'type' => 'checkbox',
						'div' => null,
						'value' => 2,
						'label' => '編集長',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</span>

			<span style="margin-left: 20px;">
				<?php
					echo $this->Form->input('category_author[3]', array(
						'type' => 'checkbox',
						'div' => null,
						'value' => 3,
						'label' => '編集者',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</span>

			<span style="margin-left: 20px;">
				<?php
					echo $this->Form->input('category_author[4]', array(
						'type' => 'checkbox',
						'div' => null,
						'value' => 4,
						'label' => '一般',
						'checked' => false,
						'autocomplete' => 'off',
					));
				?>
			</span>

		</div>
	</div>
</div>

<div class="panel panel-default">
 	<div class="panel-heading">
		リンク追加権限設定
	</div>
  	<div class="panel-body">
		<div class='form-group'>
			<span style="margin-left: 20px; font-weight: bold;">
				<span class="glyphicon glyphicon-ok"></span>
				ルーム管理者
			</span>

			<span style="margin-left: 20px; font-weight: normal;">
				<?php
					echo $this->Form->input('category_author[2]', array(
						'type' => 'checkbox',
						'div' => null,
						'value' => 2,
						'label' => '編集長',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</span>

			<span style="margin-left: 20px; font-weight: normal;">
				<?php
					echo $this->Form->input('category_author[3]', array(
						'type' => 'checkbox',
						'div' => null,
						'value' => 3,
						'label' => '編集者',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</span>

			<span style="margin-left: 20px; font-weight: normal;">
				<?php
					echo $this->Form->input('category_author[4]', array(
						'type' => 'checkbox',
						'div' => null,
						'value' => 4,
						'label' => '一般',
						'checked' => false,
						'autocomplete' => 'off',
					));
				?>
			</span>

		</div>
	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary">
		設定する
	</button>
</p>
