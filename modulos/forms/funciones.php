<?php
    function escapar($html) {
        //htmlspecialchars — Convierte caracteres especiales en entidades HTML
        // ENT_QUOTES: convertirá tanto las comillas dobles como las simples.
        // ENT_SUBSTITUTE - para reemplazar la codificación no válida con carácter de reemplazo Unicode U + FFFD (UTF-8) o & # FFFD un designado; carácter en lugar de devolver una cadena vacía.
        return htmlspecialchars($html, ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8");
    }
    
    function csrf() {

        

        // el empty determina si se encuentra vacio, es similar a evaluar una variable en un if
        if (empty($_SESSION['csrf'])) {
            if (function_exists('random_bytes')) {

                $_SESSION['csrf'] = bin2hex(random_bytes(32));

            } else if (function_exists('mcrypt_create_iv')) {
                $_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MYCRYPT_DEV_URANDOM));
            } else {
                $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }
    }

?>