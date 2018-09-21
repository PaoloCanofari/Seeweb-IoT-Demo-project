/*
   Copyright (C) 2018 Seeweb Srl

   This file is part of SeewebIoT.
   SeewebIoT is free software: you can redistribute it and/or modify
   it under the terms of the GNU Lesser General Public License as published by
   the Free Software Foundation, either version 2.1 of the License, or
   (at your option) any later version.

   SeewebIoT is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Lesser General Public License for more details.

   You should have received a copy of the GNU Lesser General Public License
   along with SeewebIoT.  If not, see <http://www.gnu.org/licenses/>.

   AUTHOR: Paolo Canofari
*/


//Libraries
#include <DHT.h>;

//Constants for DHT22 sensor
#define DHTPIN A1     // what pin we're connected to
#define DHTTYPE DHT22   // DHT 22  (AM2302)
DHT dht(DHTPIN, DHTTYPE); //// Initialize DHT sensor for normal 16mhz Arduino

String answer; //Serial answer

void setup() {
  Serial.begin(9600);
  Serial.println("I'm Arduino");
}


void loop() {

  if (answer == "OK") {

    float hum = dht.readHumidity();
    float temp = dht.readTemperature();

    int mqval = analogRead(A0);
    int light = analogRead(A2);
    float soundlevel = micval();

    light = map(light, 0, 1024, 0, 100);
    
    if (temp < 50) {
      Serial.println(String("\"humidity\": ") + hum + String(", \"temperature\": ") + temp + String(", \"aqi\": ") + mqval + String(", \"lightInt\": ") + light + String(", \"noise\" : ") + soundlevel);
    }
    delay(800);

  }
  else {
    answer = Serial.readStringUntil('\n');
    Serial.println("I'm Arduino");
    Serial.println(answer);
  }
}

float micval() {

  const int sampleWindow = 50;                              // Sample window width in mS (50 mS = 20Hz)
  unsigned int sample;

  unsigned long startMillis = millis();                  // Start of sample window
  float peakToPeak = 0;                                  // peak-to-peak level

  unsigned int signalMax = 0;                            //minimum value
  unsigned int signalMin = 1024;
  while (millis() - startMillis < sampleWindow)
  {
    sample = analogRead(3);                             //get reading from microphone
    if (sample < 1024)                                  // toss out spurious readings
    {
      if (sample > signalMax)
      {
        signalMax = sample;                           // save just the max levels
      }
      else if (sample < signalMin)
      {
        signalMin = sample;                           // save just the min levels
      }
    }
  }
  peakToPeak = signalMax - signalMin;                    // max - min = peak-peak amplitude
  float db = map(peakToPeak, 20, 900, 49, 120);         //calibrate for deciBels
  return db;

}

