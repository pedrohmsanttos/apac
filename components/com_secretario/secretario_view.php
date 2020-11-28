<div id="content" class="internal page-governo secretarias">

    <div class="row">
        <div class="mobile-four  seven columns">
            <div class="page-content">

                <h3 class="title">Atribuíções</h3>
                <p>
                   <?php echo strip_tags($secretario->atribuicoes_secretaria, '<p><br><br/><strong>'); ?>
                </p>

                <h3 class="title">Sobre o Secretário</h3>
                <p>
                    <?php echo strip_tags($secretario->sobre_secretario, '<p><br><br/><strong>'); ?> 
                </p>

                <ul class="list-icons">
                    <li>
                        <span class="icon icon-globo"></span>
                        <a target="_blank" href="<?php echo $secretario->link_sitesecretaria ?>" title=""><?php echo $secretario->link_sitesecretaria ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="four push-one columns">
            <div class="right-sidebar">
                <div class="sidebar-box">
                    <h3 class="title">Secretário</h3>
                    <figure class="m-b-md"> 
                        <img src="<?php echo $secretario->imagem; ?>" />
                    </figure>
                    <div class="content">
                        <br/><br/>
                        <p>
                            <strong>Secretário:</strong><br/> 
                                <?php echo $secretario->nome_secretario; ?><br/><br/>
                            <strong>Endereço:</strong><br/> 
                                <?php echo strip_tags($secretario->endereco_secretario, '<p><br><br/><strong>'); ?>
                            <br/><br/>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>