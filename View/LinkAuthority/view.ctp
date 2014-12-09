
<div class="panel panel-default">
 	<div class="panel-heading">
		リンク追加権限設定
	</div>
  	<div class="panel-body">
		<div class='form-group'>
			<div class='form-group'>
				<span class="glyphicon glyphicon-ok"></span>
				ルーム管理者
			</div>

			<div ng-repeat="(roleIndex, role) in rolePermissions.add_link">
				<div class='form-group'>
					<?php
					echo $this->Form->input('{{roleIndex}}', array(
							'type' => 'checkbox',
							'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
							'value' => 1,
							'label' => '{{role.name}}',
							'checked' => true,
							'ng-model' => 'role.permission'
						));
					?>
				</div>

			</div>


		</div>
	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary" ng-click="send()">
		設定する
	</button>
</p>
