 <h4 class="mb-3">Formulário Eletrónico de Triagem do Risco Infecioso aos Pacientes Admitidos</h4>
  <form action="insert_triagem_pacientes_transferidos.php" method="POST">
<!-- Checkboxes para cada fator -->
    <div class="form-check mb-2">
      <input class="form-check-input fator" type="checkbox" id="antibiotico">
      <label class="form-check-label" for="antibiotico">Antibiótico amplo espectro ≥48h nos últimos 60-90 dias</label>
    </div>

    <div class="form-check mb-2">
      <input class="form-check-input fator" type="checkbox" id="uci">
      <label class="form-check-label" for="uci">Internamento em UCI &gt; 48h</label>
    </div>

    <div class="form-check mb-2">
      <input class="form-check-input fator" type="checkbox" id="dispositivo">
      <label class="form-check-label" for="dispositivo">Dispositivo invasivo presente</label>
    </div>

    <div class="form-check mb-2">
      <input class="form-check-input fator" type="checkbox" id="viagem">
      <label class="form-check-label" for="viagem">Viagem a área de alto risco MDR</label>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input fator" type="checkbox" id="colonizacao">
      <label class="form-check-label" for="colonizacao">Colonização previamente conhecida</label>
    </div>

    <!-- Campo Tier calculado automaticamente -->
    <div class="mb-3">
      <label class="form-label fw-bold">Tier (calculado automaticamente)</label>
      <input type="text" class="form-control" id="tier" value="Baixo" readonly>
    </div>

    <button type="submit" class="btn btn-primary">Submeter</button>
  </form>