
<nav class="navbar navbar-expand-xl navbar-light bg-faded my-auto">
  <div class="my-auto">
    <a href="index.php">
      <img src="img/logo.png" style="height:70px" class="mr-2 img-responsive"/>
    </a>
    <span class="text-uppercase text-expanded mr-4 font-weight-bold text-secondary-color my-auto"><?php echo(NOME_SISTEMA); ?></span>
  </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse py-lg-2" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
          <?php
          if(isset($_SESSION['usr.id']) && $_SESSION['usr.id']!="")
          { ?>
            <li class="dropdown px-lg-4">
                <a href="#" class="dropdown-toggle nav-link text-uppercase text-expanded" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MENU CLIENTE <span class="caret"></span></a>
                <ul class="dropdown-menu">
            <?php
          } ?>
            <li class="nav-item nav-link active px-lg-4">
            <a href="quem_somos.php"><i class="glyphicon glyphicon-home"></i> Quem somos</a></li>
            </li>
            <li class="nav-item nav-link active px-lg-4">
            <a href="index.php"><i class="glyphicon glyphicon-home"></i> Comprar</a></li>
            </li>
            <li class="nav-item nav-link active px-lg-4">
            <a href="index.php"><i class="glyphicon glyphicon-home"></i> Agricultores</a></li>
            </li>
            <li class="nav-item nav-link active px-lg-4">
            <a href="index.php"><i class="glyphicon glyphicon-home"></i> Participe</a></li>
            </li>
            <li class="nav-item nav-link active px-lg-4">
            <a href="index.php"><i class="glyphicon glyphicon-home"></i> Projetos</a></li>
            </li>
            <?php
            if(isset($_SESSION['usr.id']) && $_SESSION['usr.id']!="")
            { ?>
                </ul>
              </li>
              <?php
            } ?>
           <?php
            if(isset($_SESSION['usr.id']) && $_SESSION['usr.id']!="")
            {
		          // menu de administração
        			if($_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_PEDIDO] || $_SESSION[PAP_RESP_NUCLEO]  || $_SESSION[PAP_RESP_MUTIRAO] || $_SESSION[PAP_ACOMPANHA_PRODUTOR] || $_SESSION[PAP_ACOMPANHA_RELATORIOS] || $_SESSION[PAP_RESP_ENTREGA] || $_SESSION[PAP_RESP_FINANCAS] )
        			{
              ?>
                 <li class="dropdown px-lg-4">
                     <a href="#" class="dropdown-toggle nav-link text-uppercase text-expanded" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ADM <span class="caret"></span></a>
                     <ul class="dropdown-menu">

      			  <?php
      			  	if($_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_PEDIDO])
      					{
      			   ?>
                    <li class="nav-item px-lg-4">
                      <a href="chamadas.php"><i class="glyphicon glyphicon-bell"></i> Chamadas</a>
                    </li>
                    <li class="nav-item px-lg-4">
                      <a href="pedidos.php"><i class="glyphicon glyphicon-shopping-cart"></i> Pedidos</a>
                    </li>
              <?php
      			  	}
      			  	if($_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_PEDIDO] || $_SESSION[PAP_RESP_NUCLEO] )
      					{
      			   ?>
                  <li class="nav-item px-lg-4">
                    <a href="nucleos.php"><i class="glyphicon glyphicon-th"></i> Núcleos</a>
                  </li>
                  <li class="nav-item px-lg-4">
                    <a href="cestantes.php"><i class="glyphicon glyphicon-user"></i> Cestantes</a>
                  </li>

      			  <?php
                }
      			  	if($_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_PEDIDO] || $_SESSION[PAP_ACOMPANHA_PRODUTOR] )
      					{
      			   ?>
                  <li class="nav-item px-lg-4">
                    <a href="produtores.php"><i class="glyphicon glyphicon-picture"></i> Produtores</a>
                  </li>
                  <li class="nav-item px-lg-4">
                    <a href="produtos.php"><i class="glyphicon glyphicon-leaf"></i> Produtos</a>
                  </li>
      	          <li class="divider"></li>
      	        <?php
      			  	}
    			  		if($_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_MUTIRAO] || $_SESSION[PAP_RESP_NUCLEO]   || $_SESSION[PAP_RESP_ENTREGA]  || $_SESSION[PAP_RESP_FINANCAS])
    					  {
                  if($_SESSION[PAP_ADM] ||  $_SESSION[PAP_RESP_MUTIRAO] )
                  {
                  ?>
                     <li class="nav-item px-lg-4">
                       <a href="mutirao.php"><i class="glyphicon glyphicon-wrench"></i> Mutirão</a>
                     </li>
                  <?php
                  }
                  if( $_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_ENTREGA]  || $_SESSION[PAP_RESP_FINANCAS] )
                  {
                  ?>
  			             <li class="nav-item px-lg-4">
                       <a href="entregas.php"><i class="glyphicon glyphicon-apple"></i> Entregas</a>
                     </li>
                  <?php
                  }
                  if( $_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_FINANCAS] )
                  {
                  ?>
    			           <li class="nav-item px-lg-4">
                       <a href="financas.php"><i class="glyphicon glyphicon-usd"></i> Finanças</a>
                     </li>
                  <?php
                  }
                  if( $_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_NUCLEO] || $_SESSION[PAP_RESP_ENTREGA] || $_SESSION[PAP_RESP_FINANCAS] )
                  {
                  ?>
                     <li class="nav-item px-lg-4">
                       <a href="cestantes_quadro.php"><i class="glyphicon glyphicon-th-list"></i> Quadro de Cestantes</a>
                     </li>
                  <?php
                  }
                  ?>
                  <li class="divider"></li>
              <?php
      			  	}
      			  	if($_SESSION[PAP_ADM] || $_SESSION[PAP_RESP_PEDIDO] || $_SESSION[PAP_RESP_NUCLEO] || $_SESSION[PAP_ACOMPANHA_PRODUTOR] || $_SESSION[PAP_ACOMPANHA_RELATORIOS] || $_SESSION[PAP_RESP_ENTREGA] || $_SESSION[PAP_RESP_FINANCAS] )
      					{
      			   ?>
                  <li class="nav-item px-lg-4">
                    <a href="relatorios.php"><i class="glyphicon glyphicon-list-alt"></i> Relatórios</a>
                  </li>
      	         	<li class="divider"></li>
                <?php
      			  	}
      			  	if($_SESSION[PAP_ADM])
      					{
      			    ?>
        					 <li class="nav-item px-lg-4">
                     <a href="administracao.php"><i class="glyphicon glyphicon-lock"></i> Administração</a>
                   </li>
                <?php
      			  	}
      			    ?>
                    </ul>
                  </li>
              <?php
              } 	// fim menu administração
           }
           ?>


          </ul>

          <ul class="navbar-nav navbar-right px-lg-4">
            <!--
            <li>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-shopping-cart">
                  <span class="cart-number">1</span>
                </i>
              </a>
            </li>-->
            <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Minha Conta <b class="caret"></b></a>
              <ul class="dropdown-menu py-0">
                <li class="nav-item nav-link py-lg-2">
                  <a href="meusdados.php"><i class="glyphicon glyphicon-star"></i> Meus Dados</a>
                </li>
                <?php
                 if(isset($_SESSION['usr.id']) && $_SESSION['usr.id']!="")
                 {  ?>
                   <li class="nav-item nav-link active px-lg-4">
                     <a href="meuspedidos.php"><i class="icon-pedidos-shopping-bag"></i> Meus Pedidos</a>
                   </li>
                   <li class="nav-item nav-link active px-lg-4">
                     <a href="contatos.php"><i class="glyphicon glyphicon-phone-alt"></i> Contatos</a>
                   </li>
                 <?php
                }
                ?>
			          <li class="nav-item nav-link py-lg-2">
                  <a href="senha_altera.php"><i class="glyphicon glyphicon-lock"></i> Alterar Senha</a>
                </li>
                <li class="divider"></li>
                <li class="nav-item nav-link py-lg-2">
                  <a href="login.php?logoff=sim"><i class="glyphicon glyphicon-arrow-left"></i> Sair (fazer logoff)</a>
                </li>
              </ul>
            </li>
          </ul>
        </div> <!-- /navbar-collapse -->
      </div> <!-- /container -->

  </nav><!-- /navbar -->
