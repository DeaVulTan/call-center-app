$( document ).ready(function() {
    angular.module('MyApp', ['ui.sortable'])
        .controller('notesController', function($scope) {
            $scope.createField = function () {
                $scope.fields.push({"id":"","title":"","type":"text"});
            };

            $scope.deleteField = function (num) {
                $scope.fields.splice(num,1);
            };
        })
});
