<?php
/**
 * Dropdownタイプ表示Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="btn-group nc-input-dropdown links-index-dropdown">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<div class="clearfix">
			<div class="pull-left">
				<?php
					if (isset($linkBlock['name'])) {
						echo $linkBlock['name'];
					} else {
						echo __d('links', 'Select link to show');
					}
				?>
			</div>
			<div class="pull-right">
				<span class="caret"> </span>
			</div>
		</div>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li class="divider"> </li>
		<?php if ($links) : ?>
			<?php foreach ($categories as $category) : ?>
				<?php if (isset($links[$category['Category']['id']])) : ?>
					<?php if (isset($category['CategoriesLanguage']['name'])) : ?>
						<li>
							<span class="nc-dropdown-block">
								<strong><?php echo h($category['CategoriesLanguage']['name']); ?></strong>
							</span>
						</li>
					<?php endif; ?>

					<?php foreach ($links[$category['Category']['id']] as $link) : ?>
						<li>
							<div class="nc-dropdown-block">
								<?php echo $this->element('Links.Links/link', array('link' => $link)); ?>
								<?php echo $this->element('Links.Links/edit_link', array('link' => $link)); ?>
							</div>
						</li>
					<?php endforeach; ?>

					<li class="divider"> </li>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<li>
				<span class="nc-dropdown-block">
					<?php echo __d('links', 'No link found.'); ?></li>
				</span>
		<?php endif; ?>
	</ul>
</div>
