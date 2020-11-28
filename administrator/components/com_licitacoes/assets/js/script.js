
// declare a module
var myAppModule = angular.module('Interessados', []);

myAppModule.controller("interessadosCtrl", function ($scope, $http) {

    var url = window.location.search;
    var id = url.split("id=");
    console.log(id[1]);
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

      doc = Mascara(doc);

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
//adiciona mascara ao CPF
function Mascara(doc){
    if (doc.length == 11){
        return formataCampo(doc, '000.000.000-00');
    }else if (doc.length == 14) {
        return formataCampo(doc, '00.000.000/0000-00');
    }
}
//formata de forma generica os campos
function formataCampo(campo, Mascara) {
    var boleanoMascara;

    exp = /\-|\.|\/|\(|\)| /g
    campoSoNumeros = campo;

    var posicaoCampo = 0;
    var NovoValorCampo="";
    var TamanhoMascara = campoSoNumeros.length;;

    for(i=0; i<= TamanhoMascara; i++) {
        boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
            || (Mascara.charAt(i) == "/"))
        boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(")
            || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
        if (boleanoMascara) {
            NovoValorCampo += Mascara.charAt(i);
            TamanhoMascara++;
        }else {
            NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
            posicaoCampo++;
        }
    }
    return NovoValorCampo;
}