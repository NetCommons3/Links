<?php
$upDisabled = isset($upDisabled) ? $upDisabled : false;
$downDisabled = isset($downDisabled) ? $downDisabled : false;
?>
<?php if ($size) : ?>
<div class="text-left col-xs-<?php echo $size; ?>">
<?php endif; ?>
	<button class="btn btn-default btn-xs<?php echo ($upDisabled ? ' disabled' : ''); ?>">
		<span class="glyphicon glyphicon-arrow-up"></span>
		<span class="hidden">up</span>
	</button>
	<button class="btn btn-default btn-xs<?php echo ($downDisabled ? ' disabled' : ''); ?>">
		<span class="glyphicon glyphicon-arrow-down"></span>
		<span class="hidden">down</span>
	</button>

<?php if ($size) : ?>
</div>
<?php endif; ?>
