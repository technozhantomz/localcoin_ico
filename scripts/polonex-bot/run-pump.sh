#!/bin/bash
sleep $[ ( $RANDOM % 119 )  + 1 ]s
wget -O - "https://localcoin.is/scripts/polonex-bot/pump_BTC-XMR.php?key=startexp"