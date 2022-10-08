<?php
namespace Kamephis\Avatar\Api;

use Kamephis\Avatar\Enum\AvatarTypes;

interface AvatarInterface
{
    /**
     * @param string $email
     * @return mixed
     */
    public function emailToHash(string $email);

    /**
     * @param string $hash
     * @param string $type
     * @return string
     */
    public function getAvatarUrl(string $hash, AvatarTypes $type) : string;
}
