<?php defined('_JEXEC') or die; ?>
<style>
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 10; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal-content {
    background-color: #fefefe;
    margin: auto;
    /*padding: 20px;*/
    border: 1px solid #888;
    width: 80%;
}
.close {
    /*color: #aaaaaa;*/
    color: #D91E18;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.mdl-left{
  background-color: #D91E18;
  min-height: 250px;
  line-height: 400px;
}
.mdl-left > center >  img{
  width: 40%;
  vertical-align: middle;
}
.mdl-right > h3{
  color:#D91E18;
  text-transform: uppercase;
  text-align: center;
  padding: 10px 0 5px 0;
  font-weight: bold;
}
.mdl-interna-icone > center > img{
  max-width: 80px;
  max-height: 80px;
}
.mdl-interna-icone{
  line-height: 120px;
}
.mdl-interna-desc >h4{
  text-transform: uppercase;
}
.mdl-left{
  height: 100%;
}
.modal-content > .row{
  height: auto;
  padding-bottom: 20px;
}
#maisAvisos{
  color: #745E01;
  text-decoration: none;
}
#maisAvisos:hover{
  color: #745Eff;
  font-weight: bold;
}
</style>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="row">
      <div class="mobile-four twelve columns mdl-right">
        <div style="text-align: center; margin-top: 5px; color: #745E01;">
          <strong>Aviso</strong>
        </div>
        <span class="close">&times;</span>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div class="modal-interna">
          <?php $contador = 0; ?>
           <?php foreach ($avisos as $aviso) : ?>
             <?php  $contador++; if($contador>2) break;?>
                <div class="modulo-noticias  page-content page-governo blog blog-list post post-header">
                  <div class="row">
                    <div class="mobile-four twelve columns">
                      <div class="blog-list">
                        <div class="post row" style="padding-bottom: 0px;">
                            <div class="post-img mobile-two two columns">
              									<figure>
              											<img src="<?php echo json_decode($avisoHelper::getCategoryById($aviso->tipo)->params)->image?>" alt="">
              									</figure>
                        		</div>
              							<div class="post-header mobile-two eight columns">
              									<small class="categories">
              											<a class="strong-brw" title=""><?php echo $avisoHelper::getCategoryById($aviso->tipo)->title ?></a>
              									</small>
              									<h2>
              											<a class="strong-yl" href="index.php?option=com_aviso&id=<?php echo $aviso->id ?>&catid=<?php echo $aviso->tipo ?>" title="">
                                      <?php echo $aviso->identificador ?> - <?php echo $aviso->titulo ?>
              											</a>
              									</h2>
              							</div>
              							<div class="post-footer mobile-four two columns">
                              <small>VALIDADE</small><br/>
              									<ul class="datetime">
              											<li>
                                        <span>
                													<i class="icon icon-calendar" style="float:none !important;"></i>
                                          <?php echo $avisoHelper::preparaData($aviso->validade)[0]; ?>
                                        </span>
                                        &nbsp;
                                        <span>
                                          <i class="icon icon-time" style="float:none !important;"></i>
                                          <?php echo $avisoHelper::preparaData($aviso->validade)[1]; ?>
                                        </span>
                                    </li>
              									</ul>
              							 </div>
            					    </div>
                      </div>
                    </div>
                </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 5px; color: #745E01;">
          <a id="maisAvisos" href="<?php echo JUri::base() . 'avisos';?>">+ Avisos</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
var modal = document.getElementById('myModal');
var btn   = document.getElementById("myBtn");
var span  = document.getElementsByClassName("close")[0];
modal.style.display = "block";

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
