var contador = 1;
var classTree= 2;

function addSampleRow(id)
{

    var objTable = document.getElementById(id);
    var objRow   = objTable.insertRow(objTable.rows.length);
    var objCell1 = objRow.insertCell(0);
    var objCell2 = objRow.insertCell(1);
    var objCell3 = objRow.insertCell(2);
    var objCell4 = objRow.insertCell(3);
    var objCell5 = objRow.insertCell(4);

    var objInputCheckBox  = document.createElement("input");
    objInputCheckBox.type = "checkbox";
    objCell1.appendChild(objInputCheckBox);

    var objInputTittle  = document.createElement("input");
    objInputTittle.type = "text";
    objInputTittle.name = "jform[titulos][]";
    objCell2.appendChild(objInputTittle);

    var dataStr = new Date().toLocaleString();

    objCell3.innerHTML = dataStr.substring(0, dataStr.length - 3);
    objCell4.innerHTML = "<?php echo JFactory::getUser(JFactory::getUser()->id)->get('username') ?>";

    var objInputFile  = document.createElement("input");
    objInputFile.type = "file";
    objInputFile.name = "jform[arquivo][]";
    objCell5.appendChild(objInputFile);

    contador++;
}


jQuery.noConflict();
(function($)
{
    $(document).ready(function()
    {
        // $( "#adminForm" ).submit(function( event ) {

        // if($('#jform_titulo').val()    == '' ||
        //  $('#jform_descricao').val() == '' ||
        //  $('#jform_conteudo').val()  == '' ||
        //  $('#jform_inicio').val()    == '' ||
        //  $('#jform_validade').val()  == '')
        // {
        //     event.preventDefault();
        //     alert('Por favor, preencher dados obrigatórios*. ');
        // }

        // });

        $('.tree').treegrid({
          'initialState': 'collapsed',
          'saveState': true,
        });

        troca = function(id, tipo)
        {   
            if(tipo == 1)
            {
                $("#arquivo-"+id).show();
                $("#url-"+id).hide();
                document.getElementById('tipo-'+id).value = 1;
            }else{
                $("#url-"+id).show();
                $("#arquivo-"+id).hide();
                document.getElementById('tipo-'+id).value = 2;
            }
        }

        removeSampleRow = function(id){

            var objTable = document.getElementById(id);
            var iRow     = objTable.rows.length;
            var counter  = 0;

            alert(objTable.rows.length);

            
            if (objTable.rows.length > 1) {
                for (var i = 0; i < objTable.rows.length; i++) {

                    
                    var chk = objTable.rows[i].cells[0].childNodes[0];

                    if (chk.checked) {
                        objTable.deleteRow(i);
                        if(chk.getAttribute("data") != null){
                            var arquivos_deletados = document.getElementById('jform[arquivos_deletados]').value;
                            if(arquivos_deletados == ''){
                                document.getElementById('jform[arquivos_deletados]').value = chk.getAttribute("data");
                            } else {
                                 arquivos_deletados += "*"+chk.getAttribute("data");
                                 document.getElementById('jform[arquivos_deletados]').value = arquivos_deletados;
                            }
                        }
                        iRow--;
                        i--;
                        counter = counter + 1;
                    }
                }

                if (counter == 0) {
                    alert("Selecione a linha que deseja excluir.");
                }

            }else{
                alert("Não há linhas sendo adicionadas.");
            }
        }


        removeLinha = function(classe_linha){
            items = $('.'+classe_linha).treegrid('getChildNodes').length;
            if(items == 0)
            {
                $('.'+classe_linha).treegrid('remove');
                classTree++;
            }
            else
            {
                alert('Não é possivel remover esse item, pois o mesmo tem intens depedente dele');
            }
            
        }

        adicionaLinhaRaiz = function(){
            classTree++;
            var linha = '';
            var numItems = $("tr[class*='treegrid-']").length + classTree; //$("tr[class*='treegrid-']").length + 2; ou $('#tblSample').treegrid('getAllNodes')
            var classe_pai_apas = "'treegrid-"+numItems+"'";
            var classe_pai = "treegrid-"+numItems;
            var dataEAtual = new Date().toLocaleString();
            var dataAtual  = dataEAtual.substring(0, dataEAtual.length - 3);
            var username   = $('#username').val();
            var nivel = numItems+'-'+0;
            console.log(numItems);
            linha += '<tr class="expanded '+classe_pai+'">';
            linha += '<td><input name="jform[titulos][]" value="" onchange="checaTitulo(this)" type="text">';
            linha += '<input name="jform[parent_id][]" value="1" type="hidden"><input name="jform[nivel][]" value="'+nivel+'" type="hidden"></td>';
            linha += '<input name="jform[old_arquivos][]" id="jform[old_arquivos]['+numItems+']" value="" type="hidden">';
            linha += '<input id="tipo-'+numItems+'" name="jform[tipo][]" id="tipo-<?php echo $i; ?>" value="1" type="hidden">';
            linha += '<td>'+dataAtual+'</td>'; 
            linha += '<td>'+username+'</td>';
            linha += '<td>';
            linha += '<div id="arquivo-'+numItems+'">';
            linha += '<button class="btn btn-small button-new" onclick="troca('+numItems+', 2)" type="button"><span class="icon-shuffle"> </span></button>';
            linha += ' <input onchange="edit('+numItems+')" name="jform[arquivo][]" id="jform[arquivos]['+numItems+']" value="" onchange="checaMimeType(this)" type="file">()';
            linha += '</div>';
            linha += '<div id="url-'+numItems+'">';
            linha += '<button class="btn btn-small button-new" onclick="troca('+numItems+', 1)" type="button"><span class="icon-shuffle"> </span></button>';
            linha += ' <input name="jform[url][]" id="jform[urls][<?php echo $i; ?>]" value="" type="text">';
            linha += '</div></td>';
            linha += '<td> <input class="btn btn-small button-new btn-danger" id="btnDelete" value="- Remover Linha" onclick="removeLinha('+classe_pai_apas+')" type="button"> <input class="btn btn-small button-new btn-success adicionaLinhaFilha" value="+ Adicionar Linha" onclick="adicionaLinhaFilha('+classe_pai_apas+')" data-pai="1" type="button"> </td>';
            linha += '</tr>';

            $('.tree').treegrid('add', [linha]);
            $("#arquivo-"+numItems).show();
            $("#url-"+numItems).hide();
        }

        adicionaLinhaFilha = function(classe_pai_id){
            classTree++;
            var depth = $('.'+classe_pai_id).treegrid('getDepth');
            if(depth < 3){
                var linha  = '';
                var numItems = $("tr[class*='treegrid-']").length + classTree;

                var classe_pai_apas = "'treegrid-"+numItems+"'";
                var classe_pai = "treegrid-"+numItems;
                var dataEAtual = new Date().toLocaleString();
                var dataAtual  = dataEAtual.substring(0, dataEAtual.length - 3);
                var username   = $('#username').val();

                var parent_id = classe_pai_id.split("-")[1];
                var nivel = numItems+'-'+parent_id;

                console.log(nivel);

                linha += '<tr class="expanded '+classe_pai+' treegrid-parent-'+classe_pai_id+'">';
                linha += '<td><input name="jform[titulos][]" value="" type="text"><input name="jform[parent_id][]" value="'+parent_id+'" type="hidden"><input name="jform[nivel][]" value="'+nivel+'" type="hidden"></td>';
                linha += '<input name="jform[old_arquivos][]" id="jform[old_arquivos]['+numItems+']" value="" type="hidden">';
                linha += '<input id="tipo-'+numItems+'" name="jform[tipo][]" id="tipo-<?php echo $i; ?>" value="1" type="hidden">';
                linha += '<td>'+dataAtual+'</td>'; 
                linha += '<td>'+username+'</td>';
                linha += '<td>';
                linha += '<div id="arquivo-'+numItems+'">';
                linha += '<button class="btn btn-small button-new" onclick="troca('+numItems+', 2)" type="button"><span class="icon-shuffle"> </span></button>';
                linha += ' <input onchange="edit('+numItems+')" name="jform[arquivo][]" id="jform[arquivos]['+numItems+']" value="" onchange="checaMimeType(this)" type="file">()';
                linha += '</div>';
                linha += '<div id="url-'+numItems+'">';
                linha += '<button class="btn btn-small button-new" onclick="troca('+numItems+', 1)" type="button"><span class="icon-shuffle"> </span></button>';
                linha += ' <input name="jform[url][]" id="jform[urls][<?php echo $i; ?>]" value="" type="text">';
                linha += '</div></td>';
                linha += '<td> <input class="btn btn-small button-new btn-danger" id="btnDelete" value="- Remover Linha" onclick="removeLinha('+classe_pai_apas+')" type="button"> <input class="btn btn-small button-new btn-success adicionaLinhaFilha" value="+ Adicionar Linha" onclick="adicionaLinhaFilha('+classe_pai_apas+')" data-pai="1" type="button"> </td>';
                linha += '</tr>';

                $('.'+classe_pai_id).treegrid('add', [linha]);
                $("#arquivo-"+numItems).show();
                $("#url-"+numItems).hide();
            }else{
                alert('Esse item não pode ter um filho.');
            }
            
        }



    });
})(jQuery);