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

      $scope.htmlManage = '';
      $scope.visibleManage = false;

      $scope.htmlEdit = '';
      $scope.visibleEdit = false;

      $scope.htmlAddLink = '';
      $scope.visibleAddLink = true;

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
        $scope.visibleHeaderBtn = true;
        $scope.visibleContainer = false;
        $scope.visibleEdit = false;
        $scope.visibleManage = true;
        $scope.visibleAddLink = false;
        $scope.visibleAddLinkForm = false;
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
        //$('#nc-links-add-link-modal-' + $scope.frameId).modal('show');

        $scope.visibleContainer = false;
        $scope.visibleEdit = false;
        $scope.visibleManage = false;
        $scope.visibleAddLink = false;

        $scope.visibleAddLinkForm = true;
        $scope.visibleHeaderBtn = false;
      };

      $scope.showAddCategory = function() {
        //$('#nc-links-add-link-modal-' + $scope.frameId).dismiss();
        $('#nc-links-add-category-modal-' + $scope.frameId).modal('show');
      };

    });
