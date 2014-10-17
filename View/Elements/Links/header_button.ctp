
<div class="col-xs-4">
	<button class="btn btn-success"
			ng-click="showAddLink()"
			ng-show="visibleAddLink"
			tooltip="リンクを追加する">
		<span class="glyphicon glyphicon-plus"></span>
		<span class="hidden">
			リンク追加
		</span>
	</button>
</div>

<div class="text-right col-xs-7 col-xs-offset-1">
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

	<button class="btn btn-danger ng-hide"
			ng-click="showContainer()"
			ng-show="visibleManage"
			tooltip="編集を終了する">
		<span class="glyphicon glyphicon-remove">
		</span>
	</button>
</div>
