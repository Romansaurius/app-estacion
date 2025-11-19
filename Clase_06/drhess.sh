#!/bin/bash
mkdir marionettes
echo 'echo "Hola soy Lima."' > marionettes/lime.sh
echo 'echo "Hola soy Cereza."' > marionettes/cherry.sh
echo 'echo "Hola soy Zarzamora"' > marionettes/bloodberry.sh
chmod 757 marionettes/lime.sh
chmod 757 marionettes/cherry.sh
chmod 757 marionettes/bloodberry.sh
marionettes/bloodberry.sh > ../teamj.txt
marionettes/cherry.sh >> ../teamj.txt
marionettes/lime.sh >> ../teamj.txt
echo "Script 'drhess.sh' ejecutado. Verifica el archivo '../teamj.txt' y la carpeta 'marionettes'."