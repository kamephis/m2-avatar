<?php

namespace Kamephis\Avatar\Model;

use Kamephis\Avatar\Api\AvatarInterface;
use Kamephis\Avatar\Enum\AvatarTypes;

class Avatar implements AvatarInterface
{
    const GRAVATAR_BASE_URL = "https://www.gravatar.com/avatar/";
    /**
     * @param string $email
     * @return string
     */
    public function emailToHash(string $email): string
    {
        return md5(strtolower(trim($email)));
    }

    /**
     * @param string $hash
     * @param AvatarTypes $type
     * @return string
     */
    public function getAvatarUrl(string $hash, AvatarTypes $type): string
    {
        // https://www.gravatar.com/avatar/0bc83cb571cd1c50ba6f3e8a78ef1346?d=identicon
        return urlencode(self::GRAVATAR_BASE_URL . $hash . '?d=' . $type->value);
    }

}
