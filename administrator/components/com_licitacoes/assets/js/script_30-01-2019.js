
// declare a module
var myAppModule = angular.module('Interessados', []);

myAppModule.controller("interessadosCtrl", function ($scope, $http) {

    var url = window.location.search;
    var id = url.split("id=");

    $scope.data;

    $http.get('index.php?option=com_licitacoes&view=interessados&layout=edit.php&doc=&nome=&tipo=&id='+id[1])
        .then(function(data) {
            $scope.data = data.data;
            //console.log($scope.data);
        })
        .catch(function(data) {
            console.error('Gists error', data.status, data.data);
        })
        .finally(function() {
            console.log("finally finished gists");
        });

  $scope.getPesquisa = function () {
      var doc = document.getElementById("documento").value;
      var nome = document.getElementById("nome").value;
      var tipo = document.getElementById("tipo").value;

      console.log(doc);
      console.log(nome);
      console.log(tipo);

      $http.get('index.php?option=com_licitacoes&view=interessados&layout=edit.php&doc='+doc+'&nome='+nome+'&tipo='+tipo+'&id='+id[1])
          .then(function (data) {
              $scope.data = data.data;
          })
          .catch(function (data) {
              console.error('Gists error', data.status, data.data);
          })
          .finally(function () {
              console.log("finally finished gists");
          });
  }
});
