<?php
/**
 * セキュリティコンポーネント回避用フォーム
 * CakePHPのFormヘルパで生成する必用あり
 * ここでhiddenになってる項目はフォームでの変更不可
 * ここに無い項目のPOSTも不可
 */
echo $this->Form->create(null);

echo $this->Form->input('LinkCategory.id', array(
		'type' => 'text',
	)
);


echo $this->Form->input('Frame.frame_id', array(
		'type' => 'hidden',
		'value' => (int)$frameId,
		'ng-model' => 'edit.data.Frame.frame_id'
	)
);


echo $this->Form->end();
