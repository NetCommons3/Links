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

        /**
         * edit _method
         *
         * @type {Object.<string>}
         */
        $scope.edit = {
            _method: 'POST'
        };

        /**
         * edit data
         *
         * @type {Object.<string>}
         */
        $scope.edit.data = {
            LinkCategory: {
//                name: $scope.link.LinkCategory.name,
                name: ''
//                content: $scope.announcement.Announcement.content,
//                status: $scope.announcement.Announcement.status,
//                block_id: $scope.announcement.Announcement.block_id,
//                key: $scope.announcement.Announcement.key,
//                id: $scope.announcement.Announcement.id
            },
            Frame: {
                frame_id: $scope.frameId//フレームIDが不一致かーーーーー
            },
            _Token: {
                key: '',
                fields: '',
                unlocked: ''
            }
        };

        $scope.editCategories= {
            _method: 'POST'
        };

        $scope.editCategories.data = {
            LinkCategories:[],
//            LinkCategory:[],
//            LinkCategoryOrder:[],
            Frame: {
                frame_id: $scope.frameId//フレームIDが不一致かーーーーー
            },
            _Token: {
                key: '',
                fields: '',
                unlocked: ''
            }
        };


        $scope.initialize = function(frameId, linkCategories) {
            $scope.frameId = frameId;
            angular.forEach(linkCategories, function(oneRecord){
                $scope.editCategories.data.LinkCategories.push(
                    {
                        LinkCategory: {
                            id: oneRecord.LinkCategory.id,
                            name: oneRecord.LinkCategory.name
                        },
                        LinkCategoryOrder:{
                            id:oneRecord.LinkCategoryOrder.id,
                            weight:oneRecord.LinkCategoryOrder.weight

                        }
                    }
                )
//                $scope.editCategories.data.LinkCategories.push(oneRecord)
//                $scope.editCategories.data.LinkCategory.push(
//                    {
//                        id: oneRecord.LinkCategory.id,
//                        name: oneRecord.LinkCategory.name
//                    }
//                );
//                $scope.editCategories.data.LinkCategoryOrder.push(
//                    {
//                        id:oneRecord.LinkCategoryOrder.id,
//                        weight:oneRecord.LinkCategoryOrder.weight
//                    }
//                );
            });
//            $scope.editCategories.data.LinkCategories = linkCategories;
            console.log($scope.editCategories.data.LinkCategories);
        };



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



        /**
         * dialog save
         *
         * @return {void}
         */
        $scope.addCategory = function() {
            $scope.sending = true;

            $http.get('/links/link_category/form/' +
                    $scope.frameId + '/' + Math.random() + '.json')
                .success(function(data) {
                    //フォームエレメント生成
                    var form = $('<div>').html(data);

                    //セキュリティキーセット
                    $scope.edit.data._Token.key =
                        $(form).find('input[name="data[_Token][key]"]').val();
                    $scope.edit.data._Token.fields =
                        $(form).find('input[name="data[_Token][fields]"]').val();
                    $scope.edit.data._Token.unlocked =
                        $(form).find('input[name="data[_Token][unlocked]"]').val();
                    //ステータスセット
//                    $scope.edit.data.Announcement.status = status;
                    //登録情報をPOST
                    $scope.sendCategoryPost($scope.edit);
                })
                .error(function(data, status) {
                    //keyの取得に失敗
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });
        };

        /**
         * send post
         *
         * @param {Object.<string>} postParams
         * @return {void}
         */
        $scope.sendCategoryPost = function(postParams) {
            //$http.post($scope.PLUGIN_EDIT_URL + Math.random() + '.json',
            $http.post('/links/link_category/add/' +
                $scope.frameId + '/' + Math.random() + '.json',
                //$.param(postParams))
                //{data: postParams})
                //postParams)
                $.param(postParams),
                {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                .success(function(data) {
                    $scope.flash.success(data.name);
                    // MyTodo カテゴリ追加し終わったらカテゴリ一覧をリロードしたいよなぁ
//                    $modalInstance.close(data.announcement); 
                })
                .error(function(data, status) {
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });
        };
        /**
         * dialog save
         *
         * @return {void}
         */
        $scope.updateCategories = function() {
            $scope.sending = true;

            $http.get('/links/link_category/categories_form/' +
                    $scope.frameId + '/' + Math.random() + '.json')
                .success(function(data) {
                    //フォームエレメント生成
                    var form = $('<div>').html(data);

                    //セキュリティキーセット
                    $scope.editCategories.data._Token.key =
                        $(form).find('input[name="data[_Token][key]"]').val();
                    $scope.editCategories.data._Token.fields =
                        $(form).find('input[name="data[_Token][fields]"]').val();
                    $scope.editCategories.data._Token.unlocked =
                        $(form).find('input[name="data[_Token][unlocked]"]').val();

                    //ステータスセット
//                    $scope.edit.data.Announcement.status = status;
                    //登録情報をPOST
                    $scope.sendCategoriesPost($scope.editCategories);
                })
                .error(function(data, status) {
                    //keyの取得に失敗
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });
        };

        /**
         * send post
         *
         * @param {Object.<string>} postParams
         * @return {void}
         */
        $scope.sendCategoriesPost = function(postParams) {
            //$http.post($scope.PLUGIN_EDIT_URL + Math.random() + '.json',
            postParams = angular.fromJson(angular.toJson(postParams)); // hashに$$hashKeyがつくのでこれで除去してる
console.log(postParams);
            $http.post('/links/link_category/update_all/' +
                $scope.frameId + '/' + Math.random() + '.json',
                //$.param(postParams))
                //{data: postParams})
                //postParams)
                $.param(postParams),
                {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                .success(function(data) {
                    $scope.flash.success(data.name);
                    $modalInstance.close(); //
                })
                .error(function(data, status) {
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });
        };

        var move = function (origin, destination) {
            var temp = $scope.editCategories.data.LinkCategories[destination];
            $scope.editCategories.data.LinkCategories[destination] = $scope.editCategories.data.LinkCategories[origin];
            $scope.editCategories.data.LinkCategories[origin] = temp;
            //  weight入れ換え
            var tempWeight = $scope.editCategories.data.LinkCategories[destination].LinkCategoryOrder.weight;
            $scope.editCategories.data.LinkCategories[destination].LinkCategoryOrder.weight = $scope.editCategories.data.LinkCategories[origin].LinkCategoryOrder.weight;
            $scope.editCategories.data.LinkCategories[origin].LinkCategoryOrder.weight = tempWeight;

        };

        $scope.moveUp = function(index){
            move(index, index - 1);
        };

        $scope.moveDown = function(index){
            move(index, index + 1);
        };

    }




);

