<div class="col-xs-4">
	<button class="btn btn-success"
			ng-click="showAddLink()"
			ng-show="visibleAddLink">
		<span class="glyphicon glyphicon-plus-sign">
			リンク追加
		</span>
	</button>
</div>

<div class="text-right col-xs-8">
	<button class="btn btn-primary"
			ng-click="showEdit()"
			ng-hide="visibleEdit">
		<span class="glyphicon glyphicon-edit">
			編集
		</span>
	</button>

	<button class="btn btn-primary ng-hide"
			ng-click="showContainer()"
			ng-show="visibleEdit">
		<span class="glyphicon glyphicon-edit">
			編集を終了する
		</span>
	</button>

	<?php if (Page::isSetting()) : ?>
		<button class="btn btn-primary"
				ng-click="showManage()"
				ng-hide="visibleManage">
			<span class="glyphicon glyphicon-cog">
				管理
			</span>
		</button>

		<button class="btn btn-primary ng-hide"
				ng-click="showContainer()"
				ng-show="visibleManage">
			<span class="glyphicon glyphicon-cog">
				管理を終了する
			</span>
		</button>
	<?php endif; ?>
</div>
