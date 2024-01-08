<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SquadGenerator</title>
  <!-- Style -->
  <link rel="stylesheet" href="style.css" />
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <link />
</head>

<body class="app">
  <div class="filters">
    <div class="container-lg d-flex justify-content-around align-items-center">
      <label class="fw-bold text-white" for="lineup">Lineup: </label>
      <select name="lineup" id="lineup">
        <option value="451">4-5-1</option>
        <option value="442">4-4-2</option>
        <option value="4312">4-3-1-2</option>
        <option value="433">4-3-3</option>
        <option value="4213">4-2-1-3</option>
        <option value="352">3-5-2</option>
        <option value="343">3-4-3</option>
        <option value="3313">3-3-1-3</option>
        <option value="541">5-4-1</option>
        <option value="5311">5-3-1-1</option>
        <option value="532">5-3-2</option>
        <option value="5212">5-2-1-2</option>
      </select>
      <label class="fw-bold text-white" for="lineup">Nationality: </label>
      <select name="lineup" id="lineup">
        <option selected>Any</option>
        <option value="Uruguay">Uruguay</option>
        <option value="Italia">Italia</option>
        <option value="Brasil">Brasil</option>
        <option value="Inglaterra">Inglaterra</option>
        <option value="Argentina">Argentina</option>
        <option value="Francia">Francia</option>
        <option value="España">España</option>
        <option value="Alemania">Alemania</option>
      </select>
      <label class="fw-bold text-white" for="lineup">Min Age: </label>
      <input type="number" value="15" min="15" max="46" placeholder="15" />
      <label class="fw-bold text-white" for="lineup">Max Age: </label>
      <input type="number" value="46" min="15" max="46" placeholder="46" />
    </div>
    <button id="generate-squad" type="submit" class="btn btn-primary btn-generate">
      Generate Squad
    </button>
  </div>
  <div class="stats py-2 container-fluid">
    <div class="row d-flex align-items-center">
      <span class="fw-bold text-white col-3">Attack</span>
      <span class="fw-bold col-2 text-warning">92</span>
      <div class="col-7">
        <div class="progress">
          <div class="progress-bar bg-warning" role="progressbar" style="width: 92%" aria-valuenow="25"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="row d-flex align-items-center">
      <span class="fw-bold text-white col-3">Midfield</span>
      <span class="fw-bold col-2 text-warning">92</span>
      <div class="col-7">
        <div class="progress">
          <div class="progress-bar bg-warning" role="progressbar" style="width: 92%" aria-valuenow="25"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="row d-flex align-items-center">
      <span class="fw-bold text-white col-3">Defense</span>
      <span class="fw-bold col-2 ovr80-89">89</span>
      <div class="col-7">
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: 89%; background-color: #ffff00" aria-valuenow="25"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="row d-flex align-items-center">
      <span class="fw-bold text-white col-3">Speed</span>
      <span class="fw-bold col-2 ovr80-89">80</span>
      <div class="col-7">
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: 80%; background-color: #ffff00" aria-valuenow="25"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="row d-flex align-items-center">
      <span class="fw-bold text-white col-3">Teamwork</span>
      <span class="fw-bold col-2 ovr80-89">83</span>
      <div class="col-7">
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: 83%; background-color: #ffff00" aria-valuenow="25"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="ovr-container">
      <span class="text-white fw-bold ovr-font">
        Overall: <span class="text-warning">91</span>
      </span>
    </div>
  </div>
  <div class="teams container-fluid">
    <h2 class="text-white">Starting Team</h2>
    <table class="table players-table container-fluid">
      <thead>
        <tr>
          <th scope="col">Pos</th>
          <th scope="col">Name</th>
          <th scope="col">Nat</th>
          <th scope="col">Ovr</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-warning border border-warning rounded">GK</span>
          </td>
          <td>Ubaldo Fillol</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold text-danger">95</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-primary border border-primary rounded">CB</span>
          </td>
          <td>Daniel Passarella</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold text-warning">93</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-primary border border-primary rounded">CB</span>
          </td>
          <td>Roberto Perfumo</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold ovr80-89">87</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-primary border border-primary rounded">RB</span>
          </td>
          <td>Javier Zanetti</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold ovr80-89">88</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-primary border border-primary rounded">LB</span>
          </td>
          <td>Silvio Marzolini</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold ovr80-89">84</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-success border border-success rounded">DM</span>
          </td>
          <td>Fernando Redondo</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold text-warning">93</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-success border border-success rounded">CM</span>
          </td>
          <td>Diego Simeone</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold ovr80-89">83</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-success border border-success rounded">AM</span>
          </td>
          <td>Diego Maradona</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold text-danger">99</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-danger border border-danger rounded">SS</span>
          </td>
          <td>Mario Kempes</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold ovr80-89">87</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-danger border border-danger rounded">SS</span>
          </td>
          <td>Lionel Messi</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold text-danger">99</span></td>
        </tr>
        <tr>
          <td>
            <span class="pos fw-bold bg-opacity-50 bg-danger border border-danger rounded">CF</span>
          </td>
          <td>Gabriel Batistuta</td>
          <td>
            <img src="https://flagcdn.com/ar.svg" width="30" alt="ar" />
          </td>
          <td><span class="fw-bold text-warning">91</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
<script src="main.js"></script>

</html>