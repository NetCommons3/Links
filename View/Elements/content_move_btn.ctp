<?php
$moveParams = isset($moveParams) ? $moveParams : array('$index');
$paramNameString = implode(',', $moveParams);
?>
<?php if ($size) : ?>
<div class="text-left col-xs-<?php echo $size; ?>">
<?php endif; ?>
	<button ng-class="{disabled: $first }" class="btn btn-default btn-xs" ng-click="moveUp(<?php echo $paramNameString ?>)">
		<span class="glyphicon glyphicon-arrow-up"></span>
		<span class="hidden">up</span>
	</button>
	<button ng-class="{disabled: $last }" class="btn btn-default btn-xs" ng-click="moveDown(<?php echo $paramNameString ?>)">
		<span class="glyphicon glyphicon-arrow-down"></span>
		<span class="hidden">down</span>
	</button>

<?php if ($size) : ?>
</div>
<?php endif; ?>
