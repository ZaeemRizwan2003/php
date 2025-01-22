<?php
/**
 * Created by PhpStorm.
 * User: orkuncaylar
 * Date: 16.07.2018
 * Time: 14:37
 */

date_default_timezone_set('Etc/GMT-3'); // Set timezone

/**
 * Generate a password with a specified length and type.
 * 
 * @param int $uzunluk Length of the password.
 * @param int $tip The type of password (1 for numbers, 2 for uppercase, 3 for lowercase, 5 for mixed).
 * @return string The generated password.
 */
function sifreUret(int $uzunluk, int $tip = 5): string
{
    $sifre = '';
    $sec = 0;
    
    // Generate the password based on the specified type
    for ($i = 0; $i < $uzunluk; $i++) {
        // Only numbers
        if ($tip == 1) {
            $sifre .= chr(random_int(48, 57)); // 0-9
        }
        // Uppercase letters
        elseif ($tip == 2) {
            $sifre .= chr(random_int(65, 90)); // A-Z
        }
        // Lowercase letters
        elseif ($tip == 3) {
            $sifre .= chr(random_int(97, 122)); // a-z
        }
        // Mixed password (letters and numbers)
        elseif ($tip == 5) {
            $sec = random_int(1, 4);
            if ($sec == 2) {
                $sifre .= chr(random_int(65, 90)); // A-Z
            } elseif ($sec == 3) {
                $sifre .= chr(random_int(97, 122)); // a-z
            } elseif ($sec == 4) {
                $sifre .= chr(random_int(48, 57)); // 0-9
            }
        }
    }

    return $sifre;
}

$sifre = sifreUret(10); // Generate a 10-character password
echo $sifre;
