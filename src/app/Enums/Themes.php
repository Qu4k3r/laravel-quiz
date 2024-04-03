<?php

namespace App\Enums;

enum Themes: string
{
    case Sql = 'SQL';
    case Laravel = 'Laravel';
    case JavasCript = 'Javascript';

    public static function getRandom(): self
    {
        $themes = Themes::cases();
        $position = array_rand($themes);
        return $themes[$position];
    }
}
