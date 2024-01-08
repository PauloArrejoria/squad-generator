<?php

/* ---------- GoalKeepers ---------- */
function getGK()
{
  require("db.php");

  try {
    $goalkeepers = array();
    $query = "SELECT * FROM players WHERE (name, ovr) IN ( SELECT name, MAX(ovr) AS max_ovr FROM players GROUP BY name ) AND pos1 = 'GK' ORDER BY ovr DESC LIMIT 3;";
    $result = mysqli_query($link, $query);
    while ($gk = $result->fetch_array()) {
      $data = array(
        'pos' => 'GK',
        'name' => $gk['name'],
        'nat' => $gk['nat'],
        'age' => $gk['age'],
        'ovr' => $gk['ovr'],
        'speed' => $gk['speed'],
        'teamwork' => $gk['teamwork']
      );
      array_push($goalkeepers, $data);
    }
    $link->close();
  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $goalkeepers;
}

/* ---------- Defenders ---------- */

function getDefenders($countDefenders)
{
  $defenders = array();
  if ($countDefenders == 3) {
    $centralBacks = getCB(6);
    $defenders = $centralBacks;
  }
  if ($countDefenders == 4) {
    $centralBacks = getCB(4);
    $rightBacks = getSB('R');
    $leftBacks = getSB('L');
    $defenders = [...$centralBacks, ...$rightBacks, ...$leftBacks];
  }
  if ($countDefenders == 5) {
    $centralBacks = getCB(6);
    $rightBacks = getSB('R');
    $leftBacks = getSB('L');
    $defenders = [...$centralBacks, ...$rightBacks, ...$leftBacks];
  }

  return $defenders;

}

function getCB($limit)
{
  require("db.php");

  try {
    $goalkeepers = array();
    $query = "SELECT * FROM players WHERE (name, ovr) IN ( SELECT name, MAX(ovr) AS max_ovr FROM players GROUP BY name ) AND (pos1 = 'SWP' or pos1 = 'CB') ORDER BY ovr DESC LIMIT " . $limit . ";";
    $result = mysqli_query($link, $query);
    while ($cb = $result->fetch_array()) {
      $data = array(
        'pos' => 'CB',
        'name' => $cb['name'],
        'nat' => $cb['nat'],
        'age' => $cb['age'],
        'ovr' => $cb['ovr'],
        'speed' => $cb['speed'],
        'teamwork' => $cb['teamwork']
      );
      array_push($goalkeepers, $data);
    }
    $link->close();
  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $goalkeepers;
}

function getSB($side)
{
  require("db.php");

  try {
    $sideBack = array();
    $query = "SET @row_number = 0; 
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, 
                               @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, 
                               @current_name := name 
                               FROM players 
                               WHERE (pos1 = '" . $side . "B' OR (pos1 = 'SB' AND foot = '" . $side . "') OR pos1 = '" . $side . "WB' OR (pos1 = 'WB' AND foot = '" . $side . "')) 
                               ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players 
                WHERE row_num = 1 
                ORDER BY ovr DESC, speed DESC, teamwork DESC 
                LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => $side . 'B',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($sideBack, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $sideBack;
}

/* ---------- Midfielders ---------- */

function getMidfielders($lineup)
{
  $midfielders = array();

  /* 4-5-1 */
  if ($lineup == '451') {
    $defensiveMF = getDMF();
    $centralMF = getCMF();
    $rightMF = getSM('R');
    $leftMF = getSM('L');
    $attackMF = getAMF();
    $midfielders = [...$defensiveMF, ...$centralMF, ...$rightMF, ...$leftMF, ...$attackMF];
  }
  /* 3-4-3 */
  if ($lineup == '343') {
    $defensiveMF = getDMF();
    $centralMF = getCMF();
    $rightWB = getWB('R');
    $leftWB = getWB('L');
    $midfielders = [...$defensiveMF, ...$centralMF, ...$rightWB, ...$leftWB];
  }
  /* 3-5-2 */
  if ($lineup == '352') {
    $defensiveMF = getDMF();
    $centralMF = getCMF();
    $rightWB = getWB('R');
    $leftWB = getWB('L');
    $attackMF = getAMF();
    $midfielders = [...$defensiveMF, ...$centralMF, ...$rightWB, ...$leftWB, ...$attackMF];
  }
  /* 4-4-2 or 5-4-1 */
  if ($lineup == '442' || $lineup == '541') {
    $defensiveMF = getDMF();
    $centralMF = getCMF();
    $rightMF = getSM('R');
    $leftMF = getSM('L');
    $midfielders = [...$defensiveMF, ...$centralMF, ...$rightMF, ...$leftMF];
  }
  /* 4-3-1-2 or 3-3-1-3 or 5-3-1-1 */
  if ($lineup == '4312' || $lineup == '3313' || $lineup == '5311') {
    $defensiveMF = getDMF();
    $rightMF = getSM('R');
    $leftMF = getSM('L');
    $attackMF = getAMF();
    $midfielders = [...$defensiveMF, ...$rightMF, ...$leftMF, ...$attackMF];
  }
  /* 4-3-3 or 4-2-1-3 or 5-3-2 or 5-2-1-2 */
  if ($lineup == '433' || $lineup == '4213' || $lineup == '5212' || $lineup == '532') {
    $defensiveMF = getDMF();
    $centralMF = getCMF();
    $attackMF = getAMF();
    $midfielders = [...$defensiveMF, ...$centralMF, ...$attackMF];
  }

  return $midfielders;

}

function getDMF()
{
  require("db.php");

  try {
    $midfielder = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'DMF') ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => 'DMF',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($midfielder, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $midfielder;
}

function getCMF()
{
  require("db.php");

  try {
    $midfielder = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'CMF') ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => 'CMF',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($midfielder, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $midfielder;
}

function getWB($side)
{
  require("db.php");

  try {
    $sideBack = array();
    $query = "SET @row_number = 0; 
              SET @current_name = NULL; 
              SELECT * FROM (SELECT *, 
              @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, 
              @current_name := name 
              FROM players 
              WHERE (pos1 = '" . $side . "WB' OR (pos1 = 'WB' AND foot = '" . $side . "') OR pos1 = '" . $side . "B' OR (pos1 = 'SB' AND foot = '" . $side . "')) 
              ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players 
              WHERE row_num = 1 
              ORDER BY ovr DESC, speed DESC, teamwork DESC 
              LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => $side . 'WB',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($sideBack, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $sideBack;
}

function getSM($side)
{
  require("db.php");

  try {
    $sideBack = array();
    $query = "SET @row_number = 0; 
              SET @current_name = NULL; 
              SELECT * FROM (SELECT *, 
              @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, 
              @current_name := name 
              FROM players 
              WHERE (pos1 = '" . $side . "MF' OR (pos1 = 'SM' AND foot = '" . $side . "') OR pos1 = '" . $side . "WF' OR (pos1 = 'WF' AND foot = '" . $side . "')) 
              ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players 
              WHERE row_num = 1 
              ORDER BY ovr DESC, speed DESC, teamwork DESC 
              LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => $side . 'MF',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($sideBack, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $sideBack;
}

function getAMF()
{
  require("db.php");

  try {
    $midfielder = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'AMF' OR pos1 = 'SS') ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => 'AMF',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($midfielder, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $midfielder;
}

/* ---------- Fowards ---------- */

function getForwards($fowardsCount)
{
  $forwards = array();

  if ($fowardsCount == '1') {
    $centralFwd = getCF();
    $forwards = $centralFwd;
  }
  if ($fowardsCount == '2') {
    $secondStk = getSS();
    $centralFwd = getCF();
    $forwards = [...$secondStk, ...$centralFwd];
  }
  if ($fowardsCount == '3') {
    $rightWF = getWF('R');
    $leftWF = getWF('L');
    $centralFwd = getCF();
    $forwards = [...$rightWF, ...$leftWF, ...$centralFwd];
  }

  return $forwards;

}

function getWF($side)
{
  require("db.php");

  try {
    $sideBack = array();
    $query = "SET @row_number = 0; 
              SET @current_name = NULL; 
              SELECT * FROM (SELECT *, 
              @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, 
              @current_name := name 
              FROM players 
              WHERE (pos1 = '" . $side . "WF' OR (pos1 = 'WF' AND foot = '" . $side . "') OR pos1 = '" . $side . "MF' OR (pos1 = 'SM' AND foot = '" . $side . "')) 
              ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players 
              WHERE row_num = 1 
              ORDER BY ovr DESC, speed DESC, teamwork DESC 
              LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => $side . 'MF',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($sideBack, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $sideBack;
}

function getSS()
{
  require("db.php");

  try {
    $centreFowards = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'SS') ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => 'SS',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($centreFowards, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $centreFowards;
}

function getCF()
{
  require("db.php");

  try {
    $centreFowards = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'CF' or (pos1 = 'SS' and pos2 = 'CF')) ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 2;";
    /* execute multi query */
    if (mysqli_multi_query($link, $query)) {
      do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
          while ($row = mysqli_fetch_row($result)) {
            $data = array(
              'pos' => 'CF',
              'name' => $row[1],
              'nat' => $row[2],
              'age' => $row[3],
              'ovr' => $row[8],
              'speed' => $row[9],
              'teamwork' => $row[10]
            );
            array_push($centreFowards, $data);
          }
          mysqli_free_result($result);
        }
      } while (mysqli_next_result($link));
    }

  } catch (Exception $e) {
    echo "Error! : " . $e->getMessage();
    return false;
  }

  return $centreFowards;
}


?>