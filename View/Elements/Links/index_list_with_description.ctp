<?php
/**
 * 一覧表示(説明付き)タイプ表示Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php foreach ($categories as $category) : ?>
	<?php if (isset($links[$category['Category']['id']])) : ?>
		<article>
			<h2>
				<?php echo h($category['Category']['name']); ?>
			</h2>

			<ul class="list-group" style="<?php echo $linkFrameSetting['list_style_css']; ?>">
				<?php foreach ($links[$category['Category']['id']] as $link) : ?>
					<li class="list-group-item nc-links-li">
						<h3>
							<?php echo $this->element('Links.Links/link', array('link' => $link)); ?>
							<?php echo $this->element('Links.Links/edit_link', array('link' => $link)); ?>
						</h3>
						<div class="text-muted">
							<?php echo h($link['Link']['description']); ?>
						</div>
					</li>
				<?php endforeach; ?>

				<?php if (isset($linkFrameSetting['category_separator_line'])) : ?>
					<hr style="<?php echo $linkFrameSetting['category_separator_line_css']; ?>">
				<?php endif; ?>
			</ul>
		</article>
	<?php endif; ?>
<?php endforeach;
