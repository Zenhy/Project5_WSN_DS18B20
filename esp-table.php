  <!DOCTYPE html>
<html>
    <body>
    <head>
    <title>ESP-NOW DASHBOARD DS18B20 SENSORS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="icon" href="data:,">
<style>
html {font-family: Arial; display: inline-block; text-align: center;}
p {  font-size: 1.2rem;}
body {  margin: 0;}
.topnav { overflow: hidden; background-color: #2f4468; color: white; font-size: 1.7rem; }
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #D6EEEE;
}
</style>
</head>
<?php
/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

$servername = "localhost";

// REPLACE with your Database name
$dbname = "SensorData";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "bhaskara2001";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, BoardID, Sensor1, Celsius1, Fahrenheit1, Sensor2, Celsius2, Fahrenheit2, reading_time FROM SensorData ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <div class="topnav">
      <h3>SENSORDATA DATABASE TABLE</h3>
      </div>
      <tr> 
        <td>ID</td> 
        <td>Board ID</td> 
        <td>Sensor1</td> 
        <td>Celsius1</td> 
        <td>Fahrenheit1</td>
        <td>Sensor2</td> 
        <td>Celsius2</td> 
        <td>Fahrenheit2</td>
        <td>Timestamp</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_BoardID = $row["BoardID"];
        $row_Sensor1 = $row["Sensor1"];
        $row_Celsius1 = $row["Celsius1"];
        $row_Fahrenheit1 = $row["Fahrenheit1"];
        $row_Sensor2 = $row["Sensor2"];
        $row_Celsius2 = $row["Celsius2"];
        $row_Fahrenheit2 = $row["Fahrenheit2"];
        $row_reading_time = $row["reading_time"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_BoardID . '</td> 
                <td>' . $row_Sensor1 . '</td> 
                <td>' . $row_Celsius1 . '</td> 
                <td>' . $row_Fahrenheit1 . '</td>
                <td>' . $row_Sensor2 . '</td> 
                <td>' . $row_Celsius2 . '</td> 
                <td>' . $row_Fahrenheit2 . '</td>
                <td>' . $row_reading_time . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 

</table>
</body>
</html>
