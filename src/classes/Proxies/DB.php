<?php

namespace Classes\Proxies;

use Classes\Proxies\Proxy;

class DB extends Proxy {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getProxyAccessor() 
    { 
        return 'DB'; 
    }

}