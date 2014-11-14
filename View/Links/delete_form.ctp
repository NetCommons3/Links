<?php
// 実際はjsonじゃないけどね。
echo $this->Form->create(null);

echo $this->Form->input('Link.id', array('type' => 'hidden', 'value' => $linkId));

echo $this->Form->input('Frame.frame_id', array(
		'type' => 'hidden',
		'value' => (int)$frameId,
	)
);


echo $this->Form->end();