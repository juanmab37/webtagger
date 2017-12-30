#!/bin/bash

#script para espejar imagenes

#Modo de uso:
#$ ./


mkdir rotados
i=$[0]

for l in `cat espejar.txt`
do
    echo $i
    echo $l
    convert -flop $l rotados/rot_$i.png
    i=$[$i + 1]
     
done



