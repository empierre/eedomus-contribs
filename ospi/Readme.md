# Interface Eedomus avec Opensprinkler

## rajouter le script ospi.php

## créer un actionneur HTTP avec les paramètres
![OsPi](http://www.e-nef.com/domoticz/list_device.jpg "New device")

![OsPi](http://www.e-nef.com/domoticz/new_device.jpg "New device")
- changer l'image
- titre: Opensprinkler - Zone d'irrigation
- Usage: Appareil électrique

    [VAR1] IP:PORT 
    
    [VAR2] API key (hash du mot de passe)
    
    [VAR3] numéro de station
    
![OsPi](http://www.e-nef.com/domoticz/new_device2.jpg "New device")
- requête de mise à jour: http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=status

- chemin XPATH: /root/status

- fréquence requête 10mn

- Convertir JSON XML sélectionné

## dans l'onglet valeur:
![OsPi](http://www.e-nef.com/domoticz/new_device_values.jpg "New device")


    Auto	Auto				http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=auto
    Off	Off				http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=stop
    On	Arroser 30 minutes		http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=start&duration=30

# Usage
![OsPi](http://www.e-nef.com/domoticz/device_actions.jpg "New device")
