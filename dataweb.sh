#!/bin/bash

#script para 

#Modo de uso:
#$ ./

#Recordar que la carpeta 0 es igual a la carpeta 82

dir_csv=/var/www/html/agrodeep/data_train/

cd $dir_csv

for f in `ls ${dir_csv}`
do

    echo $f
    sed '1d' $f > aux.csv
    sed '$d' aux.csv > aux2.csv
    cat aux2.csv data.csv > dataAux.csv
    cp dataAux.csv data.csv
    rm aux.csv aux2.csv dataAux.csv

done

cd ..

