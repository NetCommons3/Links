<?php
/**
 * Bootstrap スタイルで表示されるようにしたFormHelper
 *
 * Created by PhpStorm.
 * User: ryuji
 * Date: 2014/08/31
 * Time: 10:00
 */
App::uses('FormHelper', 'View/Helper');

class LinksFormHelper extends FormHelper {

/**
 * Generate div options for input
 *
 * @param array $options options
 * @return array
 */
	protected function _divOptions($options) {
		if (!isset($options['div']['class'])) {
			$options['div']['class'] = '';
		}
		$options['div']['class'] .= 'form-group';
		return parent::_divOptions($options);
	}

/**
 * Generates an input element
 *
 * @param array $args The options for the input element
 * @return string The generated input element
 */
	protected function _getInput($args) {
		if (!isset($args['options']['class'])) {
			$args['options']['class'] = '';
		}
		$args['options']['class'] .= ' form-control';
		return parent::_getInput($args);
	}

}