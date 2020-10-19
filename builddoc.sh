#!/bin/bash
#Set phploc and phpdox to you path
../../tools/phploc-7.0.1.phar ./ --suffix php --exclude "./vendor"  --count-tests --log-xml ./logs/phploc.xml
../../tools/phpdox-0.12.0.phar
