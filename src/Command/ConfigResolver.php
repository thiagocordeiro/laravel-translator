<?php

namespace Translator\Command;

class ConfigResolver
{
    /**
     * @param null $key
     * @param null $default
     * @return \Illuminate\Config\Repository|mixed
     */
    public function get($key = null, $default = null)
    {
        return config($key, $default);
    }
}
