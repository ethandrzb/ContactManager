<?php
    require 'vendor/autoload.php';

    use Lcobucci\JWT\Signer\Key\InMemory;

    $key = InMemory::base64Encoded(
        'U29tZXJzZXQtUHJvcG9zZS1FbXBsb3llZS1UcmFuc2Zvcm1hdGlvbi1BcHBlYWxzLUhlc2l0YXRlZC1FYXN0ZXItVmlydHVlLTE='
    );

?>