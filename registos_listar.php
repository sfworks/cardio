<div class="row">
  <?php
      if(isset($_SESSION['msg_participante'])) {
          echo '<br>' . $_SESSION['msg_participante'];
          unset($_SESSION['msg_participante']);
        }
  ?>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">

        <?php 
    

        $valor_pagar=0;
                $valor_pago=0;
                $ultima_data=0;
        ?>

        <h5 class="card-title">Registo de Participantes</h5>

        <table class="table table-sm datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Idade</th>
              <th>Instituição</th>
              <th>Categoria</th>
              <th>Especialidade</th>
              <th>Data de Registo</th>
              <th>Estado</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            try {
              $sql = "SELECT * FROM registo WHERE user_id = '".$user_id."' ORDER BY registo_id DESC";
              $query = $db->query($sql);

              while ($row = $query->fetch_assoc()) {
                $btn = ($row['estado'] == "Pago") ? "btn-success" : "btn-warning";

                // Captura especialidade
                $especialidade = '';
                if ($row['categoria'] == 'Médico Especialista') {
                  $especialidade = $row['especialidade_especialista'];
                } elseif ($row['categoria'] == 'Médico Residente') {
                  $especialidade = $row['especialidade_residente'];
                }

                $valor_pagar=$row['valor_pagar'];
                $valor_pago=$row['valor_pago'];
                $ultima_data=$row['data_pagamento'];

                echo "<tr>
                  <td>{$row['registo_id']}</td>
                  <td>{$row['nome']}</td>
                  <td>{$row['idade']}</td>
                  <td>{$row['instituicao']}</td>
                  <td>{$row['categoria']}</td>
                  <td>{$especialidade}</td>
                  <td>{$row['data_registo']}</td>
                  <td><span class='btn btn-sm $btn'>{$row['estado']}</span></td>
                  <td>
                    <a href='#' data-bs-toggle='modal' data-bs-target='#modalPagamento{$row['registo_id']}' data-toggle='tooltip' title='Efetuar Pagamento'><i class='fas fa-paperclip text-success'></i></a>
                    <a href='delete_participante.php?registo_id={$row['registo_id']}' onclick='return confirm(\"Deseja realmente apagar este registo?\")' data-toggle='tooltip' title='Apagar'><i class='fas fa-trash-alt text-danger'></i></a>
                  </td>

                  <!-- Modal de Pagamento -->
                  <div class='modal fade' id='modalPagamento{$row['registo_id']}' tabindex='-1' aria-labelledby='pagamentoLabel{$row['registo_id']}' aria-hidden='true'>
                    <div class='modal-dialog'>
                      <form method='POST' action='upload_comprovativo.php' enctype='multipart/form-data'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='pagamentoLabel{$row['registo_id']}'>Efetuar Pagamento</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fechar'></button>
                          </div>
                          <div class='modal-body'>
                            <input type='hidden' name='registo_id' value='{$row['registo_id']}'>

                            <div class='mb-3'>
                              <label class='form-label'>Valor a pagar</label>
                              <input type='number' step='0.01' class='form-control' name='valor_pago' value='{$row['valor_pagar']}' readonly>
                            </div>

                            <div class='mb-3'>
                              <label class='form-label'>Comprovativo de Pagamento</label>
                              <input type='file' class='form-control' name='comprovativo' accept='.pdf,.jpg,.jpeg,.png' required>
                            </div>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                            <button type='submit' class='btn btn-success'>Confirmar Pagamento</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </tr>";
              }
            } catch (Exception $e) {
              echo "<tr><td colspan='12'>Erro ao carregar dados: " . $e->getMessage() . "</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bloco de Informações sobre Pagamento -->
<div class="row mt-4">
  <div class="col-md-4">
    <div class="card border-danger">
      <div class="card-header bg-danger text-white">Informações de Pagamento</div>
      <div class="card-body">

      <p><strong>Total a Pagar:</strong> <?php echo $valor_pagar; ?> MZN <br>
        <strong>Total Pago:</strong> <?php echo $valor_pago; ?> MZN <br>
        <strong>Última Atualização:</strong> <?php echo $ultima_data; ?>
      </p>       

        <hr>

         <p><strong>E-Mola:</strong><br>
        Número: <em>870112230</em><br>
        Titular: <em>Fidelio Sitefane</em></p>      

        <hr>
         
        <p><strong>Banco: FNB</strong><br>
        Titular da Conta: <em>Catarina Edith Muianga</em><br>
        Número da Conta: <em>2186216210001</em><br>
        NIB: <em>001400002186216210119</em><br>
        IBAN: <em>MZ59001400002186216210119</em><br>
        SWIFT Code: <em>FIRNMZMX</em><br>
        Referência: <strong>Inscrição RCSCV</strong></p>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Notas sobre Pagamento</div>
      <div class="card-body">
        <p>Após efetuar o pagamento via <strong>E-Mola</strong> ou <strong>Transferência Bancária</strong>, anexe o comprovativo no sistema utilizando o botão <i class='fas fa-paperclip text-success'></i> de pagamento ao lado do seu registo.</p>
        <p>Certifique-se de usar a referência correta: <strong>Inscrição RCSCV</strong>.</p>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.datatable').DataTable({
      language: {
        "sEmptyTable": "Nenhum dado disponível na tabela",
        "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registos",
        "sInfoEmpty": "Mostrando 0 até 0 de 0 registos",
        "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
        "sInfoPostFix": "",
        "sInfoThousands": ",",
        "sLengthMenu": "Mostrar _MENU_ registos",
        "sLoadingRecords": "A carregar...",
        "sProcessing": "A processar...",
        "sSearch": "Pesquisar:",
        "sZeroRecords": "Nenhum registo correspondente encontrado",
        "oPaginate": {
          "sFirst": "Primeiro",
          "sLast": "Último",
          "sNext": "Seguinte",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": ordenar a coluna de forma ascendente",
          "sSortDescending": ": ordenar a coluna de forma descendente"
        }
      }
    });
  });
</script>
