<?php

declare(strict_types=1);

namespace Kamephis\Avatar\Controller\Avatar;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kamephis\Avatar\Block\Avatar;

/**
 * Class Index
 * @package Kamephis\Avatar\Controller\Avatar
 */
class Index extends Action
{
    /**
     * @var Avatar
     */
    protected $avatarBlock;

    /**
     * Index constructor.
     * @param Context $context
     * @param Avatar $avatarBlock
     */
    public function __construct(
        Context $context,
        Avatar $avatarBlock
    ) {
        parent::__construct($context);
        $this->avatarBlock = $avatarBlock;
    }

    /**
     * Execute action
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $resultJson->setData([
            'avatar_url' => $this->avatarBlock->getGravatarUrl(),
            'avatar_html' => $this->avatarBlock->getAvatarHtml(),
            'info_block' => $this->avatarBlock->getInfoBlock(),
            'last_login_date' => $this->avatarBlock->getLastLoginDate(),
        ]);
        return $resultJson;
    }
}
