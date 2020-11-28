<?php defined('_JEXEC') or die; ?>
<style type="text/css">
    h3.title {
    font-size: 16px !important;
    font-weight: 900!important;
    color: #003859!important;
    text-transform: uppercase!important;
    border-bottom: 1px solid #25aae1!important;
    padding-bottom: 5px!important;
    margin-bottom: 30px!important;
}

.a-title {
    color: #15407f!important;
    text-decoration: none!important;
    font-size: 14px!important;
    text-transform: uppercase!important;
    font-weight: 900!important;
}
</style>
<div class="internal page-governo governo-governador">
<div class="row">

        <div class="mobile-four eight columns">

            <div class="page-content">
                <?php echo $conteudo; ?>
            </div>
        </div>

        <div class="three push-one columns">
            <div class="right-sidebar">
                
                <?php if(! empty($dados)): ?>
                    <div class="sidebar-box">
                        <h3 class="title">Dados</h3>
                        <div class="content">
                             <?php echo $dados; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="sidebar-box">
                    <div class="fb-page" data-href="<?php echo $linkredesocias; ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $linkredesocias; ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $linkredesocias; ?>"><?php echo $nome; ?></a></blockquote></div>
                </div>
                <?php if(! empty($agendas)): ?>
                    <div class="sidebar-box">
                        <h3 class="title">Agenda do Governador</h3>
                        <div class="content">
                            <ul>
                                <?php foreach ($agendas as $agenda): ?>
                                    <li>
                                        <small><?php echo formataDataHora($agenda->data)[0]; ?></small>
                                        <h3><a class="a-title"><?php echo $agenda->titulo ?></a></h3>
                                        <p><strong>Horário: </strong><?php echo formataDataHora($agenda->data)[1]; ?></p>
                                    </li>
                                <?php endforeach; ?>
                                
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>