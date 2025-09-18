<?php
//Include database configuration file
require_once('dbconnect.php');


//verificar se escolheu a especialidade
if(isset($_POST["id_input_regiao"]) && !empty($_POST["id_input_regiao"]))
{
    //Get all state data
    $regiao_fk=$_POST["id_input_regiao"];

    $query =$db->query("SELECT ada_provincia_id, ada_provincia_nome FROM ada_provincia
              WHERE ada_regiao_fk =$regiao_fk ORDER BY ada_provincia_nome asc");
                $rowCount = $query->num_rows;
                  if($rowCount > 0){

      echo '<option value="">-- Selecione o Centro--</option>';
        while($row = $query->fetch_assoc())
        {
         $ada_provincia_id= $row["ada_provincia_id"];
          $ada_provincia_nome= $row["ada_provincia_nome"];

        echo '<option value="'.$ada_provincia_id.'" data-toggle="tooltip" data-placement="left">'.$ada_provincia_nome.'</option>';
        }
    }else{
        echo '<option value="">Nenhuma Provincia / Centro registado</option>';
    }
}



if(isset($_POST["id_input_provincia"]) && !empty($_POST["id_input_provincia"])){
    //Get all city data
$provincia_fk =$_POST["input_provincia"];
    $query = $db->query("SELECT crente_id, crente_nome, sexo_fk, email, telefone, cargo_fk, ministerio_fk, igreja_fk, igreja.igreja_nome, ada_provincia.ada_provincia_nome FROM `crente`
                          inner join igreja on igreja.igreja_id = crente.igreja_fk
                          inner join ada_provincia on ada_provincia.ada_provincia_id = igreja.ada_provincia_fk
                          where ada_provincia.ada_provincia_id =$provincia_fk ORDER BY crente.crente_nome ASC;");

                    //Count total number of rows
                    $rowCount = $query->num_rows;

                    //Display cities list
                    if($rowCount > 0){
                        echo '<option value="">-- Agenda do médico ---</option>';
                        while($row = $query->fetch_assoc()){
                            echo '<option value="'.$row['crente_id'].'">'.$row['crente_nome'].'</option>';
                        }
                    }else{
                        echo '<option value="">Nenhum Crente registado</option>';
                    }

    }





$db->close();
?>
