/*
* 発生箇所 : プレビューを閉じる。
* 編集 閉じる 編集 --- で発生。
*
* */

NetCommonsApp.controller('Links',
    function($scope , $http, $sce, $timeout) {

      var GET_FORM_URL = '/links/links/';
      $scope.frameId = 0;

      $scope.visibleContainer = true;
      $scope.visibleContentList = false;
      $scope.visibleContentDropdown = true;
      $scope.visibleHeaderBtn = true;
      $scope.visibleAddLink = false;
      $scope.visibleAddLinkForm = false;
      $scope.visibleAddLinkForm2 = false;

      $scope.htmlManage = '';
      $scope.visibleManage = false;

      $scope.htmlEdit = '';
      $scope.visibleEdit = false;

      $scope.htmlAddLink = '';
      $scope.visibleAddLink = true;

      $scope.Form = {
        'link_url': '',
        'title': '',
        'description': ''
      };


      $scope.initialize = function(frameId, visibleContentList, visibleContentDropdown) {
      //$scope.initialize = function(frameId) {
        $scope.frameId = frameId;
        $scope.visibleContentList = visibleContentList;
        $scope.visibleContentDropdown = visibleContentDropdown;
      };

      $scope.showContainer = function() {
        $scope.visibleHeaderBtn = true;
        $scope.visibleContainer = true;
        $scope.visibleEdit = false;
        $scope.visibleManage = false;
        $scope.visibleAddLink = true;
        $scope.visibleAddLinkForm = false;
      };

      $scope.showEdit = function() {
        $scope.visibleHeaderBtn = true;
        $scope.visibleContainer = false;
        $scope.visibleEdit = true;
        $scope.visibleManage = false;
        $scope.visibleAddLink = true;
        $scope.visibleAddLinkForm = false;
      };

      $scope.showManage = function() {
        $('#nc-links-manage-modal-' + $scope.frameId).modal('show');
//        $scope.visibleHeaderBtn = true;
//        $scope.visibleContainer = false;
//        $scope.visibleEdit = false;
//        $scope.visibleManage = true;
//        $scope.visibleAddLink = false;
//        $scope.visibleAddLinkForm = false;
          $scope.visibleAddLinkForm2 = false;
      };

      $scope.postDisplayStyle = function() {
        if ($scope.visibleContentList === true) {
          $scope.visibleContentList = false;
          $scope.visibleContentDropdown = true;
       } else {
          $scope.visibleContentList = true;
          $scope.visibleContentDropdown = false;
       }
       $scope.showContainer();
      };

      $scope.showAddLink = function() {
        $('#nc-links-add-link-modal-' + $scope.frameId).modal('show');

//        $scope.visibleContainer = false;
//        $scope.visibleEdit = false;
//        $scope.visibleManage = false;
//        $scope.visibleAddLink = false;
//
//        $scope.visibleAddLinkForm = true;
//        $scope.visibleHeaderBtn = false;

        $scope.Form.link_url = '';
        $scope.Form.title = '';
        $scope.Form.description = '';
      };

      $scope.showEditLink = function(link_url, title, description) {
        $scope.Form.link_url = link_url;
        $scope.Form.title = title;
        $scope.Form.description = description;
        $scope.visibleAddLinkForm2 = true;
      };

      $scope.deleteEditLink = function() {
        return confirm('リンクを削除してもよろしいですか？');
      };

      $scope.deleteEditCategory = function() {
        return confirm('カテゴリーを削除してもよろしいですか？');
      };

      $scope.closeEditLink = function() {
        $scope.visibleAddLinkForm2 = false;
        $scope.Form.link_url = '';
        $scope.Form.title = '';
        $scope.Form.description = '';
      };

      $scope.showAddCategory = function() {
        //$('#nc-links-add-link-modal-' + $scope.frameId).dismiss();
        $('#nc-links-add-category-modal-' + $scope.frameId).modal('show');
      };

    });
