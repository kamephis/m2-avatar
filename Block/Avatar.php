<?php

declare(strict_types=1);

namespace Kamephis\Avatar\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Kamephis\Avatar\Enum\AvatarTypes;
use Magento\Framework\App\Helper\AbstractHelper;
use Kamephis\Avatar\Helper\Data;

/**
 * Class Avatar
 * @package Kamephis\Avatar\Block
 * Block responsible for generating and displaying the customer's avatar.
 */
class Avatar extends Template
{
    private const GRAVATAR_API_BASE_URL = 'https://www.gravatar.com/avatar/';

    public function __construct(
        private readonly Session                $customerSession,
        private readonly ScopeConfigInterface    $scopeConfig,
        public readonly AbstractHelper          $dataHelper,
        Context                                 $context,
        array                                   $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * Generates a Gravatar URL for the given email address, avatar type, size, and default image.
     *
     * @param AvatarTypes|null $type The type of avatar to generate. Defaults to AvatarTypes::ROBOHASH if not provided.
     * @param int|null $size The size of the avatar in pixels. Defaults to 80 if not provided.
     * @param string|null $default The default image to use if no avatar is found. Defaults to 'y' if not provided.
     * @return string The generated Gravatar URL.
     * @throws \Magento\Framework\Exception\NoSuchEntityException If the customer session is not available.
     */
    public function getGravatarUrl(AvatarTypes $type = AvatarTypes::ROBOHASH, ?int $size = null, ?string $default = 'y'): string
    {
        $avatarType = $this->scopeConfig->getValue('kamephis_avatar/general/type') ?? $type->getType();
        $size = $size ?? $this->scopeConfig->getValue('kamephis_avatar/general/size') ?? 80;
        $urlParams = $default === 'y' ? '%s%s?s=%d&d=%s&r=pg&f=y' : '%s%s?s=%d&d=%s&r=pg';
        $email = $this->dataHelper->getCustomerAttribute('email');
        $hash = md5(strtolower(trim($email)));

        $url = sprintf(
            $urlParams,
            self::GRAVATAR_API_BASE_URL,
            $hash,
            $size,
            $avatarType,
            $default
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

    /**
     * Returns HTML code for the customer's avatar with user information.
     * @return string HTML code for the avatar.
     */
    public function getInfoBlock(): string
    {
        $customer = $this->customerSession->getCustomer();
        $avatarUrl = $this->getGravatarUrl();
        $altText = __('User Avatar');
        $userName = $customer->getUserName();
        $firstName = $customer->getFirstname();
        $lastName = $customer->getLastname();
        $email = $customer->getEmail();
        $userInfo = sprintf('%s %s (%s)', $firstName, $lastName, $email);

        return sprintf(
            '<div class="avatar-wrapper">%s<div class="avatar-info">%s<br>%s</div></div>',
            sprintf('<img src="%s" alt="%s"/>', $avatarUrl, $altText),
            $userName,
            $userInfo
        );
    }
    /**
     * Returns the customer's last login date.
     * @return string The customer's last login date in the format Y-m-d H:i:s.
     */
    public function getLastLoginDate(): string
    {
        return $this->dataHelper->getCustomerLastLoginDate($this->customerSession->getCustomerId());
    }
    /**
     * Returns the URL for the customer's avatar information.
     *
     * @return string The URL for the customer's avatar information.
     */
    public function getAvatarInfoUrl(): string
    {
        return $this->getUrl('kamephis_customeravatar/index/index');
    }
}
