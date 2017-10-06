<html>
  <head>
    <title> FlugnummerSuche </title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="materialize.css">
  </head>
  <body class="green lighten-4">
    <br>
    <br>
    <div class="container white z-depth-4">
      <br>
      <div class="row">
        <div class="col s3"></div>
        <div class="col s6 center">
          <h4 class="center">Flugnummer Suchen</h4>
        </div>
        <div class="col s3"></div>
      </div>
      <div class="row center">
        <form action="Datenausgabe.php" method="get">
          <div class="col s4">
          </div>
          <div class="col s4 input group center">
            <input type="text" class="form-control center" placeholder="Flugnummer" name="flugnr">
            <button type="submit" class="btn waves-effect green lighten-2">
              Suchen
            </button>
          </div>
          <div class="col s4"></div>
        </form>
      </div>
      <br>
    </div>
  </body>
</html>
