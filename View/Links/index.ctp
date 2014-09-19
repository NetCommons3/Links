<?php echo $this->Html->script('/links/js/links.js'); ?>

<div id="nc-links-modal-<?php echo (int)$frameId; ?>" class="modal fade">
	<?php echo $this->element('Links/index_link_add'); ?>
</div>

<div id="nc-links-container-<?php echo (int)$frameId; ?>"
	 ng-controller="Links"
	 ng-init="initialize(<?php echo (int)$frameId; ?>)">

	<div class="row">
		<?php echo $this->element('Links/header_button'); ?>
	</div>

		<br />

	<div id="nc-links-container-<?php echo (int)$frameId; ?>" class="row"
		 ng-show="visibleContainer">

		<?php echo $this->element('Links/' . $type); ?>

	</div>


	<div id="nc-links-edit-<?php echo (int)$frameId; ?>" class="row ng-hide"
		 ng-show="visibleEdit">

		<?php echo $this->element('Links/index_edit'); ?>

	</div>


	<div id="nc-links-manage-<?php echo (int)$frameId; ?>" class="row ng-hide"
		 ng-show="visibleManage">

		<?php echo $this->element('Links/index_manage'); ?>

	</div>
</div>

