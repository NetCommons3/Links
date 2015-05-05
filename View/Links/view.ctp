<?php
/**
 * Links view
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
	<div id="nc-links-<?php echo $frameId; ?>" class="nc-content-list">
		<article>
			<h1>
				<small><?php echo h($linkBlock['name']); ?></small>
			</h1>

			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group">
						<div>
							<?php echo $this->Form->label('Link.url', __d('links', 'URL') . $this->element('NetCommons.required')); ?>
						</div>
						<div>
							<a href="<?php echo h($link['url']); ?>">
								<?php echo h($link['url']); ?>
							</a>
						</div>
					</div>

					<div class="form-group">
						<div>
							<?php echo $this->Form->label('Link.title', __d('links', 'Title') . $this->element('NetCommons.required')); ?>
						</div>
						<div>
							<?php echo isset($link['title']) ? h($link['title']) : null ?>
						</div>
					</div>

					<?php if ($category['name']) : ?>
						<div class='form-group'>
							<div>
								<?php echo $this->Form->label('Link.category_id', __d('categories', 'Category')); ?>
							</div>
							<div>
								<?php echo h($category['name']); ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="form-group">
						<div>
							<?php echo $this->Form->label('Link.description', __d('links', 'Description')); ?>
						</div>
						<div>
							<?php echo isset($link['description']) ? h($link['description']) : null ?>
						</div>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>
