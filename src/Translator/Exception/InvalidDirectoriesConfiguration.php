<?php declare(strict_types=1);

namespace Translator\Translator\Exception;

use Exception;

class InvalidDirectoriesConfiguration extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid directories configuration');
    }
}
