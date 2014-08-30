NetCommonsApp.controller('Links',
    function($scope , $http, $sce, $timeout) {
        /**
         * ヘッダーボタン
         *
         * @type {boolean}
         */
        $scope.sendLock = false;


        /**
         * display header button
         *
         * @type {boolean}
         */
        $scope.displayHeaderBtn = true;


        /**
         * input form object
         *
         * @type {{display: boolean,
       *         title: string,
       *         content: content,
       *         button: boolean}}
         */
        $scope.Form = {
            'display': false,
            'title': '',
            'url' : '',
            'description' : '',
            'button': false
        };

        /**
         * content object
         *
         * @type {{display: boolean}}
         */
        $scope.Content = {
            'display': true
        };

        /**
         * Notepad plugin URL
         *
         * @const
         */
        $scope.PLUGIN_URL = '/links/links/';

        /**
         * post url
         *
         * @const
         */
        $scope.POST_FORM_URL = $scope.PLUGIN_URL + 'add/';

        /**
         * result message id attribute
         *
         * @type {sring}
         */
        $scope.contentAttrId = '';

        /**
         * input form id attribute
         *
         * @type {sring}
         */
        $scope.inputFormAttrId = '';

        /**
         * input form id attribute
         *
         * @const
         */
        $scope.INPUT_FORM_ATTR_ID = '#nc-links-input-form-';

        /**
         * Initialize
         *
         * @return {void}
         */
        $scope.initialize = function(notepad, frameId) {
//            $scope.notepad = notepad;
            $scope.frameId = frameId;

            //入力フォームid属性のセット
            $scope.inputFormAttrId = $scope.INPUT_FORM_ATTR_ID + $scope.frameId;

//            //POSTフォームid属性のセット
//            $scope.postFormAttrId = $scope.POST_FORM_ATTR_ID + $scope.frameId;
//            //POSTフォームエリアid属性のセット
//            $scope.postFormAreaAttrId = $scope.POST_FORM_ATTR_ID +
//                'area-' + $scope.frameId;

//            //登録処理結果メッセージのid属性のセット
//            $scope.resultMessageAttrId =
//                $scope.RESULT_MESSAGE_ATTR_ID + $scope.frameId;
//
//            //コンテンツのid属性のセット
//            $scope.ContentAttrId = $scope.CONTENT_ATTR_ID + $scope.frameId;

            $scope.Content.display = true;

        };

        /**
         * show setting form
         *
         * @return {void}
         */
        $scope.showAddForm = function() {
            /**
             *    1．フォームを表示する       $scope.GET_FORM_URL = $scope.PLUGIN_URL + 'form/';
             *    2．編集・ブロックセッティングのボタンを隠す
             *    3．コンテンツを隠す
             */
            $scope.Form.display = true;
            $scope.displayHeaderBtn = false;
            $scope.Form.button = true;
            $scope.Content.display = false;

//            //メッセージの初期化
//            $($scope.resultMessageAttrId)
//                .removeClass('alert-danger')
//                .removeClass('alert-success');
//            $($scope.resultMessageAttrId + ' .message').html(' ');
//
//            //POSTフォームエリアの内容をクリア
//            $($scope.postFormAreaAttrId).html(' ');
        };


        /**
         * post
         *     1: Publish
         *     2: Approve
         *     3: Draft
         *     4: Disapprove
         *
         * @param {string} status
         * @return {void}
         */
//        $scope.post = function(postStatus) {
//            //$scope.sendLock = true;
//
//            $http.get($scope.GET_FORM_URL +
//                    $scope.frameId + '/' +
//                    $scope.notepad.Notepad.language_id + '/' + Math.random())
//                .success(function(data, status, headers, config) {
//                    //POST用のフォームセット
//                    $($scope.postFormAreaAttrId).html(data);
//                    //ステータスのセット
//                    $($scope.postFormAttrId +
//                        ' select[name="data[Notepad][status]"]').val(postStatus);
//
//                    var postParams = {};
//                    //POSTフォームのシリアライズ
//                    var postSerialize =
//                        $($scope.postFormAttrId).serializeArray();
//                    var length = postSerialize.length;
//                    for (var i = 0; i < length; i++) {
//                        postParams[postSerialize[i]['name']] =
//                            postSerialize[i]['value'];
//                    }
//
//                    //入力フォームのシリアライズ
//                    var inputSerialize =
//                        $($scope.inputFormAttrId).serializeArray();
//                    var length = inputSerialize.length;
//                    for (var i = 0; i < length; i++) {
//                        postParams[inputSerialize[i]['name']] =
//                            inputSerialize[i]['value'];
//                    }
//
//                    //登録情報をPOST
//                    $scope.sendPost(postParams);
//                })
//                .error(function(data, status, headers, config) {
//                    //keyの取得に失敗
//                    if (! data) { data = 'error'; }
//                    $scope.showResult('error', data);
//                });
//        };


        $scope.post = function(postStatus) {
            var postParams = {};

            //入力フォームのシリアライズ
            var inputSerialize =
                $($scope.inputFormAttrId).serializeArray();
            var length = inputSerialize.length;
            for (var i = 0; i < length; i++) {
                postParams[inputSerialize[i]['name']] =
                    inputSerialize[i]['value'];
            }
            $scope.sendPost(postParams);
        }
        /**
         * save
         *
         * @param {Object.<string>} postParams
         * @return {void}
         */
        $scope.sendPost = function(postParams) {
            $.ajax({
                method: 'POST' ,
                url: $scope.POST_FORM_URL + $scope.frameId + '/' + Math.random(),
                data: postParams,
                success: function(json, status, headers, config) {
//                    $scope.notepad = json.data;
//                    $($scope.contentAttrId + ' .nc-notepads-title')
//                        .html(json.data.Notepad.title);
//                    $($scope.contentAttrId + ' .nc-notepads-content')
//                        .html(json.data.Notepad.content);
//                    $scope.showResult('success', json.message);
                },
                error: function(json, status, headers, config) {
                    if (! json.message) {
                        $scope.showResult('error', headers);
                    } else {
                        $scope.showResult('error', json.message);
                    }
                }
            });
        };

    }


)