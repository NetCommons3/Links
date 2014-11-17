<?php echo $this->Html->script('/links/js/links.js?'.time()); ?>

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

	<div class="row" ng-show="visibleHeaderBtn">
		<?php echo $this->element('Links/header_button'); ?>
	</div>

	<br />

	<div id="nc-links-container-<?php echo (int)$frameId; ?>"
		 class="row"
		 ng-show="visibleContainer">

		<div class="<?php echo $listDisplay; ?>" ng-show="visibleContentList">
			<?php echo $this->element('Links/list'); ?>
		</div>

		<div class="<?php echo $dropdownDisplay; ?>" ng-show="visibleContentDropdown">
			<?php echo $this->element('Links/dropdown'); ?>
		</div>

	</div>

</div>
