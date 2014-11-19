<?php
/**
 * LinkFrameSetting Model
 *
 *
* @author   Ryuji AMANO <ryuji@ryus.co.jp>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * Summary for LinkFrameSetting Model
 */
class LinkFrameSetting extends LinksAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'frame_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'display_type' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'open_new_tab' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'display_click_number' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function getByFrameId($frameId) {
		$this->Frame = ClassRegistry::init('Frames.Frame');
		$frame = $this->Frame->findById($frameId);
		$frameKey = $frame['Frame']['key'];
		$linkFrameSetting = $this->findByFrameKey($frameKey);

		if($linkFrameSetting){
			return $linkFrameSetting;
		}else{
			$newLinkFrameSetting =  $this->getBlank();
			$newLinkFrameSetting['LinkFrameSetting']['frame_key'] = $frameKey;
			return $newLinkFrameSetting;
		}
	}

	private function getBlank() {
		$defaults = array();

		$schema = (array)$this->schema();
		foreach ($schema as $field => $properties) {
			if ($this->primaryKey !== $field && isset($properties['default']) && $properties['default'] !== '') {
				$defaults[$field] = $properties['default'];
			}else{
				$defaults[$field] = null;
			}
		}
		$ret = array(
			$this->alias => $defaults
		);
		return $ret;
	}
}
