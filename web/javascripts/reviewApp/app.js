var reviewApp = angular.module('reviewApp',['angularUtils.directives.dirPagination', 'pascalprecht.translate']);
reviewApp.factory('review_data', ['$http', function review_data($http){
	return {
    createMemberReview: function(token, dataObj){
      return $http({
				method:'POST',
				url: Routing.generate('api_1_post_reviews'),
				data: $.param(dataObj),
				headers: {
					'Authorization':'Bearer ' + token,
					'Content-Type':'application/x-www-form-urlencoded'
				}
			});
    },
		createNonMemberReview: function(dataObj){
      return $http({
				method:'POST',
				url: Routing.generate('api_1_post_public_create_reviews'),
				data: $.param(dataObj),
				headers: {'Content-Type':'application/x-www-form-urlencoded'}
			});
    },
		getAllReview: function(product_id, page, list_per_page){
			list_per_page = list_per_page || "";
      return $http({
				method:'GET',
				url: Routing.generate('api_1_get_public_reviews',{'product_id':product_id,'page':page,'list_per_page':list_per_page})
			});
    }
	}
}]);


reviewApp.config(function ($translateProvider) {
  $translateProvider.translations('en', {
      January: 'January',
      February: 'February',
      March: 'March',
      April: 'April',
      May: 'May',
      June: 'June',
      July: 'July',
      August: 'August',
      September: 'September',
      October: 'October',
      November: 'November',
      December: 'December',
  });
  $translateProvider.translations('th', {
      January: 'ม.ค.',
      February: 'ก.พ.',
      March: 'มี.ค.',
      April: 'เม.ย.',
      May: 'พ.ค.',
      June: 'มิ.ย.',
      July: 'ก.ค.',
      August: 'ส.ค.',
      September: 'ก.ย.',
      October: 'ต.ค.',
      November: 'พ.ย.',
      December: 'ธ.ค.',
  });
  $translateProvider.preferredLanguage('th');
});
