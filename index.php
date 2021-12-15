<!DOCTYPE html>
<html>
<style>
html {font-family: Arial; display: inline-block; text-align: center;}
p {  font-size: 1.2rem;}
body {  margin: 0;}
.topnav { overflow: hidden; background-color: #2f4468; color: white; font-size: 1.7rem; }
table {border-collapse: collapse;width: 100%;}
th, td {
  text-align: left;
  padding: 8px;
}
tr:nth-child(even) {
  background-color: #D6EEEE;
}
.content { padding: 20px; }
.card { background-color: white; box-shadow: 2px 2px 12px 1px rgba(140,140,140,.5); }
.cards { max-width: 500px; margin: 0 auto; display: grid; grid-gap: 2rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
.reading { font-size: 2.8rem; }
.packet { color: #bebebe; }
.card.temperature { color: #fd7e14; }
.card.temperature2 { color: #1b78e2; }
.card.temperature3 { color: #0fb007; }
</style>
<body>
<table cellspacing="5" cellpadding="5">
<div class="topnav">
<h2>Welcome to DS18B20 WSN Monitoring</h2>
</div>



<div class="content">
    <div class="cards">

      <div id="A1" class="card temperature">
      <h4><i class="fas fa-thermometer-half"></i>DS18B20WSN MONITORING</h4><p><span class="reading"><span id="c11"></span> CHARTZ </span></p>
      <p class="packet">See the sensor value on a chart: <span id="rc11"></span></p>
      <h4><a href="http://10.252.242.120/esp-chart.php">Click here to view</a></h4>
      </div>

      <div id="A2" class="card temperature2">
        <h4><i class="fas fa-thermometer-half"></i> DS18B20WSN MONITORING</h4><p><span class="reading"><span id="c21"></span> TABLES</span></p>
	<p class="packet">See the sensor value on a tables: <span id="rc21"></span></p>    <p><span class="reading"><span id="f21"></span>
        <h4><a href="http://10.252.242.120/esp-table.php">Click here to view</a></h4>
      </div>

      
      <div id="A1" class="card temperature3">
        <h4><i class="fas fa-thermometer-half"></i>DS18B20WSN MONITORING</h4><p><span class="reading"><span id="c11"></span> NODES</span></p>
        <p class="packet">Monitor the sensor value on a WEB: <span id="rc11"></span></p>
        <h4><a href="http://10.252.241.110/">Click here to view</a></h4>
      </div>
      
      </div>
      </div>
      </div>


</body>
</html>

