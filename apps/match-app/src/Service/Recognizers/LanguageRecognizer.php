<?php

namespace App\Service\Recognizers;

use App\Exceptions\UnrecognizedLanguage;

class LanguageRecognizer
{
    public function recognizeLanguage(string $lang)
    {
        $regexpRu = '/^(ру)|(ru)/';

        $regexpEn = '/^(en)|(анг)/';

        if (preg_match($regexpRu, $lang)) return 'ru';

        if (preg_match($regexpEn, $lang)) return 'en';

        throw new UnrecognizedLanguage($lang);
    }
}
