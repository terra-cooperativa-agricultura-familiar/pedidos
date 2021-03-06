<?php  
  require  "common.inc.php"; 
  verifica_seguranca($_SESSION[PAP_RESP_MUTIRAO]);
  top();
?>

<?php

		$action = request_get("action",-1);
		if($action==-1) $action=ACAO_EXIBIR_LEITURA;

		 $est_cha=request_get("est_cha",-1);
		 if($est_cha==-1)
		 {
			 if(isset($_SESSION['cha_id_pref']))
			 {
				$est_cha=$_SESSION['cha_id_pref'];	 
			 }
		 }
		 $_SESSION['cha_id_pref']=$est_cha;	
		
		
		if ($est_cha<>-1) 
		{
		  $sql = "SELECT prodt_nome, DATE_FORMAT(cha_dt_entrega,'%d/%m/%Y') cha_dt_entrega, cha_taxa_percentual, ((cha_dt_prazo_contabil is null) OR (cha_dt_prazo_contabil > now() ) ) as cha_dentro_prazo, date_format(cha_dt_prazo_contabil,'%d/%m/%Y %H:%i') cha_dt_prazo_contabil ";
		  $sql.= "FROM chamadas LEFT JOIN produtotipos ON prodt_id = cha_prodt ";
		  $sql.= "WHERE cha_id = " . prep_para_bd($est_cha);
		  
			 
			 		  
 		  $res = executa_sql($sql);
  	      if ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
		  {				  
			$prodt_nome = $row["prodt_nome"];
			$cha_dt_entrega = $row["cha_dt_entrega"];
			$cha_taxa_percentual = $row["cha_taxa_percentual"];
			$cha_dt_prazo_contabil = $row["cha_dt_prazo_contabil"];
			$cha_dentro_prazo = $row["cha_dentro_prazo"];			 
		   }		   
		   
		   
		}	
		
		
		
				
		if ($action == ACAO_SALVAR) // salvar formulário preenchido
		{
			
			// salva disponibilidade de produtos
			$n = isset($_REQUEST['est_prod']) ? sizeof($_REQUEST['est_prod']) : 0;
			
			for($i=0;$i<$n;$i++)
			{
				$est_cha_bd = prep_para_bd($est_cha);
				$qtde_depois_bd = $_REQUEST['est_prod_qtde_depois'][$i] <>"" ? prep_para_bd(formata_numero_para_mysql($_REQUEST['est_prod_qtde_depois'][$i])) : 'NULL';
				$obs_depois_bd = $_REQUEST['est_obs_depois'][$i] <>"" ? prep_para_bd($_REQUEST['est_obs_depois'][$i]) : 'NULL';
				$sql = "INSERT INTO estoque (est_cha, est_prod, est_prod_qtde_depois, est_obs_depois ) ";
				$sql.= "VALUES ( " . $est_cha_bd . " ," . prep_para_bd($_REQUEST['est_prod'][$i]) . ", ";
				$sql.= $qtde_depois_bd . ", " . $obs_depois_bd . ") ";
				$sql.= "ON DUPLICATE KEY UPDATE ";
				$sql.= " est_prod_qtde_depois = " . $qtde_depois_bd . ", ";
				$sql.= " est_obs_depois = " . $obs_depois_bd . " ";
				$res = executa_sql($sql);			
				
			}

			

			if($res)
			{
				$action=ACAO_EXIBIR_LEITURA; //volta para modo visualização somente leitura
				adiciona_mensagem_status(MSG_TIPO_SUCESSO,"As informações de estoque relacionado à chamada " . $cha_dt_entrega . " foram salvas com sucesso.");								
			}
			else
			{
				adiciona_mensagem_status(MSG_TIPO_ERRO,"Erro ao tentar salvar informações de estoque da chamada para o dia " . $cha_dt_entrega . ".");								
			}
			escreve_mensagem_status();
		
		}
		
		if ($action == ACAO_EXIBIR_LEITURA || $action == ACAO_EXIBIR_EDICAO )  // exibir para visualização, ou exibir para edição
		{
			
		}	


	
		
?>

<ul class="nav nav-tabs">
  <li><a href="mutirao.php">Mutirão</a></li>
  <li><a href="estoque_pre.php"><i class="glyphicon glyphicon-bed"></i> Estoque Pré-Mutirão</a></li>
  <li><a href="recebimento.php"><i class="glyphicon glyphicon-road"></i> Recebimento</a></li>
  <li><a href="distribuicao_consolidado_por_produtor.php"><i class="glyphicon glyphicon-fullscreen"></i> Distribuição</a></li>  
  <li class="active"><a href="#"><i class="glyphicon glyphicon-bed"></i> Estoque Pós-Mutirão</a></li>  
  <li><a href="mutirao_divergencias.php"><i class="glyphicon glyphicon-eye-open"></i> Divergências</a></li>
</ul>
<br>

  <div class="panel panel-default">
  <div class="panel-heading">
     <strong>Estoque Pós-Mutirão</strong>

  </div>
  
<?php 
 if($action==ACAO_EXIBIR_LEITURA)  //visualização somente leitura
 {
 ?>	  
  
  <div class="panel-body">
 
 <form class="form-inline"  method="get" name="frm_filtro" id="frm_filtro">
	<?php  

	?>
     <fieldset>

     	<div class="form-group">
  				<label for="est_cha">Chamada: </label>            
                 <select name="est_cha" id="est_cha" onchange="javascript:frm_filtro.submit();" class="form-control">
                 	<option value="-1">SELECIONE</option>
                    <?php
                        
                       $sql = "SELECT cha_id, prodt_nome, cha_dt_entrega cha_dt_entrega_original, DATE_FORMAT(cha_dt_entrega,'%d/%m/%Y') cha_dt_entrega ";
                        $sql.= "FROM chamadas LEFT JOIN produtotipos ON prodt_id = cha_prodt ";
						$sql.= "WHERE prodt_mutirao = '1' ";
                        $sql.= "ORDER BY cha_dt_entrega_original DESC LIMIT 10";
						
                        $res = executa_sql($sql);
                        if($res)
                        {
						  $achou=false;
						  while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
                          {							
                             echo("<option value='" . $row['cha_id'] . "'");
                             if($row['cha_id']==$est_cha) 
							 {
								 echo(" selected");
								 $achou=true;
							 }
                             echo (">" . $row['prodt_nome'] . " - " . $row['cha_dt_entrega'] . "</option>");
                          }
						  if($est_cha!=-1 && !$achou)
						  {
							  $sql = "SELECT cha_id, prodt_nome, cha_dt_entrega cha_dt_entrega_original, DATE_FORMAT(cha_dt_entrega,'%d/%m/%Y') cha_dt_entrega ";
							  $sql.= "FROM chamadas LEFT JOIN produtotipos ON prodt_id = cha_prodt ";
							  $sql.= "WHERE cha_id = " . prep_para_bd($est_cha);
							  $res2 = executa_sql($sql);
							  $row = mysqli_fetch_array($res2,MYSQLI_ASSOC);
							  if($row)
							  {
								  echo("<option value='" . $row['cha_id'] . "' selected>");
								  echo ($row['prodt_nome'] . " - " . $row['cha_dt_entrega'] . "</option>");	
							  }
						  }
						  
                        }
                    ?>                        
                 </select>  
                 <?php 
				   if($est_cha!=-1)
				   {
					 ?>  
                    &nbsp;&nbsp;
                    <label for="cha_dt_prazo_contabil">Prazo para Edição: </label>   <?php echo($cha_dt_prazo_contabil?$cha_dt_prazo_contabil:"ainda não configurado"); ?>
					
					<?php 
                        if(!$cha_dentro_prazo)
                        {
                            echo("<span class='alert alert-danger'>(encerrado)</span>");
                        }
				   }
				 ?>
                 
                 
    
    	</div>                 
         </fieldset>
    </form>
    
        
    
   </div> 
   
  
  
   
				<?php
                  
					
				if($est_cha!=-1)
				{
					
					$sql = "SELECT prod_id, prod_nome,  prod_unidade, SUM(dist_quantidade) as soma_distribuido, chaprod_recebido, ";
					$sql.= " IFNULL(est_prod_qtde_antes,0) + IFNULL(chaprod_recebido,0) - IFNULL(SUM(dist_quantidade),0) as restante, est_prod_qtde_depois, est_obs_depois, ";
					$sql.= "est_prod_qtde_antes, est_prod_qtde_depois, est_obs_depois, ";
					$sql.= "chaprod_prod, forn_nome_curto, forn_nome_completo, forn_id ";
					$sql.= " FROM chamadaprodutos ";
                    $sql.= "LEFT JOIN produtos on chaprod_prod = prod_id ";
                    $sql.= "LEFT JOIN chamadas on chaprod_cha = cha_id ";  
                    $sql.= "LEFT JOIN fornecedores on prod_forn = forn_id ";
					$sql.= "LEFT JOIN estoque on est_cha = cha_id AND est_prod = chaprod_prod ";
					$sql.="LEFT JOIN distribuicao ON dist_cha = chaprod_cha AND dist_prod = chaprod_prod ";												
                    $sql.= "WHERE prod_ini_validade<=NOW() AND prod_fim_validade>=NOW() ";
					$sql.= "AND chaprod_cha = " . prep_para_bd($est_cha) . " AND chaprod_disponibilidade > 0 ";
					$sql.= "GROUP BY prod_id, prod_nome, prod_unidade, est_prod_qtde_antes, est_prod_qtde_depois, est_obs_depois, chaprod_prod, forn_nome_curto, forn_nome_completo, forn_id ";				
                    $sql.= "ORDER BY forn_nome_curto, prod_nome, prod_unidade ";		
					$res = executa_sql($sql);	
					
					  
                    if($res && mysqli_num_rows($res)==0)
					{
					?>	

                    <div class="panel-body">
                    <!--
					<button type="button" class="btn btn-default btn-enviando" data-loading-text="importando..." onclick="javascript:location.href='estoque_pos.php?action=<?php echo(ACAO_EXIBIR_LEITURA);?>&est_cha=<?php echo($est_cha); ?>&importar=sim'">
            <i class="icon glyphicon glyphicon-resize-small"></i> importar estoque do último mutirão
            </button>
            -->
            <br /><div class='well'> Sem produtos em estoque. Se de fato houver, clique em editar para registrar. </div><br />
            </div>
					
					<?php
					}
					else if($res)
                    {

						?>
            
            
                       	<table class="table table-striped table-bordered table-condensed table-hover">
                           <thead>
 <tr>
                            <th colspan="6">Informações de Estoque Pós-Mutirão da Entrega de <?php echo($prodt_nome . " - " . $cha_dt_entrega); ?></th>
                            <th colspan="2">
                            <?php
							if($cha_dentro_prazo)
							{
							 ?>
                            <a class="btn btn-primary" href="estoque_pos.php?action=<?php echo(ACAO_EXIBIR_EDICAO); ?>&cha_id=<?php echo($est_cha); ?>"><i class="glyphicon glyphicon-edit"></i> editar</a>
							 <?php
							}	
							else
							{
								echo("&nbsp;");
							}
							?>					
                            </th>
                            

                            
                        </tr>                            
                            	
                           </thead>
                           <tbody>
                            
                  	   <?php

					   $ultimo_forn = "";
                       while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
                       {
						    if(!( ($row["est_prod_qtde_depois"]&& $row["est_prod_qtde_depois"]!=0) ||  $row["est_obs_depois"]  ||   $row["restante"]!=0 ) )
							{
								continue;								
							}
							
							if($row["forn_nome_curto"]!=$ultimo_forn)
							{
								$ultimo_forn = $row["forn_nome_curto"];
								
								?>
										<tr>
											<th>
											  <?php echo($row["forn_nome_curto"]);
											  adiciona_popover_descricao("",$row["forn_nome_completo"]);
											  ?>
                                            </th>
											<th>Unidade</th>
                                            <th>Estoque Pré-Mutirão Real</th>
                                            <th>Recebido</th>
                                            <th>Distribuído</th>                                            
											<th>Estoque Pós-Mutirão Esperado<?php adiciona_popover_descricao("Descrição", " = Estoque PréMutirão Real<br> + Recebido<br> - Distribuído"); ?></th>
											<th>Estoque Pós-Mutirão Real</th>
                                            <th>Observação</th>
										</tr>
								<?php
								
							}   
							
							?>
							<tr>                              
                            <td><?php echo($row["prod_nome"]);?></td>
                            <td><?php echo($row["prod_unidade"]); ?></td>
							<td>
                              <?php if($row["est_prod_qtde_antes"]) echo_digitos_significativos($row["est_prod_qtde_antes"]); else echo("&nbsp;"); ?>
                            </td>   
							<td>
                              <?php if($row["chaprod_recebido"]) echo_digitos_significativos($row["chaprod_recebido"]); else echo("&nbsp;"); ?>
                            </td>
							<td>
                              <?php if($row["soma_distribuido"]) echo_digitos_significativos($row["soma_distribuido"]); else echo("&nbsp;"); ?>
                            </td>                            
                            <td>
                              <?php if($row["restante"]) echo_digitos_significativos($row["restante"]); else echo("&nbsp;"); ?>
                            </td>      
                            <?php 
							  $classe="";
							  if($row["est_prod_qtde_depois"] != $row["restante"])
							  {
								  if(is_null($row["est_prod_qtde_depois"]))
								  {
									  if($row["restante"]!=0)
									  {
										  $classe="danger";
									  }									
								  }
								  else
								  {
									  $classe="danger";									  
								  }
							  }
							  if($classe=="danger")
							  {
								  if($row["est_obs_depois"]) $classe="info";
							  }
							?>
                                                  							
							<td class='<?php echo($classe);?>'>                            
                            <?php if($row["est_prod_qtde_depois"]) echo_digitos_significativos($row["est_prod_qtde_depois"]); else echo("&nbsp;"); ?>
                           </td> 
                            <td>
                            <?php echo( ($row["est_obs_depois"]) ? $row["est_obs_depois"] : "&nbsp;") ; ?>
                            </td>                              
                            </tr>
                             
							<?php

                       }
					   
					   echo("</tbody></table>");
                    } 
               
			      ?>   
                  
                  
                  </div> 
                  
                  <?php
                     if($est_cha!=-1 && $cha_dentro_prazo)
						{
					     ?>
         
				<div align="right">
         	 	<a class="btn btn-primary" href="estoque_pos.php?action=<?php echo(ACAO_EXIBIR_EDICAO); ?>&est_cha=<?php echo($est_cha); ?>"><i class="glyphicon glyphicon-edit glyphicon-white"></i> editar</a>
         	</div>
            			 <?php
						}
				
				} // fim if est_cha !=-1
				
						?>
                        
      
  
   
	
<?php 

	
 }
 else  //visualização para edição
 {

?>
    <form class="form-horizontal" method="post">

    
	<div class="panel-body">
    
             <div align="right">
                <button type="submit"  class="btn btn-primary btn-enviando" data-loading-text="salvando estoque...">
            <i class="glyphicon glyphicon-ok glyphicon-white"></i> salvar alterações</button>
                   &nbsp;&nbsp;
                   <button class="btn btn-default" type="button" onclick="javascript:location.href='estoque_pos.php?action=<?php echo(ACAO_EXIBIR_LEITURA); ?>&est_cha=<?php echo($est_cha); ?>';"><i class="glyphicon glyphicon-off"></i> descartar alterações</button>
                    </div>    
    </div>  
    
        
        <fieldset>
        
          <input type="hidden" name="est_cha" value="<?php echo($est_cha); ?>" />
          <input type="hidden" name="action" value="<?php echo(ACAO_SALVAR); ?>" />  
            
            <div class="form-group">
                 <div class="container">

				<?php
					$sql = "SELECT prod_id, prod_nome,  prod_unidade, SUM(dist_quantidade) as soma_distribuido, chaprod_recebido, ";
					$sql.= " IFNULL(est_prod_qtde_antes,0) + IFNULL(chaprod_recebido,0) - IFNULL(SUM(dist_quantidade),0) as restante, est_prod_qtde_depois, est_obs_depois, ";
					$sql.= "est_prod_qtde_antes, est_prod_qtde_depois, est_obs_depois, ";
					$sql.= "chaprod_prod, forn_nome_curto, forn_nome_completo, forn_id ";
					$sql.= " FROM chamadaprodutos ";
                    $sql.= "LEFT JOIN produtos on chaprod_prod = prod_id ";
                    $sql.= "LEFT JOIN chamadas on chaprod_cha = cha_id ";  
                    $sql.= "LEFT JOIN fornecedores on prod_forn = forn_id ";
					$sql.= "LEFT JOIN estoque on est_cha = cha_id AND est_prod = chaprod_prod ";
					$sql.="LEFT JOIN distribuicao ON dist_cha = chaprod_cha AND dist_prod = chaprod_prod ";												
                    $sql.= "WHERE prod_ini_validade<=NOW() AND prod_fim_validade>=NOW() ";
					$sql.= "AND chaprod_cha = " . prep_para_bd($est_cha) . " AND chaprod_disponibilidade > 0 ";
					$sql.= "GROUP BY prod_id, prod_nome, prod_unidade, est_prod_qtde_antes, est_prod_qtde_depois, est_obs_depois, chaprod_prod, forn_nome_curto, forn_nome_completo, forn_id ";				
                    $sql.= "ORDER BY forn_nome_curto, prod_nome, prod_unidade ";		
					$res = executa_sql($sql);	
					
					
				
					  
                    if($res)
                    {
						?>
						<table class='table table-striped table-bordered table-condensed table-hover'>
                        <thead>
                        <tr>
                        <th colspan="8">
							Informações de Estoque Pós-Mutirão relacionado à chamada de <?php echo($prodt_nome . " - " . $cha_dt_entrega); ?>
                            </th>
                         </tr>
                        </thead>
                        <tbody>
						  <tr>
                            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                            <td colspan="2">
                            <button type="button" class="btn btn-info" name="copia_produtos_pedido" id="copia_produtos_pedido" onclick="javascript:replicaDados('replica-origem','replica-destino');">
							  <i class="glyphicon glyphicon-paste"></i> replicar do estoque esperado
							</button>                                                        
                            </td>
                            <td>&nbsp;</td>
                        </tr>                           

        
        
        				<?php						

					   $ultimo_forn = "";
                       while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
                       {
							if($row["forn_nome_curto"]!=$ultimo_forn)
							{
								
								$ultimo_forn = $row["forn_nome_curto"];
								
								?>
										<tr>
											<th>
											  <?php echo($row["forn_nome_curto"]);
											  adiciona_popover_descricao("",$row["forn_nome_completo"]);
											  ?>
                                            </th>
											<th>Unidade</th>
                                            <th>Estoque Pré-Mutirão Real</th>
                                            <th>Recebido</th>
                                            <th>Distribuído</th>                                            
											<th>Estoque Pós-Mutirão Esperado<?php adiciona_popover_descricao("Descrição", " = Estoque PréMutirão Real<br> + Recebido<br> - Distribuído"); ?></th>
											<th>Estoque Pós-Mutirão Real</th>
                                            <th>Observação</th>                                            
										</tr>
								<?php
								
							}   
							
							?>
							<tr> 
                            <input type="hidden" name="est_prod[]" value="<?php echo($row["prod_id"]); ?>"/>
                             
                            <td><?php echo($row["prod_nome"]);?></td>
                            <td><?php echo($row["prod_unidade"]); ?></td>

        					<td>                            
                            <?php if($row["est_prod_qtde_antes"]) echo_digitos_significativos($row["est_prod_qtde_antes"],"0"); ?>                          
                            </td> 

                			<td>                            
                            <?php if($row["chaprod_recebido"]) echo_digitos_significativos($row["chaprod_recebido"],"0"); ?>                          
                            </td> 


                			<td>                            
                            <?php if($row["soma_distribuido"]) echo_digitos_significativos($row["soma_distribuido"],"0"); ?>                          
                            </td> 



							<td style="text-align:center">                            
 							<input type="hidden"  name="restante[]" class="replica-origem" value="<?php if($row["restante"]<0) echo("0"); else if($row["restante"]) echo_digitos_significativos($row["restante"],""); ?>">
                            <?php if($row["restante"]) echo_digitos_significativos($row["restante"],"0"); ?>                          
                            </td> 
                            
                            <td>
                            <input type="text" class="replica-destino form-control propaga-colar numero-positivo" style="font-size:18px; text-align:center;" value="<?php if($row["est_prod_qtde_depois"]) echo_digitos_significativos($row["est_prod_qtde_depois"],"0"); ?>" name="est_prod_qtde_depois[]" id="est_prod_qtde_depois_<?php echo($row["prod_id"]); ?>"/>
                            </td> 
                            <td>
							<input type="text" class="form-control" value="<?php if($row["est_obs_depois"]) echo($row["est_obs_depois"]); ?>" name="est_obs_depois[]" id="est_obs_depois_<?php echo($row["prod_id"]); ?>"/>
                            </td>                                                      							

                            </tr>
                             
							<?php

                       }
					   
					   echo("</tbody></table>");
                    } 
               
			      ?>             
                       
                 </div>  
            </div>
            
            
             <div align="right">
                <button type="submit"  class="btn btn-primary btn-enviando" data-loading-text="salvando estoque...">
            <i class="glyphicon glyphicon-ok glyphicon-white"></i> salvar alterações</button>
                   &nbsp;&nbsp;
                  <button class="btn btn-default" type="button" onclick="javascript:location.href='estoque_pos.php?action=<?php echo(ACAO_EXIBIR_LEITURA); ?>&est_cha=<?php echo($est_cha); ?>';"><i class="glyphicon glyphicon-off"></i> descartar alterações</button>
                    </div>    
      </fieldset> 
    </form>
 

    
    <?php   
	
   }

   footer();
?>
