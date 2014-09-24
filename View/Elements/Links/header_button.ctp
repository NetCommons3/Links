
<div class="col-xs-4">
	<button class="btn btn-success"
			ng-click="showAddLink()"
			ng-show="visibleAddLink"
			tooltip="リンク追加">
		<span class="glyphicon glyphicon-plus"></span>
		<span class="hidden">
			リンク追加
		</span>
	</button>
</div>

<div class="text-right col-xs-7 col-xs-offset-1">
	<button class="btn btn-primary"
			ng-click="showEdit()"
			ng-hide="visibleEdit"
			tooltip="編集">
		<span class="glyphicon glyphicon-edit"></span>
		<span class="hidden">
			編集
		</span>
	</button>

	<button class="btn btn-primary ng-hide"
			ng-click="showContainer()"
			ng-show="visibleEdit"
			tooltip="編集終了">
		<span class="glyphicon glyphicon-edit"></span>
		<span class="">
			終了
		</span>
	</button>

	<?php if (Page::isSetting()) : ?>
		<button class="btn btn-primary"
				ng-click="showManage()"
				ng-hide="visibleManage"
			tooltip="管理">
			<span class="glyphicon glyphicon-cog">
			</span>
			<span class="hidden">
				管理
			</span>
		</button>

		<button class="btn btn-primary ng-hide"
				ng-click="showContainer()"
				ng-show="visibleManage"
			tooltip="管理終了">
			<span class="glyphicon glyphicon-cog">
			</span>
			<span class="">
				終了
			</span>
		</button>
	<?php endif; ?>
</div>
