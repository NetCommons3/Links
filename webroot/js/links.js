/*
* 発生箇所 : プレビューを閉じる。
* 編集 閉じる 編集 --- で発生。
*
* */

NetCommonsApp.controller('Links',
    function($scope , $http, $sce, $timeout, dialogs, $modal) {

      $scope.LINK_ADD_URL = '/Links/Links/linkAdd/';
      $scope.PLUGIN_MANAGE_URL = '/Links/Links/manage/';

      $scope.frameId = 0;

      $scope.visibleHeaderBtn = true;
      $scope.visibleContainer = true;
      $scope.visibleManage = false;
      $scope.visibleAddLink = true;

      $scope.visibleContentList = false;
      $scope.visibleContentDropdown = true;

      $scope.visibleAddLinkForm = false;
      $scope.Form = {
        'link_url': '',
        'title': '',
        'description': ''
      };

      $scope.initialize = function(frameId, visibleContentList, visibleContentDropdown) {
        $scope.frameId = frameId;
        $scope.visibleContentList = visibleContentList;
        $scope.visibleContentDropdown = visibleContentDropdown;
      };

      $scope.showContainer = function() {
        $scope.visibleHeaderBtn = true;
        $scope.visibleContainer = true;
        $scope.visibleManage = false;
        $scope.visibleAddLink = true;
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
        $scope.Form.link_url = '';
        $scope.Form.title = '';
        $scope.Form.description = '';

        //リンク追加ダイアログ取得のURL
        var url = $scope.LINK_ADD_URL + $scope.frameId;
        //ダイアログで使用するJSコントローラ
        var controller = 'Links.linkAdd';

        $modal.open({
          templateUrl: url,
          controller: controller,
          backdrop: 'static',
          scope: $scope
        });
      };

      $scope.showManage = function(){
        $scope.visibleAddLinkForm = false;

        //管理モーダル取得のURL
        var url = $scope.PLUGIN_MANAGE_URL + $scope.frameId;
        //ダイアログで使用するJSコントローラ
        var controller = 'Links.edit';

        modal = $modal.open({
          templateUrl: url,
          controller: controller,
          backdrop: 'static',
          scope: $scope
        });
        modal.result.then(
          function(result) {
            // 表示方法変更設定時
            $scope.postDisplayStyle();
          },
          function(reason) {}
        );
      }

    });

NetCommonsApp.controller('Links.linkAdd',
    function($scope, $http, $sce, $modalInstance, $timeout, dialogs) {

      $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
      };

    });

NetCommonsApp.controller('Links.edit',
    function($scope, $http, $sce, $modalInstance, $timeout, dialogs) {

      $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
      };

      $scope.postDisplayStyle = function(){
        $modalInstance.close();
      };

      $scope.showEditLink = function(link_url, title, description) {
        $scope.visibleAddLinkForm = true;
        $scope.Form.link_url = link_url;
        $scope.Form.title = title;
        $scope.Form.description = description;
      };

      $scope.closeEditLink = function() {
        $scope.visibleAddLinkForm = false;
        $scope.Form.link_url = '';
        $scope.Form.title = '';
        $scope.Form.description = '';
      };

      $scope.deleteEditLink = function() {
        dlg = dialogs.confirm('Confirmation','リンクを削除してもよろしいですか？');
        dlg.result.then(
          function(btn){}, // Yes
          function(btn){}  // NO
        );
      };

      $scope.deleteEditCategory = function() {
        dlg = dialogs.confirm('Confirmation','カテゴリーを削除してもよろしいですか？');
        dlg.result.then(
          function(btn){}, // Yes
          function(btn){}  // NO
        );
      };
    });

