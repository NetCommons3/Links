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
NetCommonsApp.controller('LinksIndex', function($scope, $http, $window) {

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
    $scope.frameId = data.frameId;

    $scope.data = {
      _Token: data['_Token'],
      Frame: {id: data['frameId']},
      Link: {id: ''}
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

    $http.get('/net_commons/net_commons/csrfToken.json')
      .success(function(token) {
          //$scope.data._Token.key = token.data._Token.key;

          //POSTリクエスト
          $http.post(
              '/links/links/link/' + $scope.frameId + '/' + key + '.json',
              $.param({_method: 'POST', data: $scope.data}),
              {cache: false,
                headers:
                    {'Content-Type': 'application/x-www-form-urlencoded'}
              }
          ).success(function() {
            var element = $('#nc-badge-' + $scope.frameId + '-' + id);
            if (element) {
              var count = parseInt(element.html()) + 1;
              element.html(count);
            }
            if ($event.target.target) {
              $window.open($event.target.href, $event.target.target);
            } else {
              $window.location.href = $event.target.href;
            }
          });
        });
  };
});


/**
 * LinksEdit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http)} Controller
 */
NetCommonsApp.controller('LinksEdit', function($scope, $http) {

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    $scope.link = data.link;
    $scope.frameId = data.frameId;
    $scope.action = data.action;
  };

  /**
   * Get url
   *
   * @return {void}
   */
  $scope.getUrl = function() {
    var element = $('input[name="data[Link][url]"]');

    $http.get('/links/links/get/' + $scope.frameId + '.json',
        {params: {url: element[0].value}})
      .success(function(data) {
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
        })
      .error(function(data) {
          $scope.urlError =
              angular.isUndefined(data['error']) ? data['name'] : data['error'];
        });
  };

});


/**
 * LinksEdit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('LinkFrameSettings', function($scope) {

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    $scope.linkFrameSetting = data.linkFrameSetting;
    $scope.frameId = data.frameId;
    $scope.currentCategorySeparatorLine = data.currentCategorySeparatorLine;
    $scope.currentListStyle = data.currentListStyle;
  };

  /**
   * Select categorySeparatorLine
   *
   * @return {void}
   */
  $scope.selectCategorySeparatorLine = function(line) {
    $scope.linkFrameSetting.categorySeparatorLine = line.key;
    $scope.currentCategorySeparatorLine = line;
  };

  /**
   * Select listStyle
   *
   * @return {void}
   */
  $scope.selectListStyle = function(mark) {
    $scope.linkFrameSetting.listStyle = mark.key;
    $scope.currentListStyle = mark;
  };

});


/**
 * LinkOrders Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('LinkOrders', function($scope) {

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
    angular.forEach(data.categories, function(value) {
      $scope.categories.push(value);
    });
    $scope.links = data.links;
  };

  /**
   * move
   *
   * @return {void}
   */
  $scope.move = function(categoryId, type, index) {
    index = index + 1;

    var dest = (type === 'up') ? index - 1 : index + 1;
    if (angular.isUndefined($scope.links[categoryId][dest])) {
      return false;
    }

    var destLink = angular.copy($scope.links[categoryId][dest]);
    var targetLink = angular.copy($scope.links[categoryId][index]);
    $scope.links[categoryId][index] = destLink;
    $scope.links[categoryId][dest] = targetLink;
  };

});
