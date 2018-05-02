<?php

namespace app\ext;

/**
 * Class Html
 *
 * @package app\ext
 */
class Html extends \yii\bootstrap\Html
{
    /**
     * @param $word
     *
     * @return string
     */
    public static function ucfirstEncode($word)
    {
        return ucfirst(static::encode($word));
    }
}
