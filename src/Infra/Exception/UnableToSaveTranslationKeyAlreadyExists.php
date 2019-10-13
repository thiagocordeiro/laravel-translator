<?php declare(strict_types=1);

namespace Translator\Infra\Exception;

use Exception;
use Translator\Translator\Translation;

class UnableToSaveTranslationKeyAlreadyExists extends Exception
{
    public function __construct(Translation $translation, string $language)
    {
        parent::__construct(
            sprintf(
                'Unable to save translation, key %s already for language %s',
                $translation->getKey(),
                $language
            )
        );
    }
}
