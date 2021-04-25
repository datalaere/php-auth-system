<?php

use Classes\Config;

function config($path)
{
    return Config::get($path);
}