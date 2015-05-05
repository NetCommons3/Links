<?php
/**
 * Element of link
 * - $link: A result data of Link->getLinks()
 * - $linkFrameSetting: A result data of LinkFrameSetting->getLinkFrameSetting()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<a href="<?php echo h($link['link']['url']); ?>" onclick="return false;"
   <?php echo $link['link']['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED ?
			'ng-click="clickLink($event, \'' . $link['link']['id'] . '\', \'' . $link['link']['key'] . '\')"' : ''; ?>
   <?php echo $linkFrameSetting['openNewTab'] ? 'target="_blank"' : '' ?>>

	<?php echo h($link['link']['title']); ?>
</a>
<?php if ($linkFrameSetting['displayClickCount']) : ?>
	<span class="badge" id="<?php echo 'nc-badge-' . $frameId . '-' . $link['link']['id']; ?>">
		<?php echo h($link['link']['clickCount']); ?>
	</span>
<?php endif; ?>

<small>
	<?php echo $this->element('NetCommons.status_label',
			array('status' => $link['link']['status'])); ?>
</small>
