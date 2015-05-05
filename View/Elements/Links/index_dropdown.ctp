<?php
/**
 * Dropdown type element of Links index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="btn-group nc-input-dropdown">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<div class="clearfix">
			<div class="pull-left">
				<?php echo __d('links', 'Select link to show'); ?>
			</div>
			<div class="pull-right">
				<span class="caret"> </span>
			</div>
		</div>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li class="divider"> </li>

		<?php foreach ($categories as $categoryId => $category) : ?>
			<?php if (isset($links[$categoryId])) : ?>
				<?php if (isset($category['category']['name'])) : ?>
					<li>
						<span class="nc-dropdown-block">
							<strong><?php echo h($category['category']['name']); ?></strong>
						</span>
					</li>
				<?php endif; ?>

				<?php foreach ($links[$categoryId] as $linkId => $link) : ?>
					<li>
						<div class="nc-dropdown-block">
							<?php echo $this->element('Links/link', array('link' => $link)); ?>
							<?php echo $this->element('Links/edit_link', array('link' => $link)); ?>
						</div>
					</li>
				<?php endforeach; ?>

				<li class="divider"> </li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
