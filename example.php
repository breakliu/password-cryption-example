<?php

if ( ! function_exists('password_hash') ) {
    die('password_hash() do not exists');
}

if ( ! function_exists('openssl_get_cipher_methods') ) {
    die('openssl_get_cipher_methods() do not exists');
}

DEFINE('__IV__', 1234567890123456);
DEFINE('__CIPHER__', 'AES-128-CBC');

function generate_keys($db_password) {
    $instance_key   = password_hash("PASSWORD", PASSWORD_BCRYPT);

    if (in_array(__CIPHER__, openssl_get_cipher_methods())) {
        $db_password_key        = openssl_encrypt($db_password, __CIPHER__, $instance_key, $options=0, __IV__);

        if ( false === $db_password_key ) {
            die("openssl_encrypt failed!\n");
        }

        $instance_key_encode    = base64_encode($instance_key);
        $db_password_key_encode = base64_encode($db_password_key);
        echo "You may copy these two keys into .env:\n";
        echo "#################################\n";
        echo "INSTANCE_KEY=$instance_key_encode\n";
        echo "DB_PASSWORD_KEY=$db_password_key_encode\n";
        echo "#################################\n";
        echo "\n";
    } else {
        die("Do not support cipher: ".__CIPHER__."\n");
    }

    return [$instance_key_encode, $db_password_key_encode];
}

function valid_keys($db_password, $instance_key_encode, $db_password_key_encode) {
    $db_password_key_2 = base64_decode($db_password_key_encode);
    $instance_key_2 = base64_decode($instance_key_encode);
    $db_password_2 = openssl_decrypt($db_password_key_2, __CIPHER__, $instance_key_2, $options=0, __IV__);

    if ( false === $db_password_2 ) {
        die("openssl_decrypt failed!\n");
    }

    echo "valid successfully, db_password=$db_password, db_password_2=$db_password_2\n";

    return $db_password == $db_password_2;
}

# You May Need This Function : )
function get_db_password($instance_key_encode, $db_password_key_encode) {
    $db_password_key_2 = base64_decode($db_password_key_encode);
    $instance_key_2 = base64_decode($instance_key_encode);
    $db_password_2 = openssl_decrypt($db_password_key_2, __CIPHER__, $instance_key_2, $options=0, __IV__);


    if ( false === $db_password_2 ) {
        die("openssl_decrypt failed!\n");
    }

    return $db_password_2;
}

$db_password = '12345678AbC'; # Your DB Password

list($instance_key_encode, $db_password_key_encode) = generate_keys($db_password);
valid_keys($db_password, $instance_key_encode, $db_password_key_encode);

echo "\n";
echo 'DB Password From Keys: ' . get_db_password($instance_key_encode, $db_password_key_encode) . "\n";
