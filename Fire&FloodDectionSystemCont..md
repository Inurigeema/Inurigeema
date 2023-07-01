const int sensorMin = 0;     // Sensor minimum
const int sensorMax = 1024;  // Sensor maximum

const int flamePin1 = A0;    // Analog input pin for flame sensor 1
const int flamePin2 = A1;    // Analog input pin for flame sensor 2
const int flamePin3 = A2;    // Analog input pin for flame sensor 3

// Pin number for the siren
const int sirenPin = 9;

const int waterLevelPin1 = A3; // Water level sensor connected to analog pin A3
const int waterLevelPin2 = A4; // Water level sensor connected to analog pin A4
const int waterLevelPin3 = A5; // Water level sensor connected to analog pin A5
const int waterThreshold = 300; // Water level threshold value
void setup()
{

  Serial.begin(9600); // initialize serial communication @ 9600 baud.
  pinMode(waterLevelPin1, INPUT); // Set water level pin as input
  pinMode(waterLevelPin2, INPUT); // Set water level pin as input
  pinMode(waterLevelPin3, INPUT); // Set water level pin as input

  pinMode(sirenPin, OUTPUT);

}

void loop()
{ 
digitalWrite(sirenPin, HIGH);
  // Read the sensor values from the flame sensors
  int flameReading1 = analogRead(flamePin1);
  int flameReading2 = analogRead(flamePin2);
  int flameReading3 = analogRead(flamePin3);

  // Determine the highest flame reading among the sensors
  int highestReading = max(flameReading1, max(flameReading2, flameReading3));

 

  // Map the sensor range
  int range = map(highestReading, sensorMin, sensorMax, 0, 3);

  // Check the range value
  switch (range) {
    case 0:    // A flame closer than 1.5 feet away detected by at least one sensor.
      Serial.println("** Fire Detected **");
      // Additional actions when a close flame is detected, such as activating an alarm or taking necessary precautions
      return true;
//case 1:    // A flame between 1-3 feet away detected.
//      Serial.println("** Distant signal Detection **");
//      return true;
//    case 2:    // No flame detected by any sensor.
//      Serial.println("No Fire Detected");
 //     return false;
  }

    int waterLevelValue1 = analogRead(waterLevelPin1); // Read the analog value from the water level sensor
  
  if (waterLevelValue1 > waterThreshold) {
    Serial.println("Water Detected for Level 1 -> 20cm");
  } else {
//    Serial.println("No Water Detected");
  }
      int waterLevelValue2 = analogRead(waterLevelPin2); // Read the analog value from the water level sensor
  
  if (waterLevelValue2 > waterThreshold) {
    Serial.println("Water Detected for Level 2 -> 40cm");
  } else {
//    Serial.println("No Water Detected");
  }
      int waterLevelValue3 = analogRead(waterLevelPin3); // Read the analog value from the water level sensor
  
  if (waterLevelValue3 > waterThreshold) {
    Serial.println("Water Detected for Level 3 -> 60cm");
  } else {
//    Serial.println("No Water Detected");
  }

  delay(100);
}
