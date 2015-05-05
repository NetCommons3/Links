<?php
/**
 * Links edit
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/links/js/links.js', false); ?>

<div class="frame">
	<div id="nc-links-<?php echo $frameId; ?>" class="nc-content-list"
		 ng-controller="LinksEdit"
		 ng-init="initialize(<?php echo h(json_encode(array(
				'action' => $this->params['action'], 'frameId' => $frameId, 'link' => $link
			))); ?>)">

		<article>
			<h1>
				<small><?php echo h($linkBlock['name']); ?></small>
			</h1>

			<div class="panel panel-default">
				<?php echo $this->Form->create('Link', array('novalidate' => true)); ?>
					<div class="panel-body">

						<?php echo $this->element('Links/edit_form'); ?>

						<hr />

						<?php echo $this->element('Comments.form'); ?>

					</div>
					<div class="panel-footer text-center">
						<?php echo $this->element('NetCommons.workflow_buttons'); ?>
					</div>
				<?php echo $this->Form->end(); ?>

				<?php if ($this->request->params['action'] === 'edit') : ?>
					<div class="panel-footer text-right">
						<?php echo $this->element('Links/delete_form'); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php echo $this->element('Comments.index'); ?>
		</article>
	</div>
</div>
