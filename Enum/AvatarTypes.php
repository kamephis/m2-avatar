<?php

namespace Kamephis\Avatar\Enum;

enum AvatarTypes : int
{
    case IDENTICON = 0;
    case MONSTERID = 1;
    case WAVATAR = 2;
    case RETRO = 3;
    case ROBOHASH = 4;
    case BLANK = 5;
    case NOTFOUND = 6;

    public function getName() : string
    {
        return match($this)
        {
            self::IDENTICON => 'Identicon',
            self::MONSTERID => 'Monster ID',
            self::WAVATAR => 'Wavatar',
            self::RETRO => 'Retro',
            self::ROBOHASH => 'Robohash',
            self::BLANK => 'Blank',
            self::NOTFOUND => '404 Not Found',
        };
    }

    public static function getAll(): array
    {
        return [
            self::IDENTICON,
            self::MONSTERID,
            self::WAVATAR,
            self::RETRO,
            self::ROBOHASH,
            self::BLANK,
            self::NOTFOUND,
        ];
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return match($this)
        {
            self::IDENTICON => 'identicon',
            self::MONSTERID => 'monsterid',
            self::WAVATAR => 'wavatar',
            self::RETRO => 'retro',
            self::ROBOHASH => 'robohash',
            self::BLANK => 'blank',
            self::NOTFOUND => '404',
        };
    }
}
