<?php

declare(strict_types=1);

namespace Kamephis\Avatar\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Kamephis\Avatar\Enum\AvatarTypes;

/**
 * Class Avatar
 * @package Kamephis\Avatar\Block
 * Block responsible for generating and displaying the customer's avatar.
 */
class Avatar extends Template
{
    private const GRAVATAR_API_BASE_URL = 'https://www.gravatar.com/avatar/';

    public function __construct(
        private Session              $customerSession,
        private ScopeConfigInterface $scopeConfig,
        Context                      $context,
        array                        $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * Generates a Gravatar URL based on the current customer's email address, type of Gravatar image, and size.
     * @param AvatarTypes $type The type of Gravatar image to use. Defaults to ROBOHASH if not provided.
     * @param int|null $size The size of the Gravatar image in pixels. Defaults to 80 if not provided.
     * @return string The generated Gravatar URL.
     * @todo: use the values of the admin form
     */
    public function getGravatarUrl(AvatarTypes $type = AvatarTypes::ROBOHASH, ?int $size = null): string
    {
        $avatarType = $this->scopeConfig->getValue('kamephis_avatar/general/type') ?? AvatarTypes::ROBOHASH;
        $size = $size ?? $this->scopeConfig->getValue('kamephis_avatar/general/size') ?? 80;

        $email = $this->customerSession->getCustomer()->getEmail();
        $hash = md5(strtolower(trim($email)));

        $url = sprintf(
            '%s%s?s=%d&d=%s&r=pg&type=%s',
            self::GRAVATAR_API_BASE_URL,
            $hash,
            $size,
            $avatarType->getType(),
            $type->getType()
        );

        return $url;
    }

    /**
     * Returns HTML code for the customer's avatar.
     * @return string HTML code for the avatar.
     */
    public function getAvatarHtml(): string
    {
        $avatarUrl = $this->getGravatarUrl();
        $altText = __('User Avatar');
        return sprintf('<img src="%s" alt="%s"/>', $avatarUrl, $altText);
    }
}
