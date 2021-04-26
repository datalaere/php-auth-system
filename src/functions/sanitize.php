<?php

function e($string, $raw = false) {
    if(!$raw){  
        echo htmlentities($string, ENT_QUOTES, 'UTF-8');
    } else {
        echo $string;
    }
}