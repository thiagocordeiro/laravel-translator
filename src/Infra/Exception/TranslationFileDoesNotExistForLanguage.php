<?php declare(strict_types=1);

namespace Translator\Infra\Exception;

use Exception;

class TranslationFileDoesNotExistForLanguage extends Exception
{
    public function __construct(string $language)
    {
        parent::__construct(sprintf("Translation file does not exist for %s", $language));
    }
}
