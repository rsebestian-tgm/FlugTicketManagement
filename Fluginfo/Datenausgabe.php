<html>
  <head>
    <title> Flugdatenbank</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="materialize.css">
  <head>
  </head>
  <body class="green lighten-4">
    <?php
    $servername = "localhost";
    $dbname = "flightdata";
    $username = "kruehrig";
    $password = "1234";

    try {
      //Stellt die Verbindung her
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "<div  class='center'><h7>Database connected successfully</h7></div>";
      //Bilden der Flugnummer (für ausgabe)
      $stmt = $conn -> prepare("SELECT * FROM flights WHERE airline LIKE :airlinecode AND flightnr=:flightnumber");
      $stmt -> bindParam(":airlinecode", $airlinecode);
      $stmt -> bindParam(":flightnumber", $flightnumber);
      //holt sich die eingabe aus dem Textfeld von FlugnummerSuche.php
      $input = $_GET["flugnr"];
      //Teilt die Eingabe in airlinecode und flugnummer ein und fügt ihn zusammen
      $airlinecode = substr($input, 0, 2);
      $flightnumber = substr($input, 2, 5);
      $stmt -> execute();
      if($stmt -> rowCount() > 0){
        $flight = $stmt -> fetch();
        $start_apc = $flight[3];
        $dest_apc = $flight[5];
      }
      ?>

    <div class="container white">
      <div class="row">
        <div class="col s12 center">
          <h4><b>Fluginformationen</b></h4>
        </div>
        <div class="col s12 center bold">
          <h6>Flugnummer: <?php echo strtoupper($airlinecode); echo strtoupper($flightnumber); ?></h6>
        </div>
      </div>
      <div class="row center">
        <div class="col s12">
          <table class="responsive-table highlight bordered">
            <thead>
              <tr>
                <th>Abflug</th>
                <th>Ankunft</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <?php
                  //Gibt das Abflugs Land aus
                  echo "Land: ";
                  $result = $conn -> query("SELECT country FROM airports WHERE airportcode LIKE '$start_apc'");
                  $row = $result -> fetch();
                  $start_cc = $row[0];
                  $result = $conn -> query("SELECT name FROM countries WHERE code LIKE '$start_cc'");
                  $row = $result -> fetch();
                  echo $row[0];
                  echo "<br>";
                  //Gint die Abflugs Stadt aus
                  echo "Stadt: ";
                  $result = $conn -> query("SELECT city FROM airports WHERE airportcode LIKE '$start_apc'");
                  $row = $result -> fetch();
                  echo $row[0];
                  echo "<br>";
                  //Gibt den Abflugs Flughafen aus
                  echo "Fluhafen: ";
                  $result = $conn -> query("SELECT name FROM airports WHERE airportcode LIKE '$start_apc'");
                  $row = $result -> fetch();
                  echo $row[0];
                  echo "<br>";
                  //Gibt das Abflugs Datum aus
                  echo "Datum: ";
                  $result = $conn -> query("SELECT EXTRACT(DAY FROM departure_time), EXTRACT(MONTH FROM departure_time), EXTRACT(YEAR FROM departure_time) FROM flights WHERE airline LIKE '$airlinecode' AND flightnr = $flightnumber");
                  $row = $result -> fetch();
                  echo str_pad($row[0], 2, "0", STR_PAD_LEFT) . "." . str_pad($row[1], 2, "0", STR_PAD_LEFT) . "." . $row[2];
                  echo "<br>";
                  //Gibt die Abflugs Zeit aus
                  echo "Uhrzeit: ";
                  $result = $conn -> query("SELECT EXTRACT(HOUR FROM departure_time), EXTRACT(MINUTE FROM departure_time), EXTRACT(SECOND FROM departure_time) from flights WHERE airline LIKE '$airlinecode' AND flightnr = $flightnumber");
                  $row = $result -> fetch();
                  echo str_pad($row[0], 2, "0", STR_PAD_LEFT) . ":" . str_pad($row[1], 2, "0", STR_PAD_LEFT) . ":" . str_pad($row[2], 2, "0", STR_PAD_LEFT);
                  ?>
                </td>
                <td>
                  <?php
                  //Gibt das Ankunfts Land aus
                  echo "Land: ";
                  $result = $conn -> query("SELECT country FROM airports WHERE airportcode LIKE '$dest_apc'");
                  $row = $result -> fetch();
                  $dest_cc = $row[0];
                  $result = $conn -> query("SELECT name FROM countries WHERE code LIKE '$dest_cc'");
                  $row = $result -> fetch();
                  echo $row[0];
                  echo "<br>";
                  //Gint die Ankunfts Stadt aus
                  echo "Stadt: ";
                  $result = $conn -> query("SELECT city FROM airports WHERE airportcode LIKE '$dest_apc'");
                  $row = $result -> fetch();
                  echo $row[0];
                  echo "<br>";
                  //Gibt den Ankunfts Flughafen aus
                  echo "Flughafen: ";
                  $result = $conn -> query("SELECT name FROM airports WHERE airportcode LIKE '$dest_apc'");
                  $row = $result -> fetch();
                  echo $row[0];
                  echo "<br>";
                  //Gibt das Ankunfts Datum aus
                  echo "Datum: ";
                  $result = $conn -> query("SELECT EXTRACT(DAY FROM destination_time), EXTRACT(MONTH FROM destination_time), EXTRACT(YEAR FROM destination_time) FROM flights WHERE airline LIKE '$airlinecode' AND flightnr = $flightnumber");
                  $row = $result -> fetch();
                  echo str_pad($row[0], 2, "0", STR_PAD_LEFT) . "." . str_pad($row[1], 2, "0", STR_PAD_LEFT) . "." . $row[2];
                  echo "<br>";
                  //Gibt die Ankunfts Zeit aus
                  echo "Uhrzeit: ";
                  $result = $conn -> query("SELECT EXTRACT(HOUR FROM destination_time), EXTRACT(MINUTE FROM destination_time), EXTRACT(SECOND FROM destination_time) from flights WHERE airline LIKE '$airlinecode' AND flightnr = $flightnumber");
                  $row = $result -> fetch();
                  echo str_pad($row[0], 2, "0", STR_PAD_LEFT) . ":" . str_pad($row[1], 2, "0", STR_PAD_LEFT) . ":" . str_pad($row[2], 2, "0", STR_PAD_LEFT);
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
          <br>
          <h4><b>Passagiere</b></h4>
          <table class="responsive-table highlight bordered">
            <thead>
              <tr>
                <th>
                   Vorname
                 </th>
                 <th>
                   Nachname
                 </th>
                 <th colspan="2">
                   Sitznummer
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              //Gibt jeden Passagier in eine eigene Tabellenreihe aus
              $result = $conn -> query("SELECT firstname, lastname, rownr, seatposition, id FROM passengers WHERE airline LIKE '$airlinecode' AND flightnr = $flightnumber ORDER BY 3 ASC, 4 ASC");
              while($row = $result -> fetch()){
                echo '<form action="PassagierEntfernen.php" method="POST">';
                echo '<tr><td>'.$row[0].'</td>';
                echo '<td>'.$row[1].'</td>';
                echo '<td>'.$row[2].$row[3].'</td>';
                echo '<td><button type="submit" class="btn wave-effect red darken-1">Entfernen<i class="mdi-content-clear right"></i></button></td>';
                echo '<td style="visibility:hidden;"><input type="text" name="passagier_id" value="'.$row[4].'"></td>';
                echo '</tr>';
                echo '</form>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php
    }
  catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  ?>
  </body>
</html>
