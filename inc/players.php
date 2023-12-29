<?php

if ($_POST["action"] == "generateSquad") {
  require('querys.php');

  $lineup = $_POST['lineup'];

  $squad = array(
    "Goalkeepers" => getGK(),
    "Backs" => getCB(6),
    "RightBacks" => getSB('R'),
    "LeftBacks" => getSB('L'),
    "CentralMF" => getCMF(),
    "RighMF" => getSM('R'),
    "LeftMF" => getSM('L'),
    "AttackMF" => getAMF(),
    "Fowards" => getCF()
  );

  echo json_encode($squad);
}

?>