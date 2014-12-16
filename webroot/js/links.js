/*
 * 発生箇所 : プレビューを閉じる。
 * 編集 閉じる 編集 --- で発生。
 *
 * */
function Links_boolean2intInArray(arrayVar){
    for(var key in arrayVar){
        if(arrayVar[key] instanceof Array || arrayVar[key] instanceof Object){
            arguments.callee(arrayVar[key]);
        }else if(arrayVar[key] === true){
            arrayVar[key] = 1;
        }else if(arrayVar[key] === false){
            arrayVar[key] = 0;
        }
    }
    return arrayVar;

}
//NetCommonsApp.filter('Links_statusView', function() {
//
//    return function(status) {
//        status = Number(status);
//        switch(status){
//            case 1: // 公開
//                return '';
//                break;
//            case 2: // 申請
//                return '<span class="label label-danger">申請中</span>';
//                break;
//            case 3: // 下書き
//                return '<span class="label label-info">下書き</span>';
//                break;
//            case 4: // 差し戻し
//                return '<span class="label label-warning">差し戻し</span>';
//                break;
//        }
//    }
//});
//NetCommonsApp.config(['$resourceProvider', function($resourceProvider) {
//    // Don't strip trailing slashes from calculated URLs
////    $resourceProvider.defaults.stripTrailingSlashes = false;
//}]);

NetCommonsApp.factory('Links_getSiteInfo',  ['$http', '$q', function ($http, $q){
    var getSiteInfo = function (url, successCallBack, errorCallBack){
        $.ajax({
            type: "GET",
            url: url,
            dataType: "html",
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);

                    // 通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、
                    // 単純に通信に失敗した際の処理を記述します。
//                    this; // thisは他のコールバック関数同様にAJAX通信時のオプションを示します。
                },
                success:function(data, dataType){
                    console.log(data);
                    console.log(dataType);
                    // dataの値を用いて、通信成功時の処理を記述します。
//                    this; // thisはAJAX送信時に設定したオプションです
                }

        });

//        $http({
//            url: url,
//            method: 'get',
//            withCredentials: true
//        })
//            .success(function(data){
//                var siteHtml = $('<html />').html(data);
//                var title = $(siteHtml).find('title').innerText();
//                var description = $(siteHtml).find('meta[name=description]').innerText();
//                console.log(title);
//                console.log(description);
//                successCallBack(title, description);
//
//            }).error(function(data, status){
//                errorCallBack(data, status);
//
//            })
    }
    return getSiteInfo;

}]);

NetCommonsApp.factory('Links_ajaxPostService', ['$http', '$q', function ($http, $q) {
    // ここのスコープは１度しか実行されない
//    var success = function (){
//
//    };
//    var error = function (){
//
//    }
    var send = function (postData, formUrl, postUrl) {
        var deferred = $q.defer();
        var promise = deferred.promise;


        // jsonで返さないんだから、.jsonつけなきゃいい？
        $http.get(formUrl +
//                '/' + Math.random() + '.json')
                '/' + Math.random())//今はjson形式でないので.jsonつけるのやめた
            .success(function (data) {
                //フォームエレメント生成
                var form = $('<div>').html(data);

                console.log(postData);
                console.log(form);
                postData._Token = {
                };
                //セキュリティキーセット
                postData._Token.key =
                    $(form).find('input[name="data[_Token][key]"]').val();
                postData._Token.fields =
                    $(form).find('input[name="data[_Token][fields]"]').val();
                postData._Token.unlocked =
                    $(form).find('input[name="data[_Token][unlocked]"]').val();

                var postParams = {
                    _method: 'POST',
                    data: postData
                };

                // POST
                postParams = angular.fromJson(angular.toJson(postParams)); // hashに$$hashKeyがつくのでこれで除去してる
                // booleanをそのままPOSTすると文字列の'true', 'false'になっちゃうので、0,1に変換
                postParams = Links_boolean2intInArray(postParams);
                console.log(postParams);
                $http.post(postUrl +
                    '/' + Math.random() + '.json',
                    $.param(postParams),
                    {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                    .success(function (data) {
                        // success condition
                        deferred.resolve(data);
//
//                        $scope.flash.success(data.name);
//                        $modalInstance.close(); //
                    })
                    .error(function (data, status) {
                        // error condition
                        deferred.reject(data, status);
//                        $scope.flash.danger(status + ' ' + data.name);
//                        $scope.sending = false;
                    });
            })
            .error(function (data, status) {
                //keyの取得に失敗
                // error condition
                deferred.reject(data, status);
//                $scope.flash.danger(status + ' ' + data.name);
//                $scope.sending = false;
            });
        promise.success = function (fn) {
            promise.then(fn);
            return promise;
        }

        promise.error = function (fn) {
            promise.then(null, fn);
            return promise;
        }

        return promise;

    }
    // ここで return したオブジェクトがサービスになる
    return {
        send: send
    }

}]);
NetCommonsApp.factory('Links_RolePermissionRepository', ['$http','$q','Links_ajaxPostService', function ($http, $q, Links_ajaxPostService) {
    var form_url = '/links/link_authority/form/';
    var put_url  = '/links/link_authority/edit/';
    var get_url  = '/links/link_authority/get/';


    return{
        get: function (frameId, callback) {
            $http.get(get_url + frameId + '/' + Math.random() + '.json')
                .success(function (data) {
                    callback(data);
                    // 3.データ取得できたら、元のObjectに内容を追加
                }).error(function (data, status) {
                });
        },
        put: function(frameId, rolePermissions){
            var deferred = $q.defer();
            var promise = deferred.promise;
            var postData ;
            postData = rolePermissions;
            postData.Frame = {
                frame_id: frameId
            }
            console.log(postData);
            Links_ajaxPostService.send(
                    postData,
                    form_url + frameId,
                    put_url + frameId
                )
                .success(function (data) {
                    console.log(data);
                    deferred.resolve(data);
                })
                .error(function (data, status) {
                    //keyの取得に失敗
                    console.log(data);
                    deferred.reject(data, status);
                });
            promise.success = function (fn) {
                promise.then(fn);
                return promise;
            }

            promise.error = function (fn) {
                promise.then(null, fn);
                return promise;
            }
            return promise;
        }
    }

}])
NetCommonsApp.factory('Links_FrameSettingRepository', ['$http','$q','Links_ajaxPostService', function ($http, $q, Links_ajaxPostService) {
    var form_url = '/links/link_frame_setting/form/';
    var put_url  = '/links/link_frame_setting/edit/';
    var get_url  = '/links/link_frame_setting/get/';


    return{
        get: function (frameId, callback) {
            $http.get(get_url + frameId + '/' + Math.random() + '.json')
                .success(function (data) {
                    callback(data);
                    // 3.データ取得できたら、元のObjectに内容を追加
                }).error(function (data, status) {
                });
        },
        // これだとget2をコールしたときの戻り値は空配列で、データ取得完了時に空配列から実データ入りになる。戻り値を操作したいときは向かない
        get2: function (frameId) {
            var resultPointer = []
            $http.get('/links/link_frame_setting/get/' + frameId + '/' + Math.random() + '.json')
                .success(function (data) {
                    // 3.データ取得できたら、元のObjectに内容を追加
                    angular.extend(resultPointer, data);
                }).error(function (data, status) {
                });
            return resultPointer;
        },
        put: function(frameId, linkFrameSetting){
            var deferred = $q.defer();
            var promise = deferred.promise;
            var postData = {
                'Frame':{
                    frame_id: frameId
                },
                LinkFrameSetting:{
                    id: linkFrameSetting.id,
                    frame_key: linkFrameSetting.frame_key,
                    display_type: linkFrameSetting.display_type,
                    open_new_tab: linkFrameSetting.open_new_tab,
                    display_click_number:linkFrameSetting.display_click_number,
                    category_separator_line:linkFrameSetting.category_separator_line,
                    list_style:linkFrameSetting.list_style
                }
            }
            Links_ajaxPostService.send(
                    postData,
                    form_url + frameId,
                    put_url + frameId
                )
                .success(function (data) {
                    console.log(data);
                    deferred.resolve(data);
                })
                .error(function (data, status) {
                    //keyの取得に失敗
                    console.log(data);
                    deferred.reject(data, status);
                });
            promise.success = function (fn) {
                promise.then(fn);
                return promise;
            }

            promise.error = function (fn) {
                promise.then(null, fn);
                return promise;
            }


            return promise;

        }

    }

}])
//NetCommonsApp.factory('Links_LinkCategoryRepository', ['$http', function($http){
//    var list = function(frameId){
//
//         resultPointer = [];
//        //  カテゴリをjsonで返す
//        $http.get('/links/link_category/get_categories/' + frameId + '/'+ Math.random() + '.json')
//            .success(function(data){
//                // 3.データ取得できたら、元のObjectに内容を追加
//                angular.extend(resultPointer, data.resultPointer);
//                $scope.$digest();
//               return data.linkCategories;
//            }).error(function(data,status){
//            });
//        return resultPointer;
//    }
//
//    var loadCategories = function (frameId, loadTarget){
//        $http.get('/links/link_category/get_categories/' + frameId + '/'+ Math.random() + '.json')
//            .success(function(data){
//                // 3.データ取得できたら、元のObjectに内容を追加
//                loadTarget = data.linkCategories;
//                console.log(loadTarget);
//            }).error(function(data,status){
//            });
//    }
//    return {
//        list: list,
//        loadCategories: loadCategories
//    }
//}]);



NetCommonsApp.controller('Links',
    function ($scope, $http, $sce, $timeout, dialogs, $modal) {


        $scope.LINK_ADD_URL = '/links/links/linkAdd/';
        $scope.PLUGIN_MANAGE_URL = '/links/links/manage/';

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

        $scope.initialize = function (frameId, visibleContentList, visibleContentDropdown) {
            $scope.frameId = frameId;
            $scope.visibleContentList = visibleContentList;
            $scope.visibleContentDropdown = visibleContentDropdown;


        };

        $scope.showContainer = function () {
            $scope.visibleHeaderBtn = true;
            $scope.visibleContainer = true;
            $scope.visibleManage = false;
            $scope.visibleAddLink = true;
        };

        $scope.postDisplayStyle = function () {
            if ($scope.visibleContentList === true) {
                $scope.visibleContentList = false;
                $scope.visibleContentDropdown = true;
            } else {
                $scope.visibleContentList = true;
                $scope.visibleContentDropdown = false;
            }
            $scope.showContainer();
        };

        $scope.showAddLink = function () {
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

        $scope.showManage = function () {
            $scope.visibleAddLinkForm = false;

            //管理モーダル取得のURL
            var url = $scope.PLUGIN_MANAGE_URL + $scope.frameId;
            //ダイアログで使用するJSコントローラ
            var controller = 'Links.manage';

            modal = $modal.open({
                templateUrl: url,
                controller: controller,
                backdrop: 'static',
                scope: $scope
            });
            modal.result.then(
                function (result) {
                    // 表示方法変更設定時
                    $scope.postDisplayStyle();
                },
                function (reason) {
                }
            );
        }

        // リンク追加・編集時のカテゴリ選択ドロップダウン用モデルにカテゴリ一覧をロードする
        $scope.loadCategories = function () {
            $http.get('/links/link_category/get_categories/' + $scope.frameId + '/' + Math.random() + '.json')
                .success(function (data) {
                    $scope.linkCategories = data.linkCategories;
                }).error(function (data, status) {
                    $scope.flash.danger(status + ' ' + data.name);
                });

        }
        // リンク追加・編集時のカテゴリ選択ドロップダウン用モデル
        $scope.linkCategories = [''];

    });

NetCommonsApp.controller('Links.linkAdd',
    function ($scope, $http, $sce, $modalInstance, $timeout, dialogs, Links_ajaxPostService, Links_getSiteInfo) {

        // カテゴリ一覧
        $scope.newLink = { // postされるデータ
            Link: {
                link_category_id: 0,
                status: 0, // MyTodo Statusサービスがいるかな
                url: '',
                title: '',
                description: ''
            },
            Frame: {
                frame_id: $scope.frameId
            }
        }

        $scope.loadCategories();
//        console.log($scope.linkCategories);
        // カテゴリ一覧取得
//        $http.get('/links/link_category/get_categories/'+$scope.frameId +'/'+ Math.random() + '.json')
//            .success(function(data){
//                $scope.linkCategories = data.linkCategories;
//            }).error(function(data,status){
//                $scope.flash.danger(status + ' ' + data.name);
//            });

        $scope.getSiteInfo = function () {

            var url = $scope.newLink.Link.url;
            console.log(url);
            Links_getSiteInfo(url,
                function(title, description){
                    $scope.newLink.Link.title = title;
                    $scope.newLink.Link.description = description;
                },
                function(data, status){
                    $scope.flash.danger('サイト情報の取得に失敗しました')
                }
            );
        }

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };


        $scope.send = function (status) {
            $scope.newLink.Link.status = status; // MyTodo 権限によって指定できないステータスがあるが、どうガードする？ここでは放置しておいてPHP側かな

            Links_ajaxPostService.send(
                    $scope.newLink,
                    '/links/links/add_form/' + $scope.frameId,
                    '/links/links/add/' + $scope.frameId
                )
                .success(function (data) {
                    console.log(data);
                    $scope.flash.success(data.name);
                    $modalInstance.close();
                })
                .error(function (data, status) {
                    //keyの取得に失敗
                    console.log(data);
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });

        }

    });

// 管理画面 権限設定タブ
NetCommonsApp.controller('Links.manage.permission',
    function ($scope, $http, $sce, $timeout, dialogs, Links_RolePermissionRepository) {
        $scope.rolePermissions =
        {
            add_link:{
                    chief_editor:{
                        name:"編集長",
                        permission: true
                    },
                    editor: {
                        name:"編集者",
                        permission: true
                    },
                    general_user:{
                        name:"一般",
                        permission: false
                    },
                    visitor:{
                        name:"参観者",
                        permission: false
                    }
                }
        };

        $scope.send = function () {

            Links_RolePermissionRepository.put(
                    $scope.frameId,
                    $scope.rolePermissions
                )
                .success(function (data) {
                    console.log(data);
                    $scope.flash.success(data.name);
                    $modalInstance.close();
                })
                .error(function (data, status) {
                    //keyの取得に失敗
                    console.log(data);
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });

        };


        Links_RolePermissionRepository.get($scope.frameId, function(data){
            $scope.rolePermissions = data;
        });

    }
);

// 管理画面リンク編集タブ
NetCommonsApp.controller('Links.manage.links',
    function ($scope, $http, $sce, $timeout, dialogs, Links_ajaxPostService) {
        $scope.linkCategories = [];

        $scope.init = function () {
            // リンクリストを取得して$scope.linkCategoriesにセットする
            $http.get('/links/links/all/' +
                    $scope.frameId + '/' + Math.random() + '.json')
                .success(function (data) {
                    $scope.linkCategories = data;
                })
                .error(function (data, status) {
                    //取得に失敗 MyTodoエラーメッセージ
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });

        }
        $scope.showEditLink = function (link) {
            $scope.visibleAddLinkForm = true;
            $scope.newLink = link;
            $scope.loadCategories();

//        $scope.Form.link_url = link_url;
//        $scope.Form.title = title;
//        $scope.Form.description = description;
        };


        $scope.deleteButton = function (linkId) {
            dlg = dialogs.confirm('Confirmation', 'リンクを削除してもよろしいですか？');
            dlg.result.then(
                function (btn) {
                    // Yes
                    $scope.sendDelete(linkId);
                },
                function (btn) {
                }  // NO
            );
        };

        $scope.sendDelete = function (linkId) {
            var sendData = {
                Link: {
                    id: linkId
                },
                Frame: {
                    frame_id: $scope.frameId
                }
            };
            Links_ajaxPostService.send(
                    sendData,
                    '/links/links/delete_form/' + $scope.frameId + '/' + linkId,
                    '/links/links/delete/' + $scope.frameId
                )
                .success(function (data) {
                    console.log(data);
                    $scope.flash.success(data.name);
                    $modalInstance.close();
                })
                .error(function (data, status) {
                    //keyの取得に失敗
                    console.log(data);
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });

        }


//        $scope.send = function () {
//            Links_ajaxPostService.send(
//                    $scope.linkCategories,
//                    '/links/links/update_weight_form/' + $scope.frameId + '/' + Math.random(),
//                    '/links/links/update_weight/' + $scope.frameId + '/' + Math.random() + '.json'
//                )
//                .success(function (data) {
//                    console.log(data);
//                    $scope.flash.success(data.name);
//                    $modalInstance.close();
//                })
//                .error(function (data, status) {
//                    //keyの取得に失敗
//                    console.log(data);
//                    $scope.flash.danger(status + ' ' + data.name);
//                    $scope.sending = false;
//                });
//
//        }

        var move = function (categoryIndex, origin, destination) {
            console.log($scope.linkCategories[categoryIndex]);
            var temp = $scope.linkCategories[categoryIndex].links[destination];
            $scope.linkCategories[categoryIndex].links[destination] = $scope.linkCategories[categoryIndex].links[origin];
            $scope.linkCategories[categoryIndex].links[origin] = temp;
            //  weight入れ換え
            var tempWeight = $scope.linkCategories[categoryIndex].links[destination].LinkOrder.weight;
            $scope.linkCategories[categoryIndex].links[destination].LinkOrder.weight = $scope.linkCategories[categoryIndex].links[origin].LinkOrder.weight;
            $scope.linkCategories[categoryIndex].links[origin].LinkOrder.weight = tempWeight;
        };


        $scope.moveUp = function (categoryIndex, linkIndex) {
            move(categoryIndex, linkIndex, linkIndex - 1);
        };

        $scope.moveDown = function (categoryIndex, linkIndex) {
            move(categoryIndex, linkIndex, linkIndex + 1);
        };


//        $scope.closeTest = function(){
//            modal.close(); //これは効く
//        }
    }
)

NetCommonsApp.controller('Links.manage.links.edit',
    function ($scope, $http, $sce, $timeout, dialogs, Links_ajaxPostService) {
        // リンク編集フォームより
        $scope.send = function (status) {
            console.log($scope.newLink);
            $scope.newLink.Link.status = status; // MyTodo 権限によって指定できないステータスがあるが、どうガードする？ここでは放置しておいてPHP側かな

            // 余計なフィールドデータをPOSTするとセキュリティコンポーネントにBlackHole送りにされるので必用なフィールドだけ抜き出す。
            var data = {
                Link: {
                    id: $scope.newLink.Link.id,
                    url: $scope.newLink.Link.url,
                    link_category_id: $scope.newLink.Link.link_category_id,
                    title: $scope.newLink.Link.title,
                    description: $scope.newLink.Link.description,
                    status: $scope.newLink.Link.status
                },
                Frame: {
                    frame_id: $scope.frameId
                }
            }

            Links_ajaxPostService.send(
                    data,
                    '/links/links/edit_form/' + $scope.frameId + '/' + $scope.newLink.Link.id,
                    '/links/links/edit/' + $scope.frameId + '/' + $scope.newLink.Link.id
                )
                .success(function (data) {
                    console.log(data);
                    $scope.flash.success(data.name);
                    $modalInstance.close();
                })
                .error(function (data, status) {
                    //keyの取得に失敗
                    console.log(data);
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });

        }
    });
NetCommonsApp.controller('Links.manage.frame_setting',
    function ($scope, $http, $sce, $timeout, dialogs, Links_ajaxPostService, Links_FrameSettingRepository) {
        // DB上display_type 3だったらform ではdisplay_type2（リスト表示）＋display_description true（説明表示あり）
        $scope.FrameSetting = {
            id: 0,
//            frame_key : '',
            display_type: 0,
            display_description: false,
            open_new_tab: false,
            display_click_number: 0,
            category_separator_line: '',
            list_style: ''
        };

        $scope.init = function () {
            // 設定をロード
             Links_FrameSettingRepository.get($scope.frameId, function(data){
                 $scope.FrameSetting = data;
                 // MyTodo これってModelのメソッドに切り出すべきか
                 if(data.display_type < 2){ // MyTodo MagicNumber
                     $scope.FrameSetting.display_description = false
                 }else{
                     $scope.FrameSetting.display_description = true
                 }
             });
        }

        $scope.postDisplayStyle = function () {
            // MyTodo display_typeのセット
            putData = $scope.FrameSetting;
            console.log(putData);
            if($scope.FrameSetting.display_description){
                putData.display_type = 2; //MyTodo fxi MagicNumber
            }
            Links_FrameSettingRepository.put($scope.frameId, putData)
                .success(function(data){
                    $scope.flash.success(data.name);
                    $scope.modalInstance.close();
                })
                .error(function(data,status){
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                })
        };

//        // リンク編集フォームより
//        $scope.send = function (status) {
//            console.log($scope.newLink);
//            $scope.newLink.Link.status = status; // MyTodo 権限によって指定できないステータスがあるが、どうガードする？ここでは放置しておいてPHP側かな
//
//            // 余計なフィールドデータをPOSTするとセキュリティコンポーネントにBlackHole送りにされるので必用なフィールドだけ抜き出す。
//            var data = {
//                Link:{
//                    id: $scope.newLink.Link.id,
//                    url:$scope.newLink.Link.url,
//                    link_category_id:$scope.newLink.Link.link_category_id,
//                    title:$scope.newLink.Link.title,
//                    description:$scope.newLink.Link.description,
//                    status: $scope.newLink.Link.status
//                },
//                Frame: {
//                    frame_id: $scope.frameId
//                }
//            }
//
//            Links_ajaxPostService.send(
//                    data,
//                    '/links/links/edit_form/' + $scope.frameId + '/' + $scope.newLink.Link.id,
//                    '/links/links/edit/' + $scope.frameId + '/' + $scope.newLink.Link.id
//                )
//                .success(function (data) {
//                    console.log(data);
//                    $scope.flash.success(data.name);
//                    $modalInstance.close();
//                })
//                .error(function (data, status) {
//                    //keyの取得に失敗
//                    console.log(data);
//                    $scope.flash.danger(status + ' ' + data.name);
//                    $scope.sending = false;
//                });
//
//        }
    });

NetCommonsApp.controller('Links.manage',
    function ($scope, $http, $sce, $modalInstance, $timeout, dialogs, Links_ajaxPostService) {

        $scope.modalInstance = $modalInstance;

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
                frame_id: $scope.frameId
            },
            _Token: {
                key: '',
                fields: '',
                unlocked: ''
            }
        };

        $scope.editCategories = {
            _method: 'POST'
        };

        $scope.editCategories.data = {
            LinkCategories: [],
//            LinkCategory:[],
//            LinkCategoryOrder:[],
            Frame: {
                frame_id: $scope.frameId
            },
            _Token: {
                key: '',
                fields: '',
                unlocked: ''
            }
        };


        $scope.initialize = function (frameId, linkCategories) {
            $scope.frameId = frameId;
            angular.forEach(linkCategories, function (oneRecord) {
                $scope.editCategories.data.LinkCategories.push(
                    {
                        LinkCategory: {
                            id: oneRecord.LinkCategory.id,
                            name: oneRecord.LinkCategory.name
                        },
                        LinkCategoryOrder: {
                            id: oneRecord.LinkCategoryOrder.id,
                            weight: oneRecord.LinkCategoryOrder.weight

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


        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };


        $scope.closeEditLink = function () {
            $scope.visibleAddLinkForm = false;
            $scope.Form.link_url = '';
            $scope.Form.title = '';
            $scope.Form.description = '';
        };


        $scope.deleteEditCategory = function (index) {

            dlg = dialogs.confirm('Confirmation', 'カテゴリーを削除してもよろしいですか？');
            dlg.result.then(
                function (btn) {
                    var postData = {
                        LinkCategory: {
                            id: $scope.editCategories.data.LinkCategories[index].LinkCategory.id
                        },
                        Frame: {
                            frame_id: $scope.frameId
                        }
                    };
                    var formUrl = '/links/link_category/delete_form/' + $scope.frameId;
                    var postUrl = '/links/link_category/delete/' + $scope.frameId;
                    var callback = function () {
                    };
                    Links_ajaxPostService.send(postData, formUrl, postUrl)
                        .success(function (data) {
                            $scope.flash.success(data.name);
                            $modalInstance.close();
                        })
                        .error(function (data, status) {
                            //keyの取得に失敗
                            $scope.flash.danger(status + ' ' + data.name);
                            $scope.sending = false;
                        });
                    //削除フォーム取得
                    // セキュリティキーセット
                    // ポスト
                }, // Yes
                function (btn) {
                }  // NO
            );
        };


        /**
         * dialog save
         *
         * @return {void}
         */
        $scope.addCategory = function () {
            $scope.sending = true;

            $http.get('/links/link_category/form/' +
                    $scope.frameId + '/' + Math.random() + '.json')
                .success(function (data) {
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
                .error(function (data, status) {
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
        $scope.sendCategoryPost = function (postParams) {
            //$http.post($scope.PLUGIN_EDIT_URL + Math.random() + '.json',
            $http.post('/links/link_category/add/' +
                $scope.frameId + '/' + Math.random() + '.json',
                //$.param(postParams))
                //{data: postParams})
                //postParams)
                $.param(postParams),
                {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                .success(function (data) {
                    $scope.flash.success(data.name);
                    // MyTodo カテゴリ追加し終わったらカテゴリ一覧をリロードしたいよなぁ
//                    $modalInstance.close(data.announcement);
                })
                .error(function (data, status) {
                    $scope.flash.danger(status + ' ' + data.name);
                    $scope.sending = false;
                });
        };
        /**
         * dialog save
         *
         * @return {void}
         */
        $scope.updateCategories = function () {
            $scope.sending = true;

            $http.get('/links/link_category/categories_form/' +
                    $scope.frameId + '/' + Math.random() + '.json')
                .success(function (data) {
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
                .error(function (data, status) {
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
        $scope.sendCategoriesPost = function (postParams) {
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
                .success(function (data) {
                    $scope.flash.success(data.name);
                    $modalInstance.close(); //
                })
                .error(function (data, status) {
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

        $scope.moveUp = function (index) {
            move(index, index - 1);
        };

        $scope.moveDown = function (index) {
            move(index, index + 1);
        };

    }

);

