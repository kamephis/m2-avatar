<?php
namespace Kamephis\Avatar\Api;

interface AvatarInterface
{
    /**
     * @param string $email
     * @return mixed
     */
    public function emailToHash(string $email);
}
