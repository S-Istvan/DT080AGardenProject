/*
 * This sketch will accept input from 
 * a website and use that input to 
 * control a servo that is attached
 * to a camera. 
 * 
 * This sketch is designed for use 
 * with a nodeMCU esp8266 12-E
 * 
 * Created by Samuel Sheedy and Stephaine Ryan Istvan
 * Date: 17/04/2018
 */

//Include the espboard libraries we need 
#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h> //note this library is not used, it has been added in case we decide to change how we implement the server
//include the servo library that will control the servo
#include <Servo.h>
//Define our pins for each of the modules
#define statusLED 16 //This is just for testing
#define serPin D6
//Create a server object that will listen on port 80
WiFiServer server(80);
//Create a servo object to control the servo that holds camera
Servo camServo;
//Set a static IP address
IPAddress ip(192,168,0,58);
IPAddress subnet(255,255,255,0);
IPAddress gateway(192,168,0,1);
//Create global variables that we will use in the program
//Variable to store the servo's position
int pos = 110;

void setup()
{
  //set the defined pins to outputs
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
  camServo.attach(serPin);
}
void loop()
{
  //Serial.println(WiFi.localIP()); //Debug - To find out ip of device
 //check if the device is still connected to wifi, connect again if it is not
  connectToWifi();
  //Run the function that listens for clients
  gatherData();
}
void gatherData()
{
  //Create String variables that hold the input from the client
  //and the response that the device will send
  String clientInput = "initial", clientResponse;
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
    clientResponse = activateDevices(client, clientInput);
    //send a response to the client
    client.print(clientResponse);
    //close the connection to the client
    client.stop();
    delay(1);
  }
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
    WiFi.begin("VM5614E97","ua86ybhyZXhy");
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
String activateDevices(WiFiClient client, String clientInput)
{
  //This function will activate the lights, pump, heater or fan
  //and send a response to the client
  String response,range;
  if(clientInput == "moveCameraUp")
  {
    if (pos <= 140)
    {
      Serial.println("moved up");
      for(int i = 0; i < 10; i++)
      {
        pos++;
        camServo.write(pos);
        delay(15);
      }
      response = "Camera Moved Up";
    } 
    else
    {
      Serial.println("not moved up");
      response = "Camera at max height"; 
    }
  }
  else if(clientInput == "moveCameraDown")
  {
    if (pos >= 110)
    {
      Serial.println("moved down");
      for(int j = 0; j < 10; j++)
      {
        pos--;
        camServo.write(pos);
        delay(15);
      }
      response = "Camera Moved Down";
    }
    else
    {
     response = "Camera at min height"; 
     Serial.println("not moved down");
    }
  }
  return response;
}

