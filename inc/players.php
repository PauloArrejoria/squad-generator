<?php

function sortSquad($squad)
{
  /* Code */
}

if ($_POST["action"] == "generateSquad") {
  require('querys.php');

  $lineup = $_POST['lineup'];

  if (strlen($lineup) == '3') {
    $forwardsCount = $lineup[2];
  } else if (strlen($lineup) == '4') {
    $forwardsCount = $lineup[3];
  }

  $squad = array(
    "Goalkeepers" => getGK(),
    "Defenders" => getDefenders($lineup[0]),
    "Midfielders" => getMidfielders($lineup),
    "Forwards" => getForwards($forwardsCount)
  );

  echo json_encode($squad);
}

?>