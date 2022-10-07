<?php

namespace Kamephis\Avatar\Model;

use Kamephis\Avatar\Api\AvatarInterface;

class Avatar implements AvatarInterface
{
    /**
     * @param string $email
     * @return mixed|void
     */
    public function emailToHash(string $email)
    {
        return md5(strtolower(trim($email)));
    }
}
