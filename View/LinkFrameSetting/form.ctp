<?php
echo $this->Form->create(null);

echo $this->Form->input('LinkFrameSetting.id', array('type'=>'hidden', 'value' => $linkFrameSetting['LinkFrameSetting']['id']));
echo $this->Form->input('LinkFrameSetting.frame_key', array('type'=>'hidden', 'value' => $linkFrameSetting['LinkFrameSetting']['frame_key']));

echo $this->Form->input('LinkFrameSetting.display_type', array('options' => array(0,1,2))); // MyTodo fix Magic Number
echo $this->Form->chekcbox('LinkFrameSetting.open_new_tab');
echo $this->Form->chekcbox('LinkFrameSetting.display_click_number');
echo $this->Form->input('LinkFrameSetting.category_separator_line');
echo $this->Form->input('LinkFrameSetting.list_style');

echo $this->Form->input('Frame.frame_id', array(
		'type' => 'hidden',
		'value' => (int)$frameId,
	)
);


echo $this->Form->end();