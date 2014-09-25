<?php echo $this->Html->script('/links/js/links.js'); ?>

<div id="nc-links-add-link-modal-<?php echo (int)$frameId; ?>" class="modal fade">
	<div class="ng-scope">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">×</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 id="myModalLabel" class="modal-title">
						リンク追加
					</h4>
				</div>
				<div class="modal-body">
					<?php echo $this->element('Links/index_add_link'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="nc-links-add-category-modal-<?php echo (int)$frameId; ?>" class="modal fade">
	<?php echo $this->element('Links/index_add_category'); ?>
</div>


<?php
	$listDisplay = 'ng-hide';
	$dropdownDisplay = 'ng-hide';
	if ($type === 'list') {
		$listDisplay = '';
	}
	if ($type === 'dropdown') {
		$dropdownDisplay = '';
	}
?>

<div id="nc-links-container-<?php echo (int)$frameId; ?>"
	 ng-controller="Links"
	 ng-init="initialize(<?php echo (int)$frameId; ?>,
						<?php echo ($listDisplay === '' ? "true" : "false"); ?>,
						<?php echo ($dropdownDisplay === '' ? "true" : "false"); ?>)">


	<div id="nc-links-manage-modal-<?php echo (int)$frameId; ?>" class="modal fade">
		<div class="ng-scope">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">
							<span aria-hidden="true">×</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 id="myModalLabel" class="modal-title">
							編集
						</h4>
					</div>
					<div class="modal-body">
						<?php echo $this->element('Links/index_manage'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row"
		 ng-show="visibleHeaderBtn">
		<?php echo $this->element('Links/header_button'); ?>
	</div>

		<br />

	<div id="nc-links-container-<?php echo (int)$frameId; ?>" class="row"
		 ng-show="visibleContainer">


		<div class="<?php echo $listDisplay; ?>" ng-show="visibleContentList">
			<?php echo $this->element('Links/list'); ?>
		</div>

		<div class="<?php echo $dropdownDisplay; ?>" ng-show="visibleContentDropdown">
			<?php echo $this->element('Links/dropdown'); ?>
		</div>

	</div>


	<div id="nc-links-add-link-<?php echo (int)$frameId; ?>" class="ng-hide"
		 ng-show="visibleAddLinkForm">
		<?php echo $this->element('Links/index_add_link'); ?>
	</div>

	<div id="nc-links-edit-<?php echo (int)$frameId; ?>" class="ng-hide"
		 ng-show="visibleEdit">

		<?php echo $this->element('Links/index_edit'); ?>

	</div>


	<div id="nc-links-manage-<?php echo (int)$frameId; ?>" class="ng-hide"
		 ng-show="visibleManage">

		<?php echo $this->element('Links/index_manage'); ?>

	</div>
</div>
