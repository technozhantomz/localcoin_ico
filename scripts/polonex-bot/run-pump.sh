#!/bin/bash
sleep $[ ( $RANDOM % 119 )  + 1 ]s
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=BTC&pair2=ETH"
sleep $[ ( $RANDOM % 119 )  + 1 ]s
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=BTC&pair2=XMR"
