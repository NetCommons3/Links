	<div class='form-group'>
		<?php
			//リンクURL
			echo $this->Form->label('link_url', __('リンクURL'));

			echo $this->Form->input('link_url', array(
						'label' => false,
						'type' => 'text',
						'class' => 'form-control',
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
<!--
		<div style="margin-top: 2px;">
			<div class='row'>
				<div class="col-xs-6">
					<button class="btn btn-primary btn-xs">
						編集
					</button>
					<button class="btn btn-default btn-xs">
						削除
					</button>
				</div>

				<div class="text-right col-xs-6">
					<button class="btn btn-success btn-xs"
							 data-dismiss="modal"
							ng-click="showAddCategory()">
						カテゴリー追加
					</button>
				</div>
			</div>
		</div>
-->

	</div>

	<div class='form-group'>
		<?php
			//タイトル
			echo $this->Form->label('tittle', __('タイトル'));

			echo $this->Form->input('tittle', array(
						'label' => false,
						'type' => 'text',
						'class' => 'form-control',
					)
				);
		?>
	</div>


	<div class='form-group'>
		<?php
			//説明
			echo $this->Form->label('tittle', __('説明'));

			echo $this->Form->input('tittle', array(
						'label' => false,
						'type' => 'textarea',
						'rows' => 2,
						'class' => 'form-control',
					)
				);
		?>
	</div>

<!--
	<p class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal">
			キャンセル
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			下書き
		</button>
		<button type="button" class="btn btn-primary" data-dismiss="modal">
			公開する
		</button>
	</p>
-->

	<p class="text-center">
		<button type="button" class="btn btn-default" ng-click="showContainer()">
			キャンセル
		</button>
		<button type="button" class="btn btn-default" ng-click="showContainer()">
			下書き
		</button>
		<button type="button" class="btn btn-primary" ng-click="showContainer()">
			公開する
		</button>
	</p>
