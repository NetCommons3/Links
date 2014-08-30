<?php echo $this->Html->script('/links/js/links.js'); ?>
<div ng-controller="Links">

<?php
echo $this->element('header_buttons');
echo $this->element('link_list');
?>
</div>
