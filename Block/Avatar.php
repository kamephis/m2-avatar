<?php

declare(strict_types=1);

namespace Kamephis\Avatar\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Kamephis\Avatar\Enum\AvatarTypes;

class Avatar extends Template
{
    private const GRAVATAR_API_BASE_URL = 'https://www.gravatar.com/avatar/';

public function __construct(
    private \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    Context $context,
    array $data = [],
) {
    parent::__construct($context, $data);
}
    /**
    Generates a Gravatar URL based on the provided email address, type of Gravatar image, and size.
    @param string $email The email address to generate the Gravatar for.
    @param GravatarType $type The type of Gravatar image to use. Defaults to MYSTERY_PERSON if not provided.
    @param int|null $size The size of the Gravatar image in pixels. Defaults to 80 if not provided.
    @return string The generated Gravatar URL.
     */
    public function getGravatarUrl(string $email, AvatarTypes $type = AvatarTypes::MONSTERID, ?int $size = null): string
    {
        $hash = md5(strtolower(trim($email)));

        $default = $this->scopeConfig->getValue('kamephis_avatar/gravatar/default') ?? AvatarTypes::MONSTERID;

        $size = $size ?? $this->scopeConfig->getValue('kamephis_avatar/gravatar/size') ?? 80;

        $url = sprintf(
            '%s%s?s=%d&d=%s&r=pg&type=%s',
            self::GRAVATAR_API_BASE_URL,
            $hash,
            $size,
            $default->getType(),
            $type->getType()
        );
        return $url;
    }
}
