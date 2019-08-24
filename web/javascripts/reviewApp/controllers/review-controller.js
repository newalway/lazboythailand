reviewApp.controller('reviewController', ['$scope', '$sce', '$translate', 'review_data', function($scope, $sce, $translate, review_data){

  $scope.init = function(token, product_id, user_session, lang_key)
  {
    $scope.setToken(token);
    $scope.formDataReview.product_id = product_id;
    $scope.formDataReview.user_session = user_session;

    //uses the translate
    $translate.use(lang_key);
  }

  $scope.setToken = function(token){
    $scope.access_token = token;
  }
  $scope.getToken = function(){
    return $scope.access_token;
  }
  $scope.setItemRating = function(rating){
    $scope.formDataReview.rating = rating;
  };
  $scope.getItemRating = function(){
    return $scope.formDataReview.rating;
  }
  $scope.getDataLoading = function() {
    return $scope.data_loaded;
  };
  $scope.setDataLoading = function(value) {
    $scope.data_loaded = value;
  };
  $scope.setReviewEditor = function(val){
    $scope.reviewEditor = val;
  };
  $scope.getReviewEditor = function(){
    return $scope.reviewEditor;
  }
  $scope.setWriteYourReview = function(val){
    $scope.writeYourReview = val;
  };
  $scope.getWriteYourReview = function(){
    return $scope.writeYourReview;
  }

  $scope.processReviewForm = function(){
    openDomWindow();
    $scope.formDataReview._token = angular.element('#review__token').val();
    var acc_token = $scope.getToken();

    var postData = {review: $scope.formDataReview};

    if(acc_token){
      //member
      review_data.createMemberReview(acc_token, postData).then(function onSuccess(response){
        var data = response.data;
        if(data.success){
          $scope.message = $sce.trustAsHtml(data.message);
          $scope.errors = {};
          $scope.setReviewEditor(false);
          //reset data
          $scope.formDataReview.title = '';
          $scope.formDataReview.content = '';
        }else{
          $scope.message = $sce.trustAsHtml(data.message);
          $scope.errors = data.errors;
        }

        closeDomWindow();
      }).catch(function onError(response) {
        closeDomWindow();
      });

    }else{
      //nonmember
      review_data.createNonMemberReview(postData).then(function onSuccess(response){
        var data = response.data;
        if(data.success){
          $scope.message = $sce.trustAsHtml(data.message);
          $scope.errors = {};
          $scope.setReviewEditor(false);
          //reset data
          $scope.formDataReview.title = '';
          $scope.formDataReview.content = '';
        }else{
          $scope.message = $sce.trustAsHtml(data.message);
          $scope.errors = data.errors;
        }

        closeDomWindow();
      }).catch(function onError(response){
        closeDomWindow();
      });

    }
  }

  $scope.formDataReview = {'rating':0};
  $scope.errors = {};
  $scope.message = '';
  $scope.setDataLoading(false);
  $scope.getReviewEditor(false);
  $scope.setWriteYourReview(true);


  /* List all review */
  $scope.lists = [];
  $scope.countReview = 0;
  $scope.listsPerPage = 10;
  $scope.pagination = {current: 1};
  $scope.pageChanged = function(newPage) {
    $scope.getResultsPage(newPage);
  };
  $scope.getResultsPage = function(pageNumber){
    review_data.getAllReview($scope.formDataReview.product_id, pageNumber, $scope.listsPerPage).then(function onSuccess(response){
      $scope.lists = response.data.review_data;
      $scope.countReview = response.data.count_review;
      closeDomWindow();
    }).catch(function onError(response) {
      closeDomWindow();
    });
  }

}]);

reviewApp.filter('nl2br', function($sce){
  return function(msg,is_xhtml) {
    var is_xhtml = is_xhtml || true;
    var breakTag = (is_xhtml) ? '<br />' : '<br>';
    var msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
    return $sce.trustAsHtml(msg);
  }
});
