<!--
<nav class="navbar navbar-default" role="navigation">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-<?php echo (int)$frameId; ?>">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-<?php echo (int)$frameId; ?>">
-->

		<ul class="nav nav-tabs" role="tablist">
			<li class="small active">
				<a href="#nc-links-change-order-move-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					リンク編集
				</a>
			</li>
			<li class="small">
				<a href="#nc-links-category-editor-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					カテゴリー編集
				</a>
			</li>
			<li class="small">
				<a href="#nc-links-display-style-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					表示方法変更
				</a>
			</li>
			<li class="small">
				<a href="#nc-links-role-setting-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					権限設定
				</a>
			</li>
			<li class="small disabled">
				<a href="#" onclick="return false;">
					メール設定
				</a>
			</li>
		</ul>
<!--
	</div>
</nav>
-->

<br />

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="nc-links-change-order-move-<?php echo (int)$frameId; ?>">
		<div id="nc-links-change-order-modal-<?php echo (int)$frameId; ?>"
			 ng-hide="visibleAddLinkForm2">
			<?php echo $this->element('Links/change_order'); ?>
		</div>
		<div id="nc-links-add-link-modal-<?php echo (int)$frameId; ?>" class="ng-hide"
			 ng-show="visibleAddLinkForm2">

			<?php echo $this->element('Links/index_add_link', array('ngClick' => 'closeEditLink()')); ?>
		</div>
	</div>
	<div class="tab-pane" id="nc-links-category-editor-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Links/category_editor'); ?>
	</div>
	<div class="tab-pane" id="nc-links-display-style-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Links/display_style_setting'); ?>
	</div>
	<div class="tab-pane" id="nc-links-role-setting-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Links/authority_setting'); ?>
	</div>
	<div class="tab-pane disabled" id="nc-links-mail-setting-<?php echo (int)$frameId; ?>">
		<?php //echo $this->element('Links/notification_setting'); ?>
	</div>
</div>

