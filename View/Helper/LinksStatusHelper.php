<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 2014/10/29
 * Time: 9:41
 */
// MyTodo 多言語対応
// MyTodo テスト実装
class LinksStatusHelper extends AppHelper{
	public function view($status){

		switch($status){
			case NetCommonsBlockComponent::STATUS_PUBLISHED:
				$ret = '';
				break;
			case NetCommonsBlockComponent::STATUS_APPROVED:
				$ret = '<span class="label label-danger">申請中</span>';
				break;
			case NetCommonsBlockComponent::STATUS_DISAPPROVED:
				$ret = '<span class="label label-warning">差し戻し</span>';
				break;
			case NetCommonsBlockComponent::STATUS_DRAFTED:
				$ret = '<span class="label label-info">下書き</span>';
				break;
			default:
				$ret = '';

		}
		return $ret;
	}
}