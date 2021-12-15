//MAC ADDRESS 08:3A:F2:8F:CF:74
#include <HTTPClient.h>
#include <esp_now.h>
#include <WiFi.h>
#include "ESPAsyncWebServer.h"
#include <Arduino_JSON.h>

// Replace with your network credentials (STATION)
const char* ssid = "CALVIN-Student";
const char* password = "CITStudentsOnly";
const char* serverName = "http://10.252.242.120/post-esp-data.php";
String apiKeyValue = "tPmAT5Ab3j7F9";

// Structure example to receive data
// Must match the sender structure
typedef struct struct_message {
    int id;
    float tempC1;
    float tempC2;
    float tempF1;
    float tempF2;
    int readingId;
} struct_message;

struct_message incomingReadings;

JSONVar board;

AsyncWebServer server(80);
AsyncEventSource events("/events");



// callback function that will be executed when data is received
void OnDataRecv(const uint8_t * mac_addr, const uint8_t *incomingData, int len) { 
  // Copies the sender mac address to a string
  char macStr[18];
  Serial.print("Packet received from: ");
  snprintf(macStr, sizeof(macStr), "%02x:%02x:%02x:%02x:%02x:%02x",
           mac_addr[0], mac_addr[1], mac_addr[2], mac_addr[3], mac_addr[4], mac_addr[5]);
  Serial.println(macStr);
  memcpy(&incomingReadings, incomingData, sizeof(incomingReadings));
  
  board["id"] = incomingReadings.id;
  board["TemperatureC1"] = incomingReadings.tempC1;
  board["TemperatureC2"] = incomingReadings.tempC2;
  board["TemperatureF1"] = incomingReadings.tempF1;
  board["TemperatureF2"] = incomingReadings.tempF2;
  board["readingId"] = String(incomingReadings.readingId);
  String jsonString = JSON.stringify(board);
  events.send(jsonString.c_str(), "new_readings", millis());
      
  Serial.printf("Board ID %u: %u bytes\n", incomingReadings.id, len);
  Serial.printf("c1 value: %4.2f \n", incomingReadings.tempC1);
  Serial.printf("c2 value: %4.2f \n", incomingReadings.tempC2);
  Serial.printf("f1 value: %4.2f \n", incomingReadings.tempF1);
  Serial.printf("f2 value: %4.2f \n", incomingReadings.tempF2);
  Serial.printf("readingID value: %d \n", incomingReadings.readingId);
  Serial.println();
}

const char index_html[] PROGMEM = R"rawliteral(
<!DOCTYPE HTML><html>
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
    .content { padding: 20px; }
    .card { background-color: white; box-shadow: 2px 2px 12px 1px rgba(140,140,140,.5); }
    .cards { max-width: 700px; margin: 0 auto; display: grid; grid-gap: 2rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
    .reading { font-size: 2.8rem; }
    .packet { color: #bebebe; }
    .card.temperature { color: #fd7e14; }
    .card.temperature2 { color: #1b78e2; }
  </style>
</head>
<body>
  <div class="topnav">
    <h3>ESP-NOW DASHBOARD</h3>
  </div>
  <div class="content">
    <div class="cards">
      <div id="A1" class="card temperature">
        <h4><i class="fas fa-thermometer-half"></i> BOARD #1 Sensor1 - TEMPERATURE</h4><p><span class="reading"><span id="c11"></span> &deg;C</span></p><p class="packet">Reading ID: <span id="rc11"></span></p>    <p><span class="reading"><span id="f11"></span> &deg;F</span></p><p class="packet">Reading ID: <span id="rf11"></span></p>
      </div>
      <div id="A2" class="card temperature2">
        <h4><i class="fas fa-thermometer-half"></i> BOARD #1 Sensor2 - TEMPERATURE</h4><p><span class="reading"><span id="c21"></span> &deg;C</span></p><p class="packet">Reading ID: <span id="rc21"></span></p>    <p><span class="reading"><span id="f21"></span> &deg;F</span></p><p class="packet">Reading ID: <span id="rf21"></span></p>
      </div>
      <div  id="B1" class="card temperature">
        <h4><i class="fas fa-thermometer-half"></i> BOARD #2 Sensor1 - TEMPERATURE</h4><p><span class="reading"><span id="c12"></span> &deg;C</span></p><p class="packet">Reading ID: <span id="rc12"></span></p>    <p><span class="reading"><span id="f12"></span> &deg;F</span></p><p class="packet">Reading ID: <span id="rf12"></span></p>
      </div>
      <div  id="B2" class="card temperature2">
        <h4><i class="fas fa-thermometer-half"></i> BOARD #2 Sensor2 - TEMPERATURE</h4><p><span class="reading"><span id="c22"></span> &deg;C</span></p><p class="packet">Reading ID: <span id="rc22"></span></p>    <p><span class="reading"><span id="f22"></span> &deg;F</span></p><p class="packet">Reading ID: <span id="rf22"></span></p>
      </div>
      <div  id="C1"class="card temperature">
        <h4><i class="fas fa-thermometer-half"></i> BOARD #3 Sensor1 - TEMPERATURE</h4><p><span class="reading"><span id="c13"></span> &deg;C</span></p><p class="packet">Reading ID: <span id="rc13"></span></p>    <p><span class="reading"><span id="f13"></span> &deg;F</span></p><p class="packet">Reading ID: <span id="rf13"></span></p>
      </div>
      <div  id="C2"class="card temperature2">
        <h4><i class="fas fa-thermometer-half"></i> BOARD #3 Sensor2 - TEMPERATURE</h4><p><span class="reading"><span id="c23"></span> &deg;C</span></p><p class="packet">Reading ID: <span id="rc23"></span></p>    <p><span class="reading"><span id="f23"></span> &deg;F</span></p><p class="packet">Reading ID: <span id="rf23"></span></p>
      </div>
    </div>
  </div>

  
<script>
if (!!window.EventSource) {
 var source = new EventSource('/events');
 
 source.addEventListener('open', function(e) {
  console.log("Events Connected");
 }, false);
 source.addEventListener('error', function(e) {
  if (e.target.readyState != EventSource.OPEN) {
    console.log("Events Disconnected");
  }
 }, false);
 
 source.addEventListener('message', function(e) {
  console.log("message", e.data);
 }, false);
 
 source.addEventListener('new_readings', function(e) {
  console.log("new_readings", e.data);
  var obj = JSON.parse(e.data);
  document.getElementById("c1"+obj.id).innerHTML = obj.TemperatureC1.toFixed(2);
  document.getElementById("c2"+obj.id).innerHTML = obj.TemperatureC2.toFixed(2);
  document.getElementById("f1"+obj.id).innerHTML = obj.TemperatureF1.toFixed(2);
  document.getElementById("f2"+obj.id).innerHTML = obj.TemperatureF2.toFixed(2);
  document.getElementById("rc1"+obj.id).innerHTML = obj.readingId;
  document.getElementById("rc2"+obj.id).innerHTML = obj.readingId;
  document.getElementById("rf1"+obj.id).innerHTML = obj.readingId;
  document.getElementById("rf2"+obj.id).innerHTML = obj.readingId;

  var c1 = obj.TemperatureC1
  var c2 = obj.TemperatureC2
  if (obj.id == 1) {
    if(c1 > 30.00){
      document.getElementById("A1").style.backgroundColor = "red";
    }
    if(c2 > 30.00){
      document.getElementById("A2").style.backgroundColor = "red";
    }
//    if (c1 > 30.00 && c2 > 30.00 ){
//      document.getElementById("A1").style.backgroundColor = "red";
//      document.getElementById("A2").style.backgroundColor = "red";
//    }
    if(c1 < 30.00){
      document.getElementById("A1").style.backgroundColor = "white";
    }
    if(c2 < 30.00){
      document.getElementById("A2").style.backgroundColor = "white";
    }
//    if (c1 < 30.00 && c2 < 30.00 ){
//      document.getElementById("A1").style.backgroundColor = "white";
//      document.getElementById("A2").style.backgroundColor = "white";
//    }
  }
  if (obj.id == 2) {
    if(c1 > 30.00){
      document.getElementById("B1").style.backgroundColor = "red";
    }
    if(c2 > 30.00){
      document.getElementById("B2").style.backgroundColor = "red";
    }
//    if (c1 > 30.00 && c2 > 30.00 ){
//      document.getElementById("B1").style.backgroundColor = "red";
//      document.getElementById("B2").style.backgroundColor = "red";
//    }
    if(c1 < 30.00){
      document.getElementById("B1").style.backgroundColor = "white";
    }
    if(c2 < 30.00){
      document.getElementById("B2").style.backgroundColor = "white";
    }
//    if (c1 < 30.00 && c2 < 30.00 ){
//      document.getElementById("B1").style.backgroundColor = "white";
//      document.getElementById("B2").style.backgroundColor = "white";
//    }
  }
  if (obj.id == 3) {
    if(c1 > 30.00){
      document.getElementById("C1").style.backgroundColor = "red";
    }
    if(c2 > 30.00){
      document.getElementById("C2").style.backgroundColor = "red";
    }
//    if (c1 > 30.00 && c2 > 30.00 ){
//      document.getElementById("C1").style.backgroundColor = "red";
//      document.getElementById("C2").style.backgroundColor = "red";
//    }
    if(c1 < 30.00){
      document.getElementById("C1").style.backgroundColor = "white";
    }
    if(c2 < 30.00){
      document.getElementById("C2").style.backgroundColor = "white";
    }
//    if (c1 < 30.00 && c2 < 30.00 ){
//      document.getElementById("C1").style.backgroundColor = "white";
//      document.getElementById("C2").style.backgroundColor = "white";
//    }
  }  

 }, false);
}


</script>
</body>
</html>)rawliteral";

void setup() {
  // Initialize Serial Monitor
  Serial.begin(115200);

  // Set the device as a Station and Soft Access Point simultaneously
  WiFi.mode(WIFI_AP_STA);
  
  // Set device as a Wi-Fi Station
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Setting as a Wi-Fi Station..");
  }
  Serial.print("Station IP Address: ");
  Serial.println(WiFi.localIP());
  Serial.print("Wi-Fi Channel: ");
  Serial.println(WiFi.channel());

  // Init ESP-NOW
  if (esp_now_init() != ESP_OK) {
    Serial.println("Error initializing ESP-NOW");
    return;
  }
  Serial.println(WiFi.localIP());
  // Once ESPNow is successfully Init, we will register for recv CB to
  // get recv packer info
  esp_now_register_recv_cb(OnDataRecv);

  server.on("/", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send_P(200, "text/html", index_html);
  });
   
  events.onConnect([](AsyncEventSourceClient *client){
    if(client->lastId()){
      Serial.printf("Client reconnected! Last message ID that it got is: %u\n", client->lastId());
    }
    // send event with message "hello!", id current millis
    // and set reconnect delay to 1 second
    client->send("hello!", NULL, millis(), 10000);
  });
  server.addHandler(&events);
  server.begin();

}
 
void loop() {
  static unsigned long lastEventTime = millis();
  static const unsigned long EVENT_INTERVAL_MS = 5000;
  if ((millis() - lastEventTime) > EVENT_INTERVAL_MS) {
    events.send("ping",NULL,millis());
    lastEventTime = millis();
  }

  //XHXHXHXHXHXHXHXHXHXHXHXHXHXHXH Check WiFi connection status XHXHXHXHXHXHXHXHXHXHXHXHXHXHXHXHXHXHXHXHXHXHX
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
    
    // Your Domain name with URL path or IP address with path
    http.begin(serverName);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    // Prepare your HTTP POST request data
    String httpRequestData = "api_key=" + apiKeyValue + "&BoardID=" + String (incomingReadings.id)
                      + "&Sensor1=" + "Satu" + "&Celsius1=" + String(incomingReadings.tempC1)
                      + "&Fahrenheit1=" + String(incomingReadings.tempF1)
                      + "&Sensor2=" + "Dua" + "&Celsius2=" + String(incomingReadings.tempC2)
                      + "&Fahrenheit2=" + String(incomingReadings.tempF2) + "";
    
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
    delay(500);
    int httpResponseCode = http.POST(httpRequestData);
    
    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 30 seconds
  delay(500);
  } 
