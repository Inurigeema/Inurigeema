#define BLYNK_TEMPLATE_ID "TMPL6yvcmYZwJ"
#define BLYNK_TEMPLATE_NAME "NODE MCU"
#define BLYNK_AUTH_TOKEN "ks5Y1d3rKb9xLzx-PTwSt0IP4sepceLf"

#define BLYNK_PRINT Serial
#include <ESP8266WiFi.h>
#include <BlynkSimpleEsp8266.h>

char auth[] = BLYNK_AUTH_TOKEN;
char ssid[] = "Inuri123";  // type your wifi name
char pass[] = "snob0774";  // type your wifi password

const int sirenPin = D8; // Define the digital pin for the siren for fire
const int sirenWPin = D2; // Define the digital pin for the siren for water level
const int trigPin = D5;  // Trigger pin
const int echoPin = D6;  // Echo pin
const int d_pump = D7;   // Draining pump
const int wp_pump = D1; //  water sprinkler pump

const int level3 = 14;
const int level2 = 16;
const int level1 = 18;


int flag1 = 0;
int flag2 = 0;
int flag3 = 0;
int flag4 = 0;
int flag5 = 0;

void fireDetection() {
  int fire_sensor0 = digitalRead(D0); 
//  int fire_sensor1 = digitalRead(D1);
//  int fire_sensor2 = digitalRead(D2);
  

  if (fire_sensor0 == 0 ) {
    Serial.println("Fire in the House");
    Blynk.logEvent("fire_detection", "Fire is Detected");
    digitalWrite(sirenPin, HIGH);
    digitalWrite(wp_pump, HIGH);
    Serial.println("Siren ON");
    delay(4000);
   
    flag1 = 1;
  } else if (fire_sensor0 == 1) {
    flag1 = 0;
    digitalWrite(sirenPin, LOW);
    digitalWrite(wp_pump, LOW);
    
  }
  return;
}

const int waterThreshold = 22; // Water level threshold value
bool needReset = false; // Global variable to indicate the need for a reset
void waterDetection() {
  int isButtonPressed3 = analogRead(A0);
  unsigned long currentMillis = millis();

  long duration;
  int distance_cm;

  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  duration = pulseIn(echoPin, HIGH);
  distance_cm = duration / 58;
  Serial.print("Water level = ");
  Serial.print(distance_cm);
  Serial.println(" cm");

  if ((distance_cm <= level3) && (distance_cm != 0)&& flag2 ==0) {
    Blynk.logEvent("water_detection", "level 3 - 14 cm");
    Serial.println("level 3");
    digitalWrite(sirenWPin, HIGH);
    Serial.println ("Siren ON");
    delay(4000);
    digitalWrite(sirenWPin, LOW);
    
    flag2=0;
    flag3=0;
    flag4=0;
    flag5=0;
    
    flag2=1;
  } else if ((distance_cm <= level2 && distance_cm > level3) && flag3 ==0) {
    Blynk.logEvent("water_detection", "level 2 - 14 cm");
    Serial.println("level 2");
    digitalWrite(sirenWPin, HIGH);
    Serial.println("Siren ON");
    delay(4000);
    digitalWrite(sirenWPin, LOW);
    flag3=1;
  } else if ((distance_cm <= level1 && distance_cm > level2) && flag4 ==0) {
    Blynk.logEvent("water_detection", "level 1 - 18 cm");
    Serial.println("level 1");
    digitalWrite(sirenWPin, HIGH);
    Serial.println("Siren ON");
    delay(4000);
    digitalWrite(sirenWPin, LOW);
    flag4=1;
  } 

  else if(( distance_cm <= level2) && flag3==1){
     
    digitalWrite(d_pump, HIGH); // Turn ON the pump
    Serial.println("pump on");
   
  }
  else if (distance_cm >= waterThreshold && flag3==1) {
    
    digitalWrite(d_pump, LOW); // Turn OFF the pump
    Serial.println("pump off");
    
    flag2=0;
    flag3=0;
    flag4=0;
    flag5=0;

    return;
  }
  
}

void setup() {
  Serial.begin(115200);
  Blynk.begin(auth, ssid, pass);
  pinMode(D0, INPUT);
  pinMode(D1, INPUT);
  pinMode(D2, INPUT);
  pinMode(sirenPin, OUTPUT);
  pinMode(sirenWPin, OUTPUT);
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(d_pump, OUTPUT);
  pinMode(wp_pump, OUTPUT);


 delay (2000);

}

void loop() {
  
  Blynk.run();
  fireDetection();
  waterDetection();

}
