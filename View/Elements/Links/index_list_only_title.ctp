<?php
/**
 * List only title type element of Links index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php foreach ($categories as $categoryId => $category) : ?>
	<?php if (isset($links[$categoryId])) : ?>
		<article>
			<h2>
				<?php echo h($category['category']['name']); ?>
			</h2>

			<ul class="list-group nc-links-list-style" style="<?php echo $linkFrameSetting['listStyleCss']; ?>">
				<?php foreach ($links[$categoryId] as $linkId => $link) : ?>
					<li class="list-group-item nc-links-li">
						<h3 class="nc-links-li-title">
							<?php echo $this->element('Links/link', array('link' => $link)); ?>
							<?php echo $this->element('Links/edit_link', array('link' => $link)); ?>
						</h3>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php if (isset($linkFrameSetting['categorySeparatorLine'])) : ?>
				<hr style="<?php echo $linkFrameSetting['categorySeparatorLineCss']; ?>">
			<?php endif; ?>
		</article>
	<?php endif; ?>
<?php endforeach;
