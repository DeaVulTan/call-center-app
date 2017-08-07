$( document ).ready(function(){
    var app = angular.module('MyApp',[]);
});

function checkboxSelector($scope) {
    $scope.resetChecked = function() {
        $scope.data.forEach(function (row) {
            row.selected = false;
        });
    }
}