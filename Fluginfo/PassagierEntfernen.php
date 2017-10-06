<?php
    $hostname = 'localhost';
    $dbname = 'flightdata';
    $username = 'kruehrig';
    $password = '1234';
    $passagier_id = $_POST['passagier_id'];
    try {
      //Stellt die Verbindung zur Datenbank her
      $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //Sucht den Passagier mit der zu löschenden ID
      $result = $conn -> query("SELECT airline, flightnr FROM passengers WHERE id=$passagier_id");
      $row = $result -> fetch();
      $flugnr = $row[0] . $row[1];
      //Löscht den Passagier mit der richtigen ID
      $conn -> query("DELETE FROM passengers WHERE id=$passagier_id");
      header("Location: Datenausgabe.php?flugnr=$flugnr");
    } catch(Exception $e){
        echo "Error: " . $e -> getMessage();
    }
?>
