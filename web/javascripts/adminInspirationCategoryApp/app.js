var app = angular.module('inspirationCategoryApp', []);

app.controller('inspirationCategoryController', function($scope) {

    $scope.init_inspiration_ategory = function(data_lvl, category_id, arr_option_tree){
        $scope.movetos = [
            {'title':'Next Sibling', 'value':'nextsibling'},
            {'title':'Prev Sibling', 'value':'prevsibling'}
        ];

        /*$scope.movetos = [
            {'title':'Last Child', 'value':'lastchild'},
            {'title':'First Child', 'value':'firstchild'},
            {'title':'Next Sibling', 'value':'nextsibling'},
            {'title':'Prev Sibling', 'value':'prevsibling'}
        ];*/

        $scope.parents = JSON.parse(arr_option_tree);
        // // $scope.parents = window.parents;
        $scope.moveto = $scope.movetos[0];
        $scope.parent = $scope.parents[0];

        $scope.data_category_lvl = parseInt(data_lvl);
    }
});

app.filter('addClassParent', function() {
    return function(text, opt) {
        var data_moveto = opt.data_moveto
        var value = opt.value;
        var level = opt.level;
        var elem = angular.element("#parent option[value='"+value+"']");
        var classTail = opt.class_name;
        elem.addClass(classTail);

        if(level>=2){
            if (data_moveto=='lastchild' || data_moveto=='firstchild') {
                elem.attr('disabled', 'disabled');
            }else{
                elem.removeAttr("disabled");
            }
        }
        return text;
    }
});
