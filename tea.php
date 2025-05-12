<?php
require 'vendor/autoload.php';

use kornrunner\Keccak;
use kornrunner\Ethereum\KeyPair;

function generateRandomWallet() {
    // Generate a random 32-byte hex private key
    $privateKey = bin2hex(random_bytes(32));
    
    // Create KeyPair object
    $keyPair = new KeyPair($privateKey);
    
    // Get public key (uncompressed)
    $publicKey = $keyPair->getPublicKey();
    
    // Compute address: last 20 bytes of keccak256 hash of public key (skip 0x04 prefix)
    $publicKeyHex = substr($publicKey, 2); // remove '0x'
    $publicKeyBin = hex2bin($publicKeyHex);
    $hash = Keccak::hash(substr($publicKeyBin, 1), 256); // skip first byte 0x04
    
    $address = '0x' . substr($hash, -40);
    
    return [
        'privateKey' => '0x' . $privateKey,
        'address' => $address
    ];
}

$wallet = generateRandomWallet();
echo "Address: " . $wallet['address'] . PHP_EOL;
echo "Private Key: " . $wallet['privateKey'] . PHP_EOL;
