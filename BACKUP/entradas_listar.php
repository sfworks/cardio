 <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Entradas</h5>
              <p>Encontre abaixo, a lista dos últimos registos</p>

              <!-- Table with stripped rows -->
              <table class="table table-sm datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Igreja</th>
                    <th scope="col">Tipo de entrada</th>
                    <th scope="col">Origem</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Data</th>
                    <th scope="col">Projecto</th>
                    <th scope="col">Estado</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                      try
                        {
                          if($user_perfil=="Administrator")
                          {
                          $sql = "SELECT entrada_id, crente_fk, crente.crente_nome, entradas.igreja_fk, igreja.igreja_nome, autonomia_fk, autonomia.autonomia_nome, entradas.provincia_fk, ada_provincia.ada_provincia_nome, tipo_entrada_fk, tipo_origem_fk, valor_total, produto_fk, produto_qtd, pruduto_qtd_unidade, descricao, data_entrada, dt_actualizacao, projecto_fk, projecto.projecto_nome, estado_fk, comprovativo, registou, alterou, data_actualizacao, metas_fk
                           FROM entradas
                          INNER join crente on crente.crente_id = entradas.crente_fk
                          INNER join igreja on igreja.igreja_id = entradas.igreja_fk
                          INNER JOIN autonomia on autonomia.autonomia_id = entradas.autonomia_fk
                          INNER JOIN ada_provincia on ada_provincia.ada_provincia_id = entradas.provincia_fk
                          inner join projecto on projecto.projecto_id = entradas.projecto_fk
                          order by entrada_id desc";
                        }
                        else {

                          if($user_perfil=='talento')
                          {
                            $sql = "SELECT entrada_id, crente_fk, crente.crente_nome, entradas.igreja_fk, igreja.igreja_nome, autonomia_fk, autonomia.autonomia_nome, entradas.provincia_fk, ada_provincia.ada_provincia_nome, tipo_entrada_fk, tipo_origem_fk, valor_total, produto_fk, produto_qtd, pruduto_qtd_unidade, descricao, data_entrada, dt_actualizacao, projecto_fk, projecto.projecto_nome, estado_fk, comprovativo, registou, alterou, data_actualizacao, metas_fk
                            FROM entradas
                           INNER join crente on crente.crente_id = entradas.crente_fk
                           INNER join igreja on igreja.igreja_id = entradas.igreja_fk
                           INNER JOIN autonomia on autonomia.autonomia_id = entradas.autonomia_fk
                           INNER JOIN ada_provincia on ada_provincia.ada_provincia_id = entradas.provincia_fk
                           inner join projecto on projecto.projecto_id = entradas.projecto_fk
                           WHERE ada_provincia.ada_provincia_id =$user_provincia_id and projecto_nome like '%talento%' and estado = 'Activo'
                           order by entrada_id desc";
                          }else {
                            # code...
                         
                              $sql = "SELECT entrada_id, crente_fk, crente.crente_nome, entradas.igreja_fk, igreja.igreja_nome, autonomia_fk, autonomia.autonomia_nome, entradas.provincia_fk, ada_provincia.ada_provincia_nome, tipo_entrada_fk, tipo_origem_fk, valor_total, produto_fk, produto_qtd, pruduto_qtd_unidade, descricao, data_entrada, dt_actualizacao, projecto_fk, projecto.projecto_nome, estado_fk, comprovativo, registou, alterou, data_actualizacao, metas_fk
                              FROM entradas
                              INNER join crente on crente.crente_id = entradas.crente_fk
                              INNER join igreja on igreja.igreja_id = entradas.igreja_fk
                              INNER JOIN autonomia on autonomia.autonomia_id = entradas.autonomia_fk
                              INNER JOIN ada_provincia on ada_provincia.ada_provincia_id = entradas.provincia_fk
                              inner join projecto on projecto.projecto_id = entradas.projecto_fk
                              WHERE ada_provincia.ada_provincia_id =$user_provincia_id
                              order by entrada_id desc";
                         }
                        }
                            $query = mysqli_query($db, "$sql");
                            $result = $db->query($sql);

                            while ($row = mysqli_fetch_array($query))
                              {
                                if($row['estado_fk']=="Aguarda Comprovativo")
                                {$btn="btn-danger";}
                                  else
                                 {$btn="btn-success";}


                     ?>
                                <tr>
                                    <td><h3><?php echo $row['entrada_id'];?></h3></td>
                                    <td><?php echo $row['crente_nome'];?></td>
                                    <td><?php echo $row['igreja_nome'];?></td>
                                    <td><?php echo $row['tipo_entrada_fk'];?></td>
                                    <td><?php echo $row['tipo_origem_fk'];?></td>
                                    <td><?php echo number_format($row['valor_total'],2)." ".$row['pruduto_qtd_unidade'];?></td>
                                    <td><?php echo $row['descricao'];?></td>
                                    <td><?php echo $row['data_entrada'];?></td>
                                    <td><?php echo $row['projecto_nome'];?></td>
                                    <td><span class="btn  btn-block <?php echo $btn;?>"><?php echo $row['estado_fk'];?></span></td>
                                    <td>
                                      <a href="<?php echo $row['comprovativo'];?>" target="_blank" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-eye" style="color:yellow"></i> </a></td>
                                    <td>
                                      <a href="entrada_editar.php?id=<?php echo $row['entrada_id'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="entrada_apagar.php?id=<?php echo $row['entrada_id'];?>" data-toggle="tooltip" data-placement="left" title="Apagar" onclick="geek(); return false"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
                                    </td>

                                </tr>
                    <?php
                              }
                          }
                                  catch(Exception $e)
                                  {
                                  echo "Erro:\n".$e->getMessage();
                                  }

                    ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>