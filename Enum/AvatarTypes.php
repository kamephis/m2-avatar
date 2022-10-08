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

    public function getAll()
    {
        return $this;
    }
    
    /**
     * @return string
     */
    public function getType() : string
    {
        return match($this)
        {
            self::IDENTICON => 'identicon',
            self::MONSTERID => 'monterid',
            self::WAVATAR => 'wavatar',
            self::RETRO => 'retro',
            self::ROBOHASH => 'robohash',
            self::BLANK => 'blank',
            self::NOTFOUND => '404',
        };
    }
}
