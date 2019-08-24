var app = angular.module('productVariantApp', []);

app.controller('productVariantController', function($scope) {

	$scope.init_product_variants = function(data_lvl, product_category_id, arr_option_tree){
		$scope.movetos = [
			{'title':'Last Child', 'value':'lastchild'},
			{'title':'First Child', 'value':'firstchild'},
			{'title':'Next Sibling', 'value':'nextsibling'},
			{'title':'Prev Sibling', 'value':'prevsibling'}
		];

		$scope.parents = JSON.parse(arr_option_tree);
		// $scope.parents = window.parents;

		$scope.moveto = $scope.movetos[0];
		$scope.parent = $scope.parents[0];

		$scope.data_product_category_lvl = parseInt(data_lvl);
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

		if(level>=3){
			if (data_moveto=='lastchild' || data_moveto=='firstchild') {
				elem.attr('disabled', 'disabled');
			}else{
				elem.removeAttr("disabled");
			}
		}

		// var i;
		// $.each(opt.scope.items,function(index,item) {
		//   if (item.id === opt.item.id) {
		//     i = index;
		//     return false;
		//   }
		// });

		// var elem = angular.element("select > option[value='" + i + "']");
		// var classTail = opt.className;
		// if (opt.eligible) {
		//   elem.addClass('is-' + classTail);
		//   elem.removeClass('not-' + classTail);
		// } else {
		//   elem.addClass('not-' + classTail);
		//   elem.removeClass('is-' + classTail);
		// }

		return text;
	}
});

/*
app.directive('optionClass', function ($compile, $parse) {

    return {
        restrict: 'A',
		require: 'select',
        link: function optionClassExprPostLink(scope, elem, attrs, ngSelect) {


		var optionsExp = attrs.ngOptions;
		if (!optionsExp) return;

		scope.$watchCollection(function () {
		    return elem.children();
		}, function (newValue) {
		    angular.forEach(newValue, function (child) {
				var child = angular.element(child);
				var val   = child.val();
				if (val) {
		            child.attr('ng-class', values + '[' + val + '].' +
		                                   attrs.optionClassExpr);
		            $compile(child)(scope);
		        }
		    });
		});


		var optionsSourceStr = attrs.ngOptions.split(' ').pop(),
		getOptionsClass = $parse(attrs.optionsClass);
		scope.$watch(optionsSourceStr, function(items) {
			// when the options source changes loop through its items.
			angular.forEach(items, function(item, index) {
				// evaluate against the item to get a mapping object for
				// for your classes.
				var classes = getOptionsClass(item),
				// also get the option you're going to need. This can be found
				// by looking for the option with the appropriate index in the
				// value attribute.
				option = elem.find('option[value=' + index + ']');

				// now loop through the key/value pairs in the mapping object
				// and apply the classes that evaluated to be truthy.
				angular.forEach(classes, function(add, className) {
					if(add) {
						angular.element(option).addClass(className);
					}
				});
			});
		});

        }
    };
});
*/
