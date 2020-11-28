
// declare a module
var myAppModule = angular.module('PrevisaoTempo', []);

myAppModule.controller("valorescrl", function ($scope) {

  $scope.opcoes = [];
  //
  var arrValores = document.getElementById('valores').value;
  $scope.variavelValor = [];
  $scope.listaVarValor = [];

  if(arrValores != null && arrValores.length > 0)
  {
    console.log(arrValores);
    var arrTemp = arrValores.split(',');
    var i = 0;
    var arrInit = [];
    for (i = 0; i < arrTemp.length; i++)
    {
      var itemboj = arrTemp[i].split(';');
      var obj = {
        messoregiao: itemboj[0],
        variavel: itemboj[1],
        valor: itemboj[2]
      }
      $scope.variavelValor.push(obj);
    }
    //$scope.variavelValor = arrInit;
    $scope.listaVarValor = arrTemp;
  }

  //
  $scope.trocaValores = function () {
    if ($scope.variavel !== null) {
      if (typeof $scope.variavel !== "undefined" && $scope.variavel.indexOf(",") != -1) {
        $scope.opcoes = $scope.variavel.split(',');
      }
      else if (typeof $scope.variavel !== "undefined") {
        var arrTemp = [];
        arrTemp.push($scope.variavel);
        $scope.opcoes = arrTemp;
      }
    }
  }

  $scope.addNovoValor = function () {
    if ($scope.mesorregiao === null ||
      $scope.mesorregiao === '' ||
      $scope.variavel === null ||
      $scope.variavel === '' ||
      typeof $scope.valor === "undefined" ||
      $scope.valor == '' ||
      $scope.valor == null) {
      alert("Você tem que adicionar uma Mesorregião|Variavel|Valor.")
    }else {
      // Get name of variavel
      var x = document.getElementById("variavel");
      var i;
      var variavelNome;
      for (i = 0; i < x.length; i++) {
        if (x.options[i].value.indexOf($scope.variavel) != -1) {
          variavelNome = x.options[i].text;
        }
      }
      var obj = {
        messoregiao: $scope.mesorregiao,
        variavel: variavelNome,
        valor: $scope.valor
      }

      var row = $scope.mesorregiao +';'+ variavelNome +';'+ $scope.valor;

      let unico = true;

      if($scope.variavelValor.indexOf(obj) != -1) {
        alert("Mesorregião|Variavel|Valor já adicionada.");
      } else {
        
        for (let index = 0; index < $scope.variavelValor.length; index++) {
          let objTemp = $scope.variavelValor[index];
          if(objTemp.messoregiao == $scope.mesorregiao && objTemp.variavel == variavelNome){
            unico = false;
            alert("Mesorregião|Variavel|Valor já adicionada.");
          }
        }
          
        if(unico){
          $scope.variavelValor.push(obj);
          $scope.listaVarValor.push(row); 
        }
      }

    }
    
    document.getElementById('valores').value = [];
    document.getElementById('valores').value = $scope.listaVarValor;
  }

  $scope.deletaValor = function (intem) {
    console.log($scope.listaVarValor);
    $scope.variavelValor.splice(intem, 1);
    $scope.listaVarValor.splice(intem, 1);
    if($scope.variavelValor.length == 0 || $scope.listaVarValor.length == 0)
    {
      document.getElementById('valores').value = [];
    }
    else
    {
      document.getElementById('valores').value = $scope.listaVarValor;
    }
  }
});
