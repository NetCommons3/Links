<?php
// 実際はjsonじゃないけどね。
echo $this->Form->create(null);

$fields = array(
	'Link.url',
	'Link.title',
	'Link.description',
	'Link.link_category_id',
	'Link.status'
);
foreach($fields as $field){
echo 	$this->Form->input($field, array('type' => 'text'));
}

echo $this->Form->input('Frame.frame_id', array(
		'type' => 'hidden',
		'value' => (int)$frameId,
	)
);


echo $this->Form->end();