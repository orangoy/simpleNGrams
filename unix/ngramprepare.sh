#!/bin/bash
N=$1
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
text=`cat`

echo "$text" |
sed "s/  */ /g" |
grep -v "^\s$" |
$DIR/ngramcore.sh $N |
/usr/bin/sort -nr
