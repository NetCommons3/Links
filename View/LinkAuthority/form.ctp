<?php
echo $this->Form->create(null);

foreach($rolePermission as $roleKey => $permission){
	echo $this->Form->input('add_link.'.$roleKey.'.name');
	echo $this->Form->chekcbox('add_link.'.$roleKey.'.permission');
}


echo $this->Form->input('Frame.frame_id', array(
		'type' => 'hidden',
		'value' => (int)$frameId,
	)
);


echo $this->Form->end();