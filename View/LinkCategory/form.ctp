<?php

echo $this->Form->create(null);

echo $this->Form->input('LinkCategory.name', array(
		'type' => 'text',
			'value' => '',
		'ng-model' => 'edit.data.LinkCategory.name'
	)
);

//if ($contentPublishable) {
//	$options = array(
//		NetCommonsBlockComponent::STATUS_PUBLISHED,
//		NetCommonsBlockComponent::STATUS_DRAFTED,
//		NetCommonsBlockComponent::STATUS_DISAPPROVED,
//	);
//} else {
//	$options = array(
//		NetCommonsBlockComponent::STATUS_APPROVED,
//		NetCommonsBlockComponent::STATUS_DRAFTED,
//	);
//}
//echo $this->Form->input('Announcement.status', array(
//			'type' => 'select',
//			'options' => array_combine($options, $options)
//		)
//	);

//echo $this->element('AnnouncementEdit/common_form');
echo $this->Form->input('Frame.frame_id', array(
		'type' => 'hidden',
		'value' => (int)$frameId,
		'ng-model' => 'edit.data.Frame.frame_id'
	)
);

//echo $this->Form->input('LinkCategory.block_id', array(
//		'type' => 'hidden',
//		'value' => (int)$blockId,
//		'ng-model' => 'edit.data.LinkCategory.block_id',
//	)
//);

echo $this->Form->end();
