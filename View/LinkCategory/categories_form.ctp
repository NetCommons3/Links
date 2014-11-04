<?php
/**
 * セキュリティコンポーネント回避用フォーム
 * CakePHPのFormヘルパで生成する必用あり
 * ここでhiddenになってる項目はフォームでの変更不可
 * ここに無い項目のPOSTも不可
 */
echo $this->Form->create(null);

$count = 0;

//$linkCategories = array_fill(0, 7, array());

foreach($linkCategories as $linkCategory){
	echo $this->Form->input(sprintf('LinkCategories.%d.LinkCategory.id', $count), array(
			'type' => 'text',
			'value' => $linkCategory['LinkCategory']['id']
		)
	);
	echo $this->Form->input(sprintf('LinkCategories.%d.LinkCategory.name', $count), array(
			'type' => 'text',
		)
	);
	echo $this->Form->input(sprintf('LinkCategories.%d.LinkCategoryOrder.id', $count), array(
			'type' => 'text',
			'value' => $linkCategory['LinkCategoryOrder']['id']
		)
	);
	echo $this->Form->input(sprintf('LinkCategories.%d.LinkCategoryOrder.weight', $count), array(
			'type' => 'text',
		)
	);

$count++;
}

echo $this->Form->input('Frame.frame_id', array(
		'type' => 'hidden',
		'value' => (int)$frameId,
		'ng-model' => 'edit.data.Frame.frame_id'
	)
);


echo $this->Form->end();
