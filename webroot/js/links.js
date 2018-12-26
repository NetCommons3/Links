/**
 * @fileoverview Links Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * LinksIndex Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http, $window)} Controller
 */
NetCommonsApp.controller('LinksIndex',
    ['$scope', '$http', '$window', 'NC3_URL', function($scope, $http, $window, NC3_URL) {

      /**
       * data
       *
       * @type {object}
       */
      $scope.data = {};

      /**
       * initialize
       *
       * @return {void}
       */
      $scope.initialize = function(data) {
        $scope.data = {
          _Token: data['_Token'],
          Frame: {id: data['Frame']['id']},
          Block: {id: data['Block']['id']},
          Link: {id: '', key: ''}
        };
      };

      /**
       * Click link
       *
       * @param {integer} links.id
       * @return {void}
       */
      $scope.clickLink = function($event, id, key) {
        $scope.data.Link.id = id;
        $scope.data.Link.key = key;

        $http.get(NC3_URL + '/net_commons/net_commons/csrfToken.json')
            .then(function(response) {
              var token = response.data;
              $scope.data._Token.key = token.data._Token.key;

              //POSTリクエスト
              $http.put(
                  NC3_URL + '/links/links/link.json',
                  $.param({_method: 'PUT', data: $scope.data}),
                  {cache: false,
                    headers:
                        {'Content-Type': 'application/x-www-form-urlencoded'}
                  }
              ).then(function() {
                var element = $('#nc-badge-' + $scope.data.Frame.id + '-' + id);
                if (element) {
                  var count = parseInt(element.html()) + 1;
                  element.html(count);
                }
              });
            });

        if ($event.target.target) {
          $window.open($event.target.href, $event.target.target);
        } else {
          $window.location.href = $event.target.href;
        }
      };
    }]);


/**
 * LinksEdit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http)} Controller
 */
NetCommonsApp.controller('LinksEdit',
    ['$scope', '$http', 'NC3_URL', function($scope, $http, NC3_URL) {

      /**
       * Get url
       *
       * @return {void}
       */
      $scope.getUrl = function(frameId) {
        var element = $('input[name="data[Link][url]"]');

        if (angular.isUndefined(element[0]) || ! element[0].value) {
          return;
        }

        $http.get(NC3_URL + '/links/links/get.json',
            {params: {frame_id: frameId, url: element[0].value}})
            .then(function(response) {
              var data = response.data;
              element = $('input[name="data[Link][title]"]');
              if (! angular.isUndefined(element[0]) &&
                      ! angular.isUndefined(data['title'])) {
                element[0].value = data['title'];
              }

              element = $('textarea[name="data[Link][description]"]');
              if (! angular.isUndefined(element[0]) &&
                      ! angular.isUndefined(data['description'])) {
                element[0].value = data['description'];
              }

              $scope.urlError = '';
            },
            function(response) {
              var data = response.data;
              $scope.urlError = angular.isUndefined(data['error']) ? data['name'] : data['error'];
            });
      };

    }]);


/**
 * LinksEdit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('LinkFrameSettings', ['$scope', function($scope) {

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    $scope.linkFrameSetting = data.linkFrameSetting;
    $scope.currentCategorySeparatorLine = data.currentCategorySeparatorLine;
    $scope.currentListStyle = data.currentListStyle;
  };

  /**
   * Select categorySeparatorLine
   *
   * @return {void}
   */
  $scope.selectCategorySeparatorLine = function(line) {
    $scope.linkFrameSetting.category_separator_line = line.key;
    $scope.currentCategorySeparatorLine = line;
  };

  /**
   * Select listStyle
   *
   * @return {void}
   */
  $scope.selectListStyle = function(mark) {
    $scope.linkFrameSetting.list_style = mark.key;
    $scope.currentListStyle = mark;
  };

}]);


/**
 * LinkOrders Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('LinkOrders', ['$scope', function($scope) {

  /**
   * Links
   *
   * @type {object}
   */
  $scope.links = {};

  /**
   * Categories
   *
   * @type {object}
   */
  $scope.categories = [];

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    var categoryId = '';
    angular.forEach(data.categories, function(value) {
      $scope.categories.push(value);

      categoryId = value.Category.id;

      if (! angular.isUndefined(data.links[categoryId])) {
        angular.forEach(data.links[categoryId], function(link) {
          if (angular.isUndefined($scope.links['_' + categoryId])) {
            $scope.links['_' + categoryId] = new Array();
          }
          $scope.links['_' + categoryId].push(link);
        });
      }
    });
  };

  /**
   * move
   *
   * @return {void}
   */
  $scope.move = function(categoryId, type, index) {
    var dest = (type === 'up') ? index - 1 : index + 1;

    if (angular.isUndefined($scope.links['_' + categoryId][dest])) {
      return false;
    }

    var destLink = angular.copy($scope.links['_' + categoryId][dest]);
    var targetLink = angular.copy($scope.links['_' + categoryId][index]);
    $scope.links['_' + categoryId][index] = destLink;
    $scope.links['_' + categoryId][dest] = targetLink;
  };

}]);
