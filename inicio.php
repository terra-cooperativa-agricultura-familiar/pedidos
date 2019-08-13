<?php
  require  "common.inc.php";
  //verifica_seguranca();
  top();
?>
<div class="container">
<br />
<hr>
</div>
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
</ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block mx-auto" width="60%" src="img/paisagem-vieira.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block mx-auto" width="60%"  src="img/diego-agricultor.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block mx-auto" width="60%"  src="img/foto-inicio.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block mx-auto" width="60%"  src="img/paisagem-vieira-2.jpg" alt="Third slide">
    </div>
  </div>
</div>
<?php
	 //echo(get_texto_interno("txt_pagina_inicio"));

 	 footer();
?>
