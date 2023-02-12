<?php
    require 'vendor/autoload.php';

    use Lcobucci\JWT\Signer\Key\InMemory;

    $key = InMemory::base64Encoded(
        'no-key-for-you'
    );

?>