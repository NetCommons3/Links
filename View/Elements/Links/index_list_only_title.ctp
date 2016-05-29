<?php
/**
 * 一覧表示タイプ表示Element
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
		<?php if (Hash::get($linkFrameSetting, 'category_separator_line')) : ?>
			<hr style="<?php echo $linkFrameSetting['category_separator_line_css']; ?>">
		<?php endif; ?>

		<article>
			<h2>
				<?php echo h($category['Category']['name']); ?>
			</h2>

			<ul class="list-group" style="<?php echo $linkFrameSetting['list_style_css']; ?>">
				<?php
					if ($linkFrameSetting['list_style']) {
						$listClass = ' nc-links-li';
					} else {
						$listClass = ' nc-links-li-none';
					}
				?>
				<?php foreach ($links[$category['Category']['id']] as $link) : ?>
					<li class="list-group-item<?php echo $listClass; ?>">
						<h3>
							<?php echo $this->element('Links.Links/link', array('link' => $link)); ?>
							<?php echo $this->element('Links.Links/edit_link', array('link' => $link)); ?>
						</h3>
					</li>
				<?php endforeach; ?>
			</ul>
		</article>
	<?php endif; ?>
<?php endforeach; ?>

<?php if (Hash::get($linkFrameSetting, 'category_separator_line')) : ?>
	<hr style="<?php echo $linkFrameSetting['category_separator_line_css']; ?>">
<?php endif;