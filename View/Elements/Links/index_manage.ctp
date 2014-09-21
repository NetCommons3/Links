
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
		<!-- Nav tabs -->
		<ul class="nav navbar-nav" role="tablist">
			<li class="small active">
				<a href="#nc-links-change-order-move-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					表示順変更
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
			<li class="small">
				<a href="#nc-links-mail-setting-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					メール設定
				</a>
			</li>
		</ul>
	</div>
</nav>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="nc-links-change-order-move-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Links/change_order'); ?>
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
	<div class="tab-pane" id="nc-links-mail-setting-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Links/notification_setting'); ?>
	</div>
</div>

