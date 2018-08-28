/*
 * Copyright (C) 2018 Seeweb Srl
 *
 * This file is part of SeewebIoT.
 * SeewebIoT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 2.1 of the License, or
 * (at your option) any later version.
 *
 * SeewebIoT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SeewebIoT.  If not, see <http://www.gnu.org/licenses/>.
 */

//Libraries
#include <DHT.h>;

//Constants for DHT22 sensor
#define DHTPIN A2     // what pin we're connected to
#define DHTTYPE DHT22   // DHT 22  (AM2302)
DHT dht(DHTPIN, DHTTYPE); //// Initialize DHT sensor for normal 16mhz Arduino

//answer from QT client

//Variables
float hum;  //Stores humidity value
float temp; //Stores temperature value

//value from mq135 sensor
int mqVal;

//Hardware pin definitions UV sensor
int UVOUT = A3; //Output from the sensor
int REF_3V3 = A0; //3.3V power on the Arduino board

void setup() {
  Serial.begin(9600);
  Serial.println("I'm Arduino");

}
//Dichiaro la variabile di tipo string str in cui verrà inserito il comando ricevuto da seriale
String str;

void loop() {

  //if I receive an aswer "OK" from the client
  if (str == "OK") {

    //Read data and store it to variables hum and temp
    hum = dht.readHumidity();
    temp = dht.readTemperature();

    mqVal = analogRead(0);       // read analog input pin 0


    //UV SENSOR
    int uvLevel = averageAnalogRead(UVOUT);
    int refLevel = averageAnalogRead(REF_3V3);

    //Use the 3.3V power pin as a reference to get a very accurate output value from sensor
    float outputVoltage = 3.3 / refLevel * uvLevel;

    float uvIntensity = mapfloat(outputVoltage, 0.99, 2.8, 0.0, 15.0); //Convert the voltage to a UV intensity level

    //print data in JSON format

    Serial.println(String("\"{ \"humidity\": ") + hum + String(", \"Temp\": ") + temp + String(", \"mqVal\": ") + mqVal + String(", \"UVIntensity\": ") + uvIntensity + String(" }\""));

    delay(2000); //Delay 2 sec.
  }
  else {
    //Do alla variabile str il valore corrispondente al comando ricevuto da seriale
    str = Serial.readStringUntil('\n');
    Serial.println("I'm Arduino");
  }
}

int averageAnalogRead(int pinToRead)
{
  byte numberOfReadings = 8;
  unsigned int runningValue = 0;

  for (int x = 0 ; x < numberOfReadings ; x++)
    runningValue += analogRead(pinToRead);
  runningValue /= numberOfReadings;

  return (runningValue);
}

//The Arduino Map function but for floats
float mapfloat(float x, float in_min, float in_max, float out_min, float out_max)
{
  return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}
