
<div class="modal-header">
	<button class="close" type="button"
			tooltip="<?php echo __d('links', 'Close'); ?>"
			ng-click="cancel()">
		<span class="glyphicon glyphicon-remove small"></span>
	</button>
	<h4 id="myModalLabel" class="modal-title">
		リンク追加
	</h4>
</div>
<div class="modal-body">
	<?php echo $this->element('Links/index_add_link', array('ngClick' => 'cancel()')); ?>
</div>
