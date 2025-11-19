#!/bin/bash

renombre="$1"
carpeta="$2"

for archivo in "$carpeta"/*; do
   nombre="${archivo##*/}"
   nuevo_nombre="${renombre}_${nombre}" 
   mv "$archivo" "$carpeta/$nuevo_nombre"
done


echo "Renombrado completado."