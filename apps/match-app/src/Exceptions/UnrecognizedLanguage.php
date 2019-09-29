<?php
namespace App\Exceptions;


class UnrecognizedLanguage extends \Exception
{
    public function __construct($lang)
    {
        parent::__construct(
            str_replace("%s", $lang, "Can't recognize periodicity %s"),
            0,
            null
        );
    }
}