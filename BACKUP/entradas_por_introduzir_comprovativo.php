

                  <?php

                      try
                        {
                          $query = $db->query("SELECT entrada_id, crente_fk, crente.crente_nome, entradas.igreja_fk, igreja.igreja_nome, autonomia_fk, autonomia.autonomia_nome, entradas.provincia_fk, ada_provincia.ada_provincia_nome, tipo_entrada_fk, tipo_origem_fk, valor_total, produto_fk, produto_qtd, pruduto_qtd_unidade, descricao, data_entrada, dt_actualizacao, projecto_fk, projecto.projecto_nome, estado_fk, comprovativo, registou, alterou, data_actualizacao, metas_fk
                           FROM entradas
                          INNER join crente on crente.crente_id = entradas.crente_fk
                          INNER join igreja on igreja.igreja_id = entradas.igreja_fk
                          INNER JOIN autonomia on autonomia.autonomia_id = entradas.autonomia_fk
                          INNER JOIN ada_provincia on ada_provincia.ada_provincia_id = entradas.provincia_fk
                          inner join projecto on projecto.projecto_id = entradas.projecto_fk
                          WHERE registou = $user_id and comprovativo like 'Não Identificado'
                          order by entrada_id desc");
                  

                          $rowCount = $query->num_rows;

                          //Display cities list
                          if($rowCount > 0){

                            ?>
                            <div class="pagetitle">
                              <h1>Minhas entradas por introduzir comprovativo</h1>

                              <nav>
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="index.php">Ínicio</a></li>
                                  <li class="breadcrumb-item">Listar</li>
                                  <li class="breadcrumb-item active">Entradas</li>
                                </ol>
                              </nav>
                            </div><!-- End Page Title -->

                            <section class="section">
                              <div class="row">
                                <div class="col-lg-12">

                                  <div class="card">
                                    <div class="card-body">
                                      <h5 class="card-title">Introduzir</h5>
                                      <p>Comprovativo de deposito ou transferencias</p>

                                      <!-- Table with stripped rows -->
                                      <form class="" action="" enctype="multipart/form-data" method="POST">


                                      <table class="table table-sm datatable">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Igreja</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Projecto</th>
                                            <th scope="col">Justificativo</th>

                                          </tr>
                                        </thead>
                                        <tbody>
                            <?php

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

                                    <td><?php echo number_format($row['valor_total'],2)." ".$row['pruduto_qtd_unidade'];?></td>
                                    <td><?php echo $row['descricao'];?></td>
                                    <td><?php echo $row['data_entrada'];?></td>
                                    <td><?php echo $row['projecto_nome'];?></td>
                                    <td><input type="checkbox" id="id_comprovativo"  name="input_comprovativo[]" value="<?php echo $row['entrada_id'];?>"></td>
                                    <td>
                                      <a href="editar.php?id=<?php echo $row['entrada_id'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="apagar_registo.php?id=<?php echo $row['entrada_id'];?>"  id="apagar"  class="remove" data-toggle="tooltip" data-placement="left" title="Apagar"  onclick="if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
                                    </td>

                                </tr>
                    <?php
                              }
                              ?>
                              </tbody>
                            </table>

              <div class="row">


                            <div class="col-md-6">
                                <div class="col-md-12">
                                <div class="form-floating">
                                  <input class="form-control" type="file" name="comprovativo" required id="formFile" placeholder="Comprovativo de deposito">
                                  <label for="dorDescricao">Comprovativo</label>
                              </div>
                              </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="col-md-12">
                                  <div class="form-floating">
                              <div class="text-center">
                                <button type="submit" name="upload" class="btn btn-primary">Introduzir Comprovativo</button>
                                <button type="reset" class="btn btn-secondary">Cancelar</button>
                              </div>
                            </div>
                            </div>  </div>

              </div>
                            <!-- End Table with stripped rows -->
                            </form>

                          </div>
                        </div>

                      </div>
                    </div>
                  </section>

                  <?php
                          }}
                                  catch(Exception $e)
                                  {
                                  echo "Erro:\n".$e->getMessage();
                                  }

                    ?>