<?php declare(strict_types=1);

namespace Translator\Translator\Exception;

use Exception;

class InvalidExtensionsConfiguration extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid extensions configuration');
    }
}
