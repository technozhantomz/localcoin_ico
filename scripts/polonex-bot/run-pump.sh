#!/bin/bash
sleep $[ ( $RANDOM % 119 )  + 1 ]s
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=BTC&pair2=ETH"
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=BTC&pair2=XMR"
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=USDC&pair2=ETH"
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=USDC&pair2=XMR"
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=USDC&pair2=BTC"
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=USDT&pair2=BTC"
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=USDT&pair2=ETH"
wget -O - "https://localcoin.is/scripts/polonex-bot/pump-pair.php?key=startexp&pair1=USDT&pair2=XMR"