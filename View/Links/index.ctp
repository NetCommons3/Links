<?php
/**
 * リンク一覧
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$this->request->data = array(
	'Frame' => array(
		'id' => Current::read('Frame.id')
	),
	'Block' => array(
		'id' => Current::read('Block.id')
	),
	'Link' => array(
		'id' => null,
		'key' => null,
	),
);
$tokenFields = Hash::flatten($this->request->data);
$hiddenFields = array('Frame.id', 'Block.id');

$this->Token->unlockField('Link.id');
$tokens = $this->Token->getToken('Link',
	$this->NetCommonsHtml->url('/links/links/link.json'),
	$tokenFields,
	$hiddenFields
);

echo $this->NetCommonsHtml->css('/links/css/style.css');
echo $this->NetCommonsHtml->script('/links/js/links.js');

$displayType = Hash::get($linkFrameSetting, 'display_type');
?>

<div class="nc-content-list" ng-controller="LinksIndex"
	 ng-init="initialize(<?php echo h(json_encode(Hash::merge($this->request->data, $tokens))); ?>)">

	<article>
		<div class="clearfix">
			<?php if ($displayType !== LinkFrameSetting::TYPE_DROPDOWN) : ?>
				<h1 class="pull-left">
					<small>
						<?php echo h(Hash::get($linkBlock, 'name', '')); ?>
					</small>
				</h1>
			<?php endif; ?>

			<div class="pull-right h1">
				<?php if (Current::permission('content_editable') && $links) : ?>
					<?php echo $this->LinkButton->sort('',
							$this->NetCommonsHtml->url(array('controller' => 'link_orders', 'action' => 'edit'))
						); ?>
				<?php endif; ?>

				<?php echo $this->Workflow->addLinkButton('', null, array('tooltip' => __d('links', 'Create link'))); ?>
			</div>
		</div>

		<?php
			if ($displayType === LinkFrameSetting::TYPE_DROPDOWN) {
				echo $this->element('Links/index_dropdown');

			} elseif ($displayType === LinkFrameSetting::TYPE_LIST_ONLY_TITLE) {
				echo $this->element('Links/index_list_only_title');

			} elseif ($displayType === LinkFrameSetting::TYPE_LIST_WITH_DESCRIPTION) {
				echo $this->element('Links/index_list_with_description');
			}
		?>
	</article>
</div>
