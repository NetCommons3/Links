<?php
/**
 * リンク編集
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsHtml->script('/links/js/links.js'); ?>

<div class="nc-content-list" ng-controller="LinksEdit">
	<?php echo $this->NetCommonsHtml->blockTitle($linkBlock['name']); ?>

	<article>
		<div class="panel panel-default">
			<?php echo $this->NetCommonsForm->create('Link'); ?>
				<div class="panel-body">
					<?php echo $this->element('Links/edit_form'); ?>

					<hr />

					<?php echo $this->Workflow->inputComment('Link.status'); ?>
				</div>

			<?php echo $this->Workflow->buttons('Link.status'); ?>

			<?php echo $this->NetCommonsForm->end(); ?>

			<?php if ($this->request->params['action'] === 'edit' && $this->Workflow->canDelete('Link', $this->data)) : ?>
				<div class="panel-footer text-right">
					<?php echo $this->element('Links/delete_form'); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php echo $this->Workflow->comments(); ?>
	</article>
</div>
