#!/bin/bash
sleep $[ ( $RANDOM % 899 )  + 1 ]s
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=USDC&pair2=ETH"