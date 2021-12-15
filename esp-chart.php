<!--
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

-->
<?php

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

$sql = "SELECT id, BoardID, Celsius1, Celsius2 FROM SensorData WHERE BoardID = '1' order by reading_time desc limit 40  ";
$sql2= "SELECT id, BoardID, Celsius1, Celsius2 FROM SensorData WHERE BoardID = '2' order by reading_time desc limit 40  ";
$sql3 = "SELECT id, BoardID, Celsius1, Celsius2 FROM SensorData WHERE BoardID = '3' order by reading_time desc limit 40  ";

$result = $conn->query($sql);
$result2 = $conn->query($sql3);
$result3 = $conn->query($sql2);
$Board = json_encode(array_reverse(array_column($sensor_data, 'BoardID')), JSON_NUMERIC_CHECK);
while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
}
while ($data = $result2->fetch_assoc()){
    $sensor_data2[] = $data;
}
while ($data = $result3->fetch_assoc()){
    $sensor_data3[] = $data;
}
 

$readings_time = array_column($sensor_data, 'reading_time');
// ******* Uncomment to convert readings time array to your timezone ********
/*$i = 0;
foreach ($readings_time as $reading){
    // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
    $readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading - 1 hours"));
    // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
    //$readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading + 4 hours"));
    $i += 1;
}*/

$Celsius1 = json_encode(array_reverse(array_column($sensor_data, 'Celsius1')), JSON_NUMERIC_CHECK);
$Celsius2 = json_encode(array_reverse(array_column($sensor_data, 'Celsius2')), JSON_NUMERIC_CHECK);
$Celsius1a = json_encode(array_reverse(array_column($sensor_data2, 'Celsius1')), JSON_NUMERIC_CHECK);
$Celsius2a = json_encode(array_reverse(array_column($sensor_data2, 'Celsius2')), JSON_NUMERIC_CHECK);
$Celsius1b = json_encode(array_reverse(array_column($sensor_data3, 'Celsius1')), JSON_NUMERIC_CHECK);
$Celsius2b = json_encode(array_reverse(array_column($sensor_data3, 'Celsius2')), JSON_NUMERIC_CHECK);
$reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);
$reading_time3 = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);
$reading_time2 = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);


/*echo $value1;
echo $value2;
echo $value3;
echo $reading_time;*/

$result->free();
$conn->close();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="icon" href="data:,">
  <style>
  html {font-family: Arial; display: inline-block; text-align: center;}
  p {  font-size: 1.2rem;}
  body {  margin: 0;}
  .topnav { overflow: hidden; background-color: #2f4468; color: white; font-size: 1.7rem; }
  
    body {
      min-width: 310px;
    	max-width: 1280px;
    	height: 500px;
      margin: 0 auto;
    }
    h2 {
      font-family: Arial;
      font-size: 2.5rem;
      text-align: center;
    }
  </style>
  <body>
    <div class="topnav"><h3>ESP-NOW DASHBOARD</h3></div>
    <div id="chart-temperature1" class="container"></div>
    <div id="chart-temperature2" class="container"></div>
    <div id="chart-temperature1a" class="container"></div>
    <div id="chart-temperature2a" class="container"></div>
    <div id="chart-temperature1b" class="container"></div>
    <div id="chart-temperature2b" class="container"></div>
<script>

var Celsius1 = <?php echo $Celsius1; ?>;
var Celsius2 = <?php echo $Celsius2; ?>;
var Celsius1b = <?php echo $Celsius1a; ?>;
var Celsius2b = <?php echo $Celsius2a; ?>;
var Celsius1a = <?php echo $Celsius1b; ?>;
var Celsius2a = <?php echo $Celsius2b; ?>;

var reading_time = <?php echo $reading_time; ?>;
var reading_time2 = <?php echo $reading_time2; ?>;
var reading_time3 = <?php echo $reading_time3; ?>;

var chartT1 = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature1' },
  title: { text: 'DS18B20 BOARD1' },
  series: [{
    showInLegend: false,
    data: Celsius1
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#059e8a' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'Temperature (Celsius)' }
    //title: { text: 'Temperature (Fahrenheit)' }
  },
  credits: { enabled: false }
});


var chartT2 = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature2' },
  title: { text: 'DS18B20 BOARD1' },
  series: [{
    showInLegend: false,
    data: Celsius2
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#059e8a' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'Temperature (Celsius)' }
    //title: { text: 'Temperature (Fahrenheit)' }
  },
  credits: { enabled: false }
});

//xhxhhxhxhxhxhhxxhhxhxhxhxhhxhxhxhhxhxhxhhxhxhxhxhxhxhxhxhxhxhhxhxhxhxhhxxhhxhxhxhxhhxhxhxhhxhxhxhhxhxhxhxhxhxhxhxh

var chartTa1 = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature1a' },
  title: { text: 'DS18B20 BOARD 2' },
  series: [{
    showInLegend: false,
    data: Celsius1a
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#056e9e' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time2
  },
  yAxis: {
    title: { text: 'Temperature (Celsius)' }
    //title: { text: 'Temperature (Fahrenheit)' }
  },
  credits: { enabled: false }
});


var chartTa2 = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature2a' },
  title: { text: 'DS18B20 BOARD 2' },
  series: [{
    showInLegend: false,
    data: Celsius2a
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#056e9e' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time2
  },
  yAxis: {
    title: { text: 'Temperature (Celsius)' }
    //title: { text: 'Temperature (Fahrenheit)' }
  },
  credits: { enabled: false }
});
//xhxhhxhxhxhxhhxxhhxhxhxhxhhxhxhxhhxhxhxhhxhxhxhxhxhxhxhxhxhxhhxhxhxhxhhxxhhxhxhxhxhhxhxhxhhxhxhxhhxhxhxhxhxhxhxhxh

var chartTb1 = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature1b' },
  title: { text: 'DS18B20 BOARD 3' },
  series: [{
    showInLegend: false,
    data: Celsius1b
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#f5c907' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time3
  },
  yAxis: {
    title: { text: 'Temperature (Celsius)' }
    //title: { text: 'Temperature (Fahrenheit)' }
  },
  credits: { enabled: false }
});


var chartTb2 = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature2b' },
  title: { text: 'DS18B20 BOARD 3' },
  series: [{
    showInLegend: false,
    data: Celsius2b
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#f5c907' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time3
  },
  yAxis: {
    title: { text: 'Temperature (Celsius)' }
    //title: { text: 'Temperature (Fahrenheit)' }
  },
  credits: { enabled: false }
});




</script>
</body>
</html>