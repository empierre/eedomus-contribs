1- créer un actionneur HTTP avec les paramètres
changer l'image
Opensprinkler - Zone d'irrigation
Usage: Appareil électrique
[VAR1] IP:PORT 
[VAR2] API key (hash du mot de passe)
[VAR3] numéro de station
requête de mise à jour: http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=status
chemin XPATH: /root/status
fréquence requête 10mn
Convertir JSON XML sélectionné

2- dans l'onglet valeur:

Auto	Auto				http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=auto
Off	Off				http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=stop
On	Arroser 30 minutes		http://localhost/script/?exec=ospi.php&ip=[VAR1]&API=[VAR2]&zone_number=[VAR3]&action=start&duration=30

3- rajouter le script ospi.php
