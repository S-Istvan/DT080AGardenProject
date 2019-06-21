/*
 * This sketch will accept input from 
 * a website and use that input to activate
 * lights attached to an optocoupler
 * and a DC pump by way of a relay
 * It also performs climate control functions
 * by testing values set by the website 
 * against the current temperature and activate
 * either heating or cooling(extractor fans) 
 * when the temperature is out of set parameters
 * 
 * This sketch is designed for use 
 * with a nodeMCU esp8266 12-E
 * 
 * Created by Samuel Sheedy and Stephaine Ryan Istvan
 * Date: 10/03/2018
 */

//Include the espboard libraries we need 
#include <ESP8266WiFi.h>
//#include <ESP8266WebServer.h> //note this library is not used, it has been added in case we decide to change how we implement the server
//Define our pins for each of the modules
#define lightRelay D1
#define pumpRelay D2
#define coolingFan D3
#define heater D5
#define tempPin A0
#define statusLED 16 //This is just for testing
//Create a server object that will listen on port 80
WiFiServer server(80);
//Set a static IP address
IPAddress ip(192,168,0,59);
IPAddress subnet(255,255,255,0);
IPAddress gateway(192,168,0,1);
//Create global variables that we will use in the program
//currentMillis will be used to test how long the pump has been running
long int currentMillis = 0;
//max and min temperature values will be used for climate control
float maxTemp = 30;
float minTemp = 0;

void setup()
{
  //set the defined pins to outputs
  pinMode(lightRelay,OUTPUT);
  pinMode(pumpRelay,OUTPUT);
  pinMode(coolingFan,OUTPUT);
  pinMode(heater,OUTPUT);
  pinMode(statusLED,OUTPUT);
  Serial.begin(115200);
  //Connect to wifi with the SSID and Password
  WiFi.config(ip,gateway, subnet);
  WiFi.begin("VM5614E97","ua86ybhyZXhy");
  while ((!(WiFi.status() == WL_CONNECTED)))
  {
    digitalWrite(statusLED, HIGH);
    delay(200);
    digitalWrite(statusLED, LOW);
    Serial.println("connecting");
  }
  //flash the on board led twice after we have connected successfully
  digitalWrite(statusLED, HIGH);
  delay(500);
  digitalWrite(statusLED, LOW);
  delay(500);
  digitalWrite(statusLED, HIGH);
  delay(500);
  digitalWrite(statusLED, LOW);
  Serial.println(WiFi.localIP());
  //Set the server to start listening for incoming traffic
  server.begin();
}
void loop()
{
  //Run the function that tests the values of min and max temp
  float curTemp = checkTempRange();
  //Serial.println(WiFi.localIP()); //Debug - To find out ip of device
 //check if the device is still connected to wifi, connect again if it is not
  connectToWifi();
  //Run the function that listens for clients
  gatherData(curTemp);
  //Check how long the pump has been running for
  if(millis() >= (currentMillis + 15000))
  {
    //run the function that turns off the pump if true
    timerOverflow();   
  }
}
void gatherData(float curTemp)
{
  //Create String variables that hold the input from the client
  //and the response that the device will send
  String clientInput = "initial",clientResponse;
  //Create a WiFiClient object
  WiFiClient client = server.available();
  //Check if there was a client connection, return to main if not
  if (!client) {return; }
  while(!client.available()){delay(1);}
  //if the client has connected then check what it has sent
  if (client.available()) 
  {  
    //Loop through the request headers until the blank
    //line at the end
    while(clientInput.length() >= 2)
    {
       clientInput = client.readStringUntil('\n');
       Serial.println(clientInput);
    }
    //get the posted string
    clientInput = client.readStringUntil('/');
    Serial.println(clientInput);
    //trim whitespace from the string
    clientInput.trim();
    //respond to the client with http headers
    sendHeadersToClient(client);
    //run the function that will turn on or off devices
    clientResponse = activateDevices(client, clientInput, curTemp);
    //send a response to the client
    client.print(clientResponse);
    //close the connection to the client
    client.stop();
    delay(1);
  }
}
void timerOverflow()
{
  //turn off the pump
  digitalWrite(pumpRelay,LOW);
}
void connectToWifi()
{
  //This function will test if the board has 
  //a connection to an access point
  //and if it doesn't it will attempt to connect
  //to a specific access point
  if((!(WiFi.status() == WL_CONNECTED)))
  {
    WiFi.config(ip,gateway, subnet);
    WiFi.begin("NeffyNet","pword123");
    while ((!(WiFi.status() == WL_CONNECTED)))
    {
      Serial.println("Connecting");
      digitalWrite(statusLED,HIGH);
      delay(200);
      digitalWrite(statusLED, LOW);
    }
    Serial.println("Connected");
    Serial.println(WiFi.localIP());
    digitalWrite(statusLED, HIGH);
    delay(500);
    digitalWrite(statusLED, LOW);
    delay(500);
    digitalWrite(statusLED, HIGH);
    delay(500);
    digitalWrite(statusLED,LOW);
  }
}
void sendHeadersToClient(WiFiClient client) //WiFiClient for esp8266, BridgeClient if using the arduino yun
{
  //This function prints the response headers to the client
  client.println("HTTP/1.1 200 OK"); //HTTP/1.1 200 OK for esp8266 respones, if using with arduino change to Status: 200 
  client.println("Access-Control-Allow-Origin: *");   
  client.println("Access-Control-Allow-Methods: POST");
  client.println("Content-Type: text/html");
  client.println("Connection: close");
  client.println();
}
String activateDevices(WiFiClient client, String clientInput, float curTemp)
{
  //This function will activate the lights, pump, heater or fan
  //and send a response to the client
  String response,range;
  if(clientInput == "activateLights")
  {
    digitalWrite(lightRelay,HIGH);
    response = "Lights Activated";
  }
  else if(clientInput == "deactivateLights")
  {
    digitalWrite(lightRelay,LOW);
    response = "Lights deactivated";
  }
  else if(clientInput == "activatePump")
  {
    digitalWrite(pumpRelay,HIGH);
    currentMillis = millis();
    response = "Pump Activated";
  }
  else if(clientInput == "setMaxTemp")
  {
    range = client.readStringUntil('/');
    range.trim();
    Serial.println(range);
    Serial.println("Maximum temp selected");
    maxTemp = range.toInt();
    Serial.println(maxTemp);
    response = "Max temp set to: " + range + "<br>Current Temp: " + curTemp +"&deg;C";
  }
  else if(clientInput == "setMinTemp")
  {
    range = client.readStringUntil('/');
    range.trim();
    Serial.println("Minimum temp selected");
    Serial.println(range);
    minTemp = range.toInt();
    Serial.println(minTemp);
    response = "Min temp set to: " + range + "<br>Current Temp: " + curTemp +"&deg;C";
  }
  return response;
}
float checkTempRange()
{
  float currentTemp;
  currentTemp = analogRead(tempPin);
  delay(10);
  currentTemp = ((currentTemp*(3300/1024))-500)/10; 
  //Serial.println(currentTemp);
  //currentTemp = 15; //hardcoded temp for testing without the sensor
  if(currentTemp > maxTemp)
  {
    digitalWrite(coolingFan,HIGH);
  }
  else if(currentTemp < maxTemp)
  {
    digitalWrite(coolingFan,LOW);
  }
  if(currentTemp < minTemp)
  {
    digitalWrite(heater,HIGH);
  }
  else if(currentTemp > minTemp)
  {
    digitalWrite(heater,LOW); 
  }
  return currentTemp;
}

