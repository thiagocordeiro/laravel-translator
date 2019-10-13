<?php declare(strict_types=1);

namespace Translator\Infra\Exception;

use Exception;

class InvalidTranslationFile extends Exception
{
    public function __construct(string $language)
    {
        parent::__construct(sprintf('Invalid translation file for language %s', $language));
    }
}
