
	<div class="modal-header">
		<button class="close" type="button"
				tooltip="<?php echo __d('links', 'Close'); ?>"
				ng-click="cancel()">
			<span class="glyphicon glyphicon-remove small"></span>
		</button>

		<ul class="nav nav-pills" role="tablist">
			<li class="active">
				<a href="#nc-links-change-order-move-{{frameId}}"
						role="tab" data-toggle="tab">
					リンク編集
				</a>
			</li>
			<li class="">
				<a href="#nc-links-category-editor-{{frameId}}"
						role="tab" data-toggle="tab">
					カテゴリー編集
				</a>
			</li>
			<li class="">
				<a href="#nc-links-display-style-{{frameId}}"
						role="tab" data-toggle="tab">
					表示方法変更
				</a>
			</li>
			<li class="">
				<a href="#nc-links-role-setting-{{frameId}}"
						role="tab" data-toggle="tab">
					権限設定
				</a>
			</li>
			<li class="disabled">
				<a href="#" onclick="return false;">
					メール設定
				</a>
			</li>
		</ul>
	</div>

	<div class="modal-body">
		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="nc-links-change-order-move-{{frameId}}">
				<div id="nc-links-change-order-modal-{{frameId}}"
					 ng-hide="visibleAddLinkForm">

					<?php echo $this->requestAction('/Links/LinkEdit/view/' . $frameId, array('return')); ?>
				</div>
				<div id="nc-links-add-link-modal-{{frameId}}" class="ng-hide"
					 ng-show="visibleAddLinkForm">
					<?php echo $this->requestAction('/Links/LinkEdit/viewEdit/' . $frameId, array('return')); ?>
				</div>
			</div>
			<div class="tab-pane" id="nc-links-category-editor-{{frameId}}">
				<?php echo $this->requestAction('/Links/LinkCategory/view/' . $frameId, array('return')); ?>
			</div>
			<div class="tab-pane" id="nc-links-display-style-{{frameId}}">
				<?php echo $this->requestAction('/Links/LinkDisplay/view/' . $frameId, array('return')); ?>
			</div>
			<div class="tab-pane" id="nc-links-role-setting-{{frameId}}">
				<?php echo $this->requestAction('/Links/LinkAuthority/view/' . $frameId, array('return')); ?>
			</div>
			<div class="tab-pane disabled" id="nc-links-mail-setting-{{frameId}}">
			</div>
		</div>
	</div>
