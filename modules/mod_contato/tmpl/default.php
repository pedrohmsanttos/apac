<?php defined('_JEXEC') or die; ?>
<div id="content" class="internal page-governo contato">
    <div class="row">
        <div class="mobile-four twelve columns">
            <div class="page-content">
                <h3 class="title">
                    <?php if(isset($msg1) || $msg1 != ''): 
                        echo($msg1);
                    else: ?>
                        Informe seus dados para que possamos responder sua mensagem
                    <?php endif; ?>
                </h3>
                <form id="form-contato" class="form-contato">
                    <div class="row">
                        <div class="six columns">
                            <div class="field">
                                <label class="sr-only" for="nome">Nome</label>
                                <input class="required"  type="text" id="nome" name="nome" placeholder="Nome*" />
                            </div>
                        </div>
                        <div class="six columns">
                            <div class="field">
                                <label class="sr-only" for="email">E-mail</label>
                                <input class="required"  type="text" id="email" name="email" placeholder="E-mail*" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="twelve columns">
                            <div class="field">
                                <input type="hidden" id="setor" name="setor" value="A definir" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="twelve columns">
                            <div class="field">
                                <label class="sr-only" for="mensagem">Mensagem</label>
                                <textarea name="mensagem" id="mensagem" rows="20" placeholder="Mensagem*"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="twelve columns">
                            <div class="field">
                                <button id="envia_contato" class="btn-submit" type="button">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
