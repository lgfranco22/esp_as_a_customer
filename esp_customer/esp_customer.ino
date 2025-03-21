#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

#define SERVER_IP "ip:porta"

#ifndef STASSID
#define STASSID "ssid"
#define STAPSK "password"
#endif

void setup() {
  pinMode(1, OUTPUT);
  digitalWrite(1,LOW);   
  Serial.begin(115200);
  Serial.println();
  Serial.println();
  Serial.println();

  WiFi.begin(STASSID, STAPSK);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected! IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    Serial.print("[HTTP] begin...\n");
    http.begin(client, "http://" SERVER_IP "/postplain/index.php");
    http.addHeader("Content-Type", "application/json");

    // Gera um número aleatório entre 10000000 e 99999999
    long randomNumber = random(10000000, 99999999);
    String postData = "{\"randomNumber\": " + String(randomNumber) + "}";

    Serial.print("[HTTP] POST...\n");
    int httpCode = http.POST(postData);

    if (httpCode > 0) {
      digitalWrite(1,HIGH);
      delay(200);
      digitalWrite(1,LOW);   
      Serial.printf("[HTTP] POST... code: %d\n", httpCode);
      if (httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        Serial.println("received payload:\n<<");
        Serial.println(payload);
        Serial.println(">>");
      }
    } else {
      digitalWrite(1,HIGH);
      delay(200);
      digitalWrite(1,LOW);   
      delay(200);
      digitalWrite(1,HIGH);
      delay(200);
      digitalWrite(1,LOW);   
      delay(200);
      Serial.printf("[HTTP] POST... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }

    http.end();
  }

  delay(1000);
}
