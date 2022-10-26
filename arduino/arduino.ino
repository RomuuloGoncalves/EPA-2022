#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ArduinoJson.h>

const char* ssid = "****";
const char* password = "****";

const String url = "http://****/EPA/arduino.php";

String json = "";
void setup() {
  pinMode(15, OUTPUT);
  pinMode(14, OUTPUT);
  pinMode(13, OUTPUT);
  pinMode(12, OUTPUT);

  Serial.begin(9600);
  delay(5000);

  WiFi.begin(ssid, password, 6);
  Serial.print("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(100);
    Serial.print(".");
  }

  Serial.print("\nOK! IP=");
  Serial.println(WiFi.localIP());
}

void loop() {
  WiFiClient client;
  HTTPClient http;
  http.useHTTP10(true);
  http.begin(client, url);
  http.GET();
  if (json != http.getString()) {
    json = http.getString(); 

    DynamicJsonDocument doc(2048);
    DeserializationError erro = deserializeJson(doc, json);

    if (erro){
      Serial.println(json);
      Serial.print("deserializeJson() falhou: ");
      Serial.println(erro.c_str());
    } else {
      JsonArray array = doc.as<JsonArray>();
      for(JsonVariant v : array) {
        DynamicJsonDocument d(2048);
        DeserializationError erro = deserializeJson(d, v.as<String>());
        
        if (erro) {
          Serial.print("for deserializeJson() falhou: ");
          Serial.println(erro.c_str());
        } else {
          if (d["ESTADO"].as<int>() == 1) {
            digitalWrite(d["PORTA"].as<int>(), 255);
          } else {
            digitalWrite(d["PORTA"].as<int>(), 0);
          }
        }
      }
    }
  }
}
