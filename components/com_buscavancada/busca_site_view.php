<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php JHtml::_('bootstrap.framework'); ?>
<?php JHtml::_('jquery.ui'); ?>
<style>
.search-bar{
  display: none !important;
}
</style>
<div class="page-content">
<div class="row">
    <div class="mobile-four twelve columns">
      <div class="bloco-busca">

        <form class="search-form" id="form-busca-avancada">
          <input type="hidden" id="selected_category" name="selected_category">
            <div class="field" style="cursor:pointer !important">
                <input type="text" id="busca" name="busca" placeholder="buscar no portal" value="<?php echo $busca;?>" />
                <button id="botao_busca" class="btn-search"><i class="fa fa-search"></i></button>
            </div>

            <div class="row">
              <div class="four columns">
                <div class="right-sidebar" style="margin-top:1%; background: none !important;">

                        <div class="sidebar-box">
                            <h3 class="title text-uppercase">Aviso</h3>
                            <div class="content">
                                <ul style="background: none !important;">

                                  <?php foreach ($categorias_aviso as $categoria_aviso): ?>
                                      <li>
                                          <input id="content-<?php echo $categoria_aviso->id ?>" value="<?php echo $categoria_aviso->id ?>" type="checkbox" name="categ[]">
                                          <label for="content-<?php echo $categoria_aviso->id ?>"><?php echo $categoria_aviso->title ?></label>
                                      </li>
                                  <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-box">
                            <h3 class="title text-uppercase">Informes</h3>
                            <div class="content">
                                <ul style="background: none !important;">

                                  <?php foreach ($categorias_infor as $categoria_informe): ?>
                                      <li>
                                          <input id="content-<?php echo $categoria_informe->id ?>" value="<?php echo $categoria_informe->id ?>" type="checkbox" name="categ[]">
                                          <label for="content-<?php echo $categoria_informe->id ?>"><?php echo $categoria_informe->title ?></label>
                                      </li>
                                  <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-box">
                            <h3 class="title text-uppercase">Arquivo</h3>
                            <div class="content">
                                <ul style="background: none !important;">
                                  <?php foreach ($categorias_arquivo as $categoria_arquivo): ?>
                                      <li>
                                          <input id="content-<?php echo $categoria_arquivo->id ?>" value="<?php echo $categoria_arquivo->id ?>" type="checkbox" name="categ[]">
                                          <label for="content-<?php echo $categoria_arquivo->id ?>"><?php echo $categoria_arquivo->title ?></label>
                                      </li>
                                  <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-box">
                            <h3 class="title text-uppercase">Licitações - Modalidade</h3>
                            <div class="content">
                                <ul style="background: none !important;">
                                  <?php foreach ($categorias_licitacao as $categoria_licitacao): ?>
                                      <li>
                                          <input id="content-<?php $categorialicit = $categoria_licitacao->id; $categorialicit2 = 
                                          $categorialicit. "__"; echo $categorialicit2  ?>" value="<?php $categorialicit = $categoria_licitacao->id; $categorialicit2 = 
                                          $categorialicit. "__"; echo $categorialicit2 ?>" type="checkbox" name="categ[]">
                                          <label for="content-<?php $categorialicit = $categoria_licitacao->id; $categorialicit2 = 
                                          $categorialicit. "__"; echo $categorialicit2  ?>"><?php echo $categoria_licitacao->nome ?></label>
                                      </li>
                                  <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>


                        <div class="sidebar-box">
                            <h3 class="title text-uppercase">Conteúdo</h3>
                            <div class="content">
                                <ul style="background: none !important;">
                                  <?php foreach ($categorias_content as $categoria_content): ?>
                                      <li>
                                          <input id="content-<?php echo $categoria_content->id ?>" value="<?php echo $categoria_content->id ?>" type="checkbox" name="categ[]">
                                          <label for="content-<?php echo $categoria_content->id ?>"><?php echo $categoria_content->title ?></label>
                                      </li>
                                  <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                  </div>
              </div>

                <div class="eight columns">

                    <h3 class="title">Publicação entre:</h3>

                    <div class="field">
                        <label class="sr-only" for="nome">De:</label>
                        <input value="<?php echo $de;?>" class="required datainput datepicker"  type="text" id="de" name="de" placeholder="De:" />
                    </div>

                    <div class="field">
                        <label class="sr-only" for="nome">Para:</label>
                        <input value="<?php echo $para;?>" class="required datainput datepicker"  type="text" id="para" name="para" placeholder="Até:" />
                    </div>

                    <?php if(! empty($qtdResults)) : ?>
                      <div class="field">
                        <h3 class="title" style="margin-bottom:0px !important;margin-top:1%;"><?php echo $qtdResults ?> itens atendem ao seu critério.</h3>
                      </div>
                    <?php endif; ?>

                    <div class="resultado-list">
                        <?php foreach ($resultadoBusca as $resultadoBuscaAtual) : ?>
                            <article class="resultado-item">
                                <h2>
                                       <a href="index.php?option=com_aviso&id=<?php echo $resultadoBuscaAtual->id; ?>&catid=<?php echo $resultadoBuscaAtual->tipo; ?>" title="">
                                        <?php echo $resultadoBuscaAtual->title; ?>
                                    </a>
                                </h2>

                                <small class="data">publicado em <?php echo str2data($resultadoBuscaAtual->created); ?> - última atualização em <?php echo str2data($resultadoBuscaAtual->modified); ?></small>
                                <small class="category">CATEGORIA: <?php echo getCategoryById($resultadoBuscaAtual->tipo)->title ?></a></small>
                            </article>
                        <?php endforeach; ?>

                        <?php foreach ($resultadoBuscaArq as $resultadoBuscaAtualArq) : ?>
                            <article class="resultado-item">
                                <h2>
                                       <a href="images/media/<?php echo $resultadoBuscaAtualArq->arquivo; ?>" title="">
                                        <?php echo $resultadoBuscaAtualArq->title; ?>
                                    </a>
                                </h2>

                                <small class="data"></small>
                                <small class="category">CATEGORIA: <?php echo getCategoryById($resultadoBuscaAtualArq->catid)->title ?></a></small>
                            </article>
                        <?php endforeach; ?>

                        <?php foreach ($resultadoBuscaInfo as $resultadoBuscaAtualinfo) : ?>
                            <article class="resultado-item">
                                <h2>
                                    <a href="uploads/<?php echo $resultadoBuscaAtualinfo->arquivo; ?>" title="">
                                        <?php echo $resultadoBuscaAtualinfo->title; ?>
                                    </a>
                                    <small class="data">publicado em <?php echo str2data($resultadoBuscaAtualinfo->publicacao); ?> </small>
                                </h2>

                                <small class="data"></small>
                                <small class="category">CATEGORIA: <?php echo getCategoryById((int) $resultadoBuscaAtualinfo->tipo)->title ?></a></small>
                            </article>
                        <?php endforeach; ?>

                        <?php foreach ($resultadoBuscaCnt as $resultadoBuscaAtual) : ?>
                            <article class="resultado-item">
                                <h2>
                                       <a href="index.php?option=com_content&view=article&id=<?php echo $resultadoBuscaAtual->id; ?>&catid=<?php echo $resultadoBuscaAtual->catid; ?>" title="">
                                        <?php echo $resultadoBuscaAtual->title; ?>
                                    </a>
                                </h2>

                                <small class="data">publicado em <?php echo str2data($resultadoBuscaAtual->created); ?> - última atualização em <?php echo str2data($resultadoBuscaAtual->modified); ?></small>
                                <small class="category">CATEGORIA: <?php echo getCategoryById($resultadoBuscaAtual->catid)->title ?></a></small>
                            </article>
                        <?php endforeach; ?>

                        <?php foreach ($resultadoBuscaLicit as $resultadoBuscaAtualLicit) : ?>
                            <article class="resultado-item">
                                <h2>
                                       <a href="licitacoes?idLicitacao=<?php echo $resultadoBuscaAtualLicit->id; ?>" title="">
                                        <?php echo $resultadoBuscaAtualLicit->titulo; ?>
                                    </a>
                                </h2>

                                <small class="data">publicado em <?php echo str2data($resultadoBuscaAtualLicit->data_publicacao); ?></small>
                                <small class="category">CATEGORIA: Licitação</a></small>
                            </article>
                        <?php endforeach; ?>

                        <?php 
                        if( empty($resultadoBusca) && empty($resultadoBuscaArq) && empty($resultadoBuscaCnt) && empty($resultadoBuscaInfo) && empty($resultadoBuscaLicit)&& isset($_GET['busca']) ) : ?>
                          <header>
                            <span class="icon">
                              <i class="fa fa-exclamation-triangle"></i>
                            </span>
                              Nenhum resultado foi encontrado. Deseja realizar uma nova busca?
                            </header>
                            <script type="text/javascript">
                              jQuery.noConflict();
                              (function( $ ) {
                                $(function() {
                                  $( "#form-busca-avancada > div.field" ).first().remove();
                                });
                              })(jQuery);
                            </script>
                            <input type="hidden" id="selected_category" name="selected_category">
                              <div class="field" style="cursor:pointer !important">
                                  <input type="text" id="busca" name="busca" placeholder="buscar no portal" value="<?php echo $busca;?>" />
                                  <button id="botao_busca" class="btn-search"><i class="fa fa-search"></i></button>
                              </div>
                        <?php endif; ?>
                    </div>



                </div>



             </div>
             <div class="row">
               <div class="twelve columns">
               <div class="pagination" style="<?php if($totalPagina == 0) echo 'visibility:hidden' ?>">
                   <a class="btn" href="<?php echo JRoute::_("index.php?option=com_buscavancada&de=$de&para=$para&catid=$catid&busca=$busca&page=1"); ?>">
                     <i class="fa fa-backward" aria-hidden="true"></i>
                   </a>
                   <?php if($paginaAtual > 1): ?>
                        <a href="<?php echo mudaParamUrl($redirectUrl,"page=$paginaAnterior"); ?>" title="" class="btn btn-prev"><span>Anterior</span></a>
                   <?php endif; ?>
                   <?php for ($i=1; $i <= $totalPagina; $i++): ?>
                     <?php if($i != $paginaAtual && ($i>$paginaAtual-4) && ($i<$paginaAtual+4) ): ?>
                         <a href="<?php echo mudaParamUrl($redirectUrl,"page=$i"); ?>" class="item-pagination" title="<?php echo $i ?>"><?php echo $i ?></a>
                     <?php else: ?>
                           <?php if($i==$paginaAtual): ?>
                             <span class="current"><?php echo $i ?></span>
                           <?php endif; ?>
                    <?php endif; ?>
                  <?php endfor; ?>
                  <?php if($paginaAtual != $totalPagina): ?>
                     <a href="<?php echo mudaParamUrl($redirectUrl,"page=$paginaProxima"); ?>" title="" class="btn btn-next"><span>Próximo</span></a>
                   <?php endif; ?>
                   <a class="btn" href="<?php echo JRoute::_("index.php?option=com_buscavancada&de=$de&para=$para&catid=$catid&busca=$busca&page=$totalPagina"); ?>"><i class="fa fa-forward" aria-hidden="true"></i></a>
               </div>
               </div>
             </div>
        </form>
      </div>
    </div>
</div>



</div>
<script type="text/javascript">
  document.getElementById('content').className += ' busca resultado-busca';
</script>
<script>
var InputMaskDefaultMask = new (function() {
    return {
        Date: "99/99/9999",
        DateTime: "99/99/9999 99:99:99",
        DateTimeShort: "99/99/9999 99:99",
        Time: "99:99:99",
        TimeShort: "99:99",
        Ssn: "999-99-9999",
        Phone: "(999) 999-9999"
    };
});

var InputMaskDataType = new (function() {
    return {
        Date: 1,
        DateTime: 2,
        DateTimeShort: 3,
        Time: 4,
        TimeShort: 5
    };
});

var InputMask = (function() {
    "use strict";

    var formatCharacters = ["-", "_", "(", ")", "[", "]", ":", ".", ",", "$", "%", "@", " ", "/"];

    var maskCharacters = ["A", "9", "*"];

    var originalValue = "";

    var mask = null;

    var hasMask = false;

    var forceUpper = false;

    var forceLower = false;

    var useEnterKey = false;

    var validateDataType = false;

    var dataType = null;

    var keys = {
        asterisk: 42,
        zero: 48,
        nine: 57,
        a: 65,
        z: 90,
        backSpace: 8,
        tab: 9,
        delete: 46,
        left: 37,
        right: 39,
        end: 35,
        home: 36,
        numberPadZero: 96,
        numberPadNine: 105,
        shift: 16,
        enter: 13,
        control: 17,
        escape: 27,
        v: 86,
        c: 67,
        x: 88
    };

    var between = function(x, a, b) {
        return x && a && b && x >= a && x <= b;
    };

    var parseDate = function(value) {
        var now = new Date();

        var date = new Date(Date.UTC(
            now.getFullYear(),
            now.getMonth(),
            now.getDate(),
            now.getHours(),
            now.getMinutes(),
            now.getSeconds()
        ));

        if (value) {
            if (between(dataType, 1, 3)) {
                var tempDate = new Date(value);

                if (!isNaN(tempDate.getTime())) {
                    date = new Date(Date.UTC(
                        tempDate.getFullYear(),
                        tempDate.getMonth(),
                        tempDate.getDate(),
                        tempDate.getHours(),
                        tempDate.getMinutes(),
                        tempDate.getSeconds()
                    ));
                }
            } else {
                var timeSegments = value.split(":");

                var utcHours = timeSegments.length > 0 ? timeSegments[0] : 0;
                var utcMinutes = timeSegments.length > 1 ? timeSegments[1] : 0;
                var utcSeconds = timeSegments.length > 2 ? timeSegments[2] : 0;

                date.setUTCHours(utcHours, utcMinutes, utcSeconds);
            }
        }

        return date;
    };

    var getFormattedDateTime = function(value) {
        var date = parseDate(value);

        var day = date.getUTCDate() < 10 ? "0" + date.getUTCDate() : date.getUTCDate();
        var month = (date.getUTCMonth() + 1) < 10 ? "0" + (date.getUTCMonth() + 1) : (date.getUTCMonth() + 1);
        var year = date.getUTCFullYear();
        var hours = date.getUTCHours() < 10 ? "0" + date.getUTCHours() : date.getUTCHours();
        var minutes = date.getUTCMinutes() < 10 ? "0" + date.getUTCMinutes() : date.getUTCMinutes();
        var seconds = date.getUTCSeconds() < 10 ? "0" + date.getUTCSeconds() : date.getUTCSeconds();

        switch (dataType) {
        case 1:
            return month + "/" + day + "/" + year;
        case 2:
            return month + "/" + day + "/" + year + " " + hours + ":" + minutes + ":" + seconds;
        case 3:
            return month + "/" + day + "/" + year + " " + hours + ":" + minutes;
        case 4:
            return hours + ":" + minutes + ":" + seconds;
        case 5:
            return hours + ":" + minutes;
        default:
            return "";
        }
    };

    var getCursorPosition = function(element) {
        var position = 0;

        if (document.selection) {
            element.focus();

            var selectRange = document.selection.createRange();

            selectRange.moveStart("character", -element.value.length);

            position = selectRange.text.length;
        } else if (element.selectionStart || element.selectionStart === "0") {
            position = element.selectionStart;
        }

        return position;
    };

    var isValidCharacter = function(keyCode, maskCharacter) {
        var maskCharacterCode = maskCharacter.charCodeAt(0);

        if (maskCharacterCode === keys.asterisk) {
            return true;
        }

        var isNumber = (keyCode >= keys.zero && keyCode <= keys.nine) ||
        (keyCode >= keys.numberPadZero && keyCode <= keys.numberPadNine);

        if (maskCharacterCode === keys.nine && isNumber) {
            return true;
        }

        if (maskCharacterCode === keys.a && keyCode >= keys.a && keyCode <= keys.z) {
            return true;
        }

        return false;
    };

    var setCursorPosition = function(element, index) {
        if (element != null) {
            if (element.createTextRange) {
                var range = element.createTextRange();

                range.move("character", index);

                range.select();
            } else {
                if (element.selectionStart) {
                    element.focus();

                    element.setSelectionRange(index, index);
                } else {
                    element.focus();
                }
            }
        }
    };

    var removeCharacterAtIndex = function(element, index) {
        if (element.value.length > 0) {
            var newElementValue = element.value.slice(0, index) + element.value.slice(index + 1);

            element.value = newElementValue;

            if (element.value.length > 0) {
                setCursorPosition(element, index);
            } else {
                element.focus();
            }
        }
    };

    var insertCharacterAtIndex = function(element, index, character) {
        var newElementValue = element.value.slice(0, index) + character + element.value.slice(index);

        element.value = newElementValue;

        if (element.value.length > 0) {
            setCursorPosition(element, index + 1);
        } else {
            element.focus();
        }
    };

    var checkAndInsertMaskCharacters = function(element, index) {
        while (true) {
            var isMaskCharacter = formatCharacters.indexOf(mask[index]) > -1;

            var maskAlreadyThere = element.value.charAt(index) === mask[index];

            if (isMaskCharacter && !maskAlreadyThere) {
                insertCharacterAtIndex(element, index, mask[index]);
            } else {
                return;
            }

            index += 1;
        }
    };

    var checkAndRemoveMaskCharacters = function(element, index, keyCode) {
        if (element.value.length > 0) {
            while (true) {
                var character = element.value.charAt(index);

                var isMaskCharacter = formatCharacters.indexOf(character) > -1;

                if (!isMaskCharacter || index === 0 || index === element.value.length) {
                    return;
                }

                removeCharacterAtIndex(element, index);

                if (keyCode === keys.backSpace) {
                    index -= 1;
                }

                if (keyCode === keys.delete) {
                    index += 1;
                }
            }
        }
    };

    var validateDataEqualsDataType = function(element) {
        if (element == null || element.value === "") {
            return;
        }

        var date = parseDate(element.value);

        if (between(dataType, 1, 3)) {
            if (isNaN(date.getDate()) || date.getFullYear() <= 1000) {
                element.value = "";

                return;
            }
        }

        if (dataType > 1) {
            if (isNaN(date.getTime())) {
                element.value = "";

                return;
            }
        }
    }

    var onLostFocus = function(element) {
        if (element.value.length > 0) {
            if (element.value.length !== mask.length) {
                element.value = "";

                return;
            }

            for (var i = 0; i < element.value; i++) {
                var elementCharacter = element.value.charAt(i);
                var maskCharacter = mask[i];

                if (maskCharacters.indexOf(maskCharacter) > -1) {
                    if (elementCharacter === maskCharacter || maskCharacter.charCodeAt(0) === keys.asterisk) {
                        continue;
                    } else {
                        element.value = "";

                        return;
                    }
                } else {
                    if (maskCharacter.charCodeAt(0) === keys.a) {
                        if (elementCharacter.charCodeAt(0) <= keys.a || elementCharacter >= keys.z) {
                            element.value = "";

                            return;
                        }
                    } else if (maskCharacter.charCodeAt(0) === keys.nine) {
                        if (elementCharacter.charCodeAt(0) <= keys.zero || elementCharacter >= keys.nine) {
                            element.value = "";

                            return;
                        }
                    }
                }
            }

            if (validateDataType && dataType) {
                validateDataEqualsDataType(element);
            }
        }
    };

    var onKeyDown = function(element, event) {
        var key = event.which;

        var copyCutPasteKeys = [keys.v, keys.c, keys.x].indexOf(key) > -1 && event.ctrlKey;

        var movementKeys = [keys.left, keys.right, keys.tab].indexOf(key) > -1;

        var modifierKeys = event.ctrlKey || event.shiftKey;

        if (copyCutPasteKeys || movementKeys || modifierKeys) {

            return true;
        }

        if (element.selectionStart === 0 && element.selectionEnd === element.value.length) {
            originalValue = element.value;

            element.value = "";
        }

        if (key === keys.escape) {
            if (originalValue !== "") {
                element.value = originalValue;
            }

            return true;
        }

        if (key === keys.backSpace || key === keys.delete) {
            if (key === keys.backSpace) {
                checkAndRemoveMaskCharacters(element, getCursorPosition(element) - 1, key);

                removeCharacterAtIndex(element, getCursorPosition(element) - 1);
            }

            if (key === keys.delete) {
                checkAndRemoveMaskCharacters(element, getCursorPosition(element), key);

                removeCharacterAtIndex(element, getCursorPosition(element));
            }

            event.preventDefault();

            return false;
        }

        if (dataType && useEnterKey && key === keys.enter) {
            if (dataType >= 1 && dataType <= 5) {
                element.value = getFormattedDateTime();
            }

            event.preventDefault();

            return false;
        }

        if (element.value.length === mask.length) {
            event.preventDefault();

            return false;
        }

        if (hasMask) {
            checkAndInsertMaskCharacters(element, getCursorPosition(element));
        }

        if (isValidCharacter(key, mask[getCursorPosition(element)])) {
            if (key >= keys.numberPadZero && key <= keys.numberPadNine) {
                key = key - 48;
            }

            var character = event.shiftKey
                ? String.fromCharCode(key).toUpperCase()
                : String.fromCharCode(key).toLowerCase();

            if (forceUpper) {
                character = character.toUpperCase();
            }

            if (forceLower) {
                character = character.toLowerCase();
            }

            insertCharacterAtIndex(element, getCursorPosition(element), character);

            if (hasMask) {
                checkAndInsertMaskCharacters(element, getCursorPosition(element));
            }
        }

        event.preventDefault();

        return false;
    };

    var onPaste = function(element, event, data) {
        var pastedText = "";

        if (event != null && window.clipboardData && window.clipboardData.getData) {
            pastedText = window.clipboardData.getData("text");
        } else if (event != null && event.clipboardData && event.clipboardData.getData) {
            pastedText = event.clipboardData.getData("text/plain");
        } else if (data != null && data !== "") {
            pastedText = data;
        }

        if (pastedText != null && pastedText !== "") {
            for (var j = 0; j < formatCharacters.length; j++) {
                pastedText.replace(formatCharacters[j], "");
            }

            for (var i = 0; i < pastedText.length; i++) {
                if (formatCharacters.indexOf(pastedText[i]) > -1) {
                    continue;
                }

                var keyDownEvent = document.createEventObject ? document.createEventObject() : document.createEvent("Events");

                if (keyDownEvent.initEvent) {
                    keyDownEvent.initEvent("keydown", true, true);
                }

                keyDownEvent.keyCode = keyDownEvent.which = pastedText[i].charCodeAt(0);

                element.dispatchEvent ? element.dispatchEvent(keyDownEvent) : element.fireEvent("onkeydown", keyDownEvent);
            }
        }

        return false;
    };

    var formatWithMask = function(element) {
        var value = element.value;

        if (between(dataType, 1, 5)) {
            value = getFormattedDateTime(element.value);
        }

        element.value = "";

        if (value != null && value !== "") {
            onPaste(element, null, value);
        }
    };

    return {
        Initialize: function(elements, options) {
            if (!elements || !options) {
                return;
            }

            if (options.mask && options.mask.length > 0) {
                mask = options.mask.split("");
                hasMask = true;
            }

            if (options.forceUpper) {
                forceUpper = options.forceUpper;
            }

            if (options.forceLower) {
                forceLower = options.forceLower;
            }

            if (options.validateDataType) {
                validateDataType = options.validateDataType;
            }

            if (options.dataType) {
                dataType = options.dataType;
            }

            if (options.useEnterKey) {
                useEnterKey = options.useEnterKey;
            }

            [].forEach.call(elements, function(element) {
                element.onblur = function() {
                    if (!element.getAttribute("readonly") && hasMask) {
                        return onLostFocus(element);
                    }

                    return true;
                };

                element.onkeydown = function(event) {
                    if (!element.getAttribute("readonly")) {
                        return onKeyDown(element, event);
                    }

                    return true;
                };

                element.onpaste = function(event) {
                    if (!element.getAttribute("readonly")) {
                        return onPaste(element, event, null);
                    }

                    return true;
                }

                if (options.placeHolder) {
                    element.setAttribute("placeholder", options.placeHolder);
                }

                if (element.value.length > 0 && hasMask) {
                    formatWithMask(element);
                }
            });
        }
    };
});
</script>
<script>
  new InputMask().Initialize(document.querySelectorAll(".datainput"),{
    mask: InputMaskDefaultMask.Date
  });
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
jQuery.noConflict();
(function( $ ) {
  $(function() {

    $(".datepicker").datepicker({
      	dateFormat: 'dd/mm/yy',
      	dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
      	dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      	dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      	monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      	monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      	nextText: 'Próximo',
      	prevText: 'Anterior'
    });

    $("input:checkbox").on('click', function() {

      $('#selected_category').val($(this).val());

        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
          // the name of the box is retrieved using the .attr() method
          // as it is assumed and expected to be immutable
          var group = "input:checkbox[name='" + $box.attr("name") + "']";
          // the checked state of the group/box on the other hand will change
          // and the current value is retrieved using .prop() method
          $(group).prop("checked", false);
          $box.prop("checked", true);
        } else {
          $box.prop("checked", false);
        }
   });

    $('#form-busca-avancada').on('submit',function(event){
      event.preventDefault() ;
      event.stopPropagation();
   });

    $( "#botao_busca" ).click(function() {

        var categoria = $('#selected_category').val();
        var busca     = $('#busca').val();
        var de        = $('#de').val();
        var para      = $('#para').val();
        
        <?php
            $_categoria = $_GET['catid'];
            $_busca     = $_GET['busca'];
            $_de        = $_GET['de'];
            $_para      = $_GET['para'];

            $_html  = 'var url_categoria = "'.$_categoria.'";';
            $_html .= 'var url_busca = "'.$_busca.'";';
            $_html .= 'var url_de = "'.$_de.'";';
            $_html .= 'var url_para = "'.$_para.'";';

            echo($_html);
        ?>

        if(url_categoria != '' && categoria == ''){
            categoria = url_categoria;
        }

        // if(url_busca != '' && busca == ''){
        //     busca = url_busca;
        // } // este trecho foi comentado em virtude de um problema na busca avançada, onde
            //  a string não era limpa definitiva na busca(15/01/2019).
        
        window.location.href = 'index.php?option=com_buscavancada&de='+de+'&para='+para+'&catid='+categoria+'&busca='+busca;

     });
  });
})(jQuery);
</script>
<?php 
if($catid != '' && isset($catid))
{
?>
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function(event) {
    document.getElementById('content-<?php echo $catid ?>').checked = true;
    document.getElementById('content-<?php echo $catid ?>').setAttribute('checked', 'checked');
  });
</script>
<?php
}
?>
<style>
.resultado-item{
  margin-bottom:  0px !important;
}
.ui-datepicker-header{
  background-color: #FFDD00;
  /*background-color: #003859;*/
}
.ui-datepicker-title > span{
  color:#745E01 !important;
  font-family: 'Lato',sans-serif;
}
.ui-icon{
  color:#745E01 !important;
}
.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight{
  background-color: #FFDD00;
}
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover{
  background-color: #003859;
}
</style>
