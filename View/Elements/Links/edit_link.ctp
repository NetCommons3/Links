<?php
/**
 * Element of link
 * - $link: A result data of Link->getLinks()
 * - $frameId: frames.id
 * - $userId: users.id
 * - $contentEditable: Content editable status
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$editUrl = $this->Html->url(array(
		'controller' => 'links',
		'action' => 'edit',
		$frameId,
		$link['link']['key']
	));
?>

<?php if ($contentEditable || $link['link']['createdUser'] === $userId) : ?>
	<a class="btn btn-xs btn-primary nc-links-edit-anchor" href="<?php echo $editUrl; ?>">
		<span class="glyphicon glyphicon-edit"> </span>
	</a>
<?php endif;
