var registerApp = angular.module('registerApp', []);

registerApp.factory('register_data', ['$http', function register_data($http){
    return {
        create: function(dataObj){
            return $http({
                method:'POST',
                // url: 'http://localhost:9134/app_dev.php/api/v1/lazboycampaigns',
                url: 'http://api.what-zap.com/api/v1/lazboycampaigns',
                data: $.param(dataObj),
                headers: {
                    // 'Authorization':'Bearer OTRlN2UwNmI3ZTQ5MDMzNzliMDYzODFjMjc0Mjg2ZDk1YzIwYjY3NWRlYjZmNzhiNDM3Y2Y1OGQ0NjIwNzFjYw',
                    'Authorization':'Bearer ZjQzOGQzZjI4OTAzMDk1ZDQ1YjIxMDYzMGE5NWFiMDgwNzA3NGE2OGJjZTA0NDRmM2Q2MmNjMTI4NTZiNGFhMQ',
                    'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'
                }
            });
        }
    }
}]);

registerApp.controller('registerController', ['$scope', '$sce', '$window', 'register_data', function($scope, $sce, $window, register_data) {
    $scope.getDataLoading = function() {
        return $scope.data_loaded;
    };
    $scope.setDataLoading = function(value) {
        $scope.data_loaded = value;
    };

    $scope.processForm = function() {
        $scope.setDataLoading(true);

        register_data.create($scope.formData).then(function onSuccess(response) {
            var data = response.data;
            if (!data.success) {
                $scope.message = data.message;
                $scope.errors = data.error_message;
            } else {
                $scope.message = data.message;
                $scope.errors = data.error_message;
                $window.location.href = 'http://www.lazboythailand.com/campaign/thanks.html';
                $scope.formData = {};
            }
            $scope.setDataLoading(false);
        }).catch(function onError(response) {
            $scope.setDataLoading(false);
        });
    };

    $scope.formData = {};
    $scope.errors = {};
    $scope.message = null;
    $scope.setDataLoading(false);

}]);
