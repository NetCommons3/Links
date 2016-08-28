<?php
/**
 * リンク表示Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$attribute = '';
if ($link['Link']['status'] === WorkflowComponent::STATUS_PUBLISHED) {
	$attribute .= ' onclick="return false;" ng-click="clickLink($event, \'' . $link['Link']['id'] . '\', \'' . $link['Link']['key'] . '\')"';
}
if ($linkFrameSetting['open_new_tab']) {
	$attribute .= ' target="_blank"';
}
?>

<a <?php echo 'href="' . h($link['Link']['url']) . '"' . $attribute; ?>>
	<?php echo h($link['Link']['title']); ?>
</a>
<?php if ($linkFrameSetting['display_click_count']) : ?>
	<span class="badge" id="<?php echo 'nc-badge-' . Current::read('Frame.id') . '-' . $link['Link']['id']; ?>">
		<?php echo h($link['Link']['click_count']); ?>
	</span>
<?php endif; ?>

<?php
if ($this->request->params['action'] !== 'view') {
	echo $this->Workflow->label($link['Link']['status']);
}
