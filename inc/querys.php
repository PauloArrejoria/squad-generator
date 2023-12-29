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

function getCMF()
{
  require("db.php");

  try {
    $midfielder = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'CMF' OR pos1 = 'DMF') ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 4;";
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
              WHERE (pos1 = '" . $side . "M' OR (pos1 = 'SM' AND foot = '" . $side . "') OR pos1 = '" . $side . "WF' OR (pos1 = 'WF' AND foot = '" . $side . "')) 
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

function getAMF()
{
  require("db.php");

  try {
    $midfielder = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'AMF' OR pos1 = 'SS') ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 4;";
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

function getCF()
{
  require("db.php");

  try {
    $centreFowards = array();
    $query = "SET @row_number = 0;  
                SET @current_name = NULL; 
                SELECT * FROM (SELECT *, @row_number := IF(@current_name = name, @row_number + 1, 1) AS row_num, @current_name := name FROM players WHERE (pos1 = 'CF' or (pos1 = 'SS' and pos2 = 'CF')) ORDER BY name, ovr DESC, speed DESC, teamwork DESC) AS ranked_players WHERE row_num = 1 ORDER BY ovr DESC, speed DESC, teamwork DESC LIMIT 4;";
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