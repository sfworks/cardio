<div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Crentes Registados | Província/Centro da  <?php echo $user_provincia_nome?></h5>
              <p>Encontre abaixo, a lista dos últimos registos</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Igreja</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Contactos</th>
                    
                    <th scope="col">Ministerio</th>
                    <!-- <th scope="col">Igreja</th> -->
                    <th scope="col"></th>
                    <th scope="col"></th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                      try
                        {

                          if($user_perfil=="Administrator")
                          {
                          $sql = "SELECT `crente_id`, `crente_nome`, `sexo_fk`, `email`, `telefone`, `cargo_fk`, `ministerio_fk`, `igreja_fk`, i.igreja_nome,p.ada_provincia_nome FROM `crente` c
                                  INNER join igreja i on i.igreja_id = c.igreja_fk
                                  inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
                                  INNER JOIN ada_regiao r on r.ada_regiao_id = p.ada_regiao_fk
                                  ORDER BY crente_id DESC";
                        }else {
                         
                          $sql = "SELECT `crente_id`, `crente_nome`, `sexo_fk`, `email`, `telefone`, `cargo_fk`, `ministerio_fk`, `igreja_fk`, i.igreja_nome,p.ada_provincia_nome FROM `crente` c
                                  INNER join igreja i on i.igreja_id = c.igreja_fk
                                  inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
                                  INNER JOIN ada_regiao r on r.ada_regiao_id = p.ada_regiao_fk
                                  where p.ada_provincia_id =$user_provincia_id
                                  ORDER BY crente_id DESC";
                        }
                       
                            $query = mysqli_query($db, "$sql");
                          
                            while ($row = mysqli_fetch_array($query))
                              {



                     ?>
                                <tr>
                                    <td><h3><?php echo $row['crente_id'];?></h3></td>
                                    <td><?php echo $row['cargo_fk'];?></td>
                                    <td><?php echo $row['crente_nome'];?></td>
                                    <td><?php echo  $row['ada_provincia_nome'].": ".$row['igreja_nome'];?></td>
                                    <td><?php echo $row['sexo_fk'];?></td>
                                    <td><?php echo $row['email'].'<br>'.$row['telefone'];?></td>

                                  
                                    <td><?php echo $row['ministerio_fk'];?></td>
                                    <!-- <td><?php //echo $row['igreja_nome'];?></td> -->
                                    <td>
                                      <a href="crente_editar.php?id=<?php echo $row['crente_id'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="crente_apagar.php?id=<?php echo $row['crente_id'];?>" onclick='return confirm_alert(this);' data-toggle="tooltip" data-placement="left" title="Apagar"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
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