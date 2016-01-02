<?php
/**
 * リンク詳細
 * 新着・検索等で使用する
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsHtml->script('/links/js/links.js'); ?>

<div class="nc-content-list">
	<article>
		<div class="clearfix">
			<h1 class="pull-left">
				<small><?php echo h($linkBlock['name']); ?></small>
			</h1>
			<div class="pull-right h1">
				<?php if ($this->Workflow->canEdit('Links.Link', $link)) : ?>
					<?php echo $this->LinkButton->edit('', array('key' => $link['Link']['key']), array('tooltip' => true)); ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-body">
				<div class="form-group">
					<div>
						<?php echo $this->NetCommonsForm->label('Link.url', __d('links', 'URL') . $this->element('NetCommons.required')); ?>
					</div>
					<div class="form-control nc-data-label">
						<a href="<?php echo h($link['Link']['url']); ?>">
							<?php echo h($link['Link']['url']); ?>
						</a>
					</div>
				</div>

				<div class="form-group">
					<div>
						<?php echo $this->NetCommonsForm->label('Link.title', __d('links', 'Title') . $this->element('NetCommons.required')); ?>
					</div>
					<div class="form-control nc-data-label">
						<?php echo isset($link['Link']['title']) ? h($link['Link']['title']) : null ?>
					</div>
				</div>

				<?php if (Hash::get($category, 'name')) : ?>
					<div class='form-group'>
						<div>
							<?php echo $this->NetCommonsForm->label('Link.category_id', __d('categories', 'Category')); ?>
						</div>
						<div class="form-control nc-data-label">
							<?php echo h(Hash::get($category, 'name')); ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="form-group">
					<div>
						<?php echo $this->NetCommonsForm->label('Link.description', __d('links', 'Description')); ?>
					</div>
					<div class="form-control nc-data-label">
						<?php echo isset($link['Link']['description']) ? h($link['Link']['description']) : null ?>
					</div>
				</div>
			</div>
		</div>
	</article>
</div>
