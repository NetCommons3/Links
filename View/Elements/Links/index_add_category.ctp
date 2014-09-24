<div class="ng-scope">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 id="myModalLabel" class="modal-title">
					カテゴリー追加
				</h4>
			</div>
			<div class="modal-body">

				<div class='form-group'>
					<?php
						//カテゴリー名
						echo $this->Form->label('category_name', __('カテゴリー名'));

						echo $this->Form->input('category_name', array(
									'label' => false,
									'type' => 'text',
									'class' => 'form-control',
								)
							);
					?>
				</div>

				<p class="text-center">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						キャンセル
					</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">
						登録する
					</button>
				</p>

			</div>
		</div>
	</div>

</div>

