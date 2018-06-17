<?php

namespace frontend\components\helpers;

/**
 * Class StopWordsHelper
 * @package frontend\components\helpers
 */
class StopWordsHelper
{
    /**
     * @return array
     */
    public static function getCensuredWords()
    {
        return [
            'fuck',
            'asshole',
        ];
    }
}

