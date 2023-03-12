<?php

declare(strict_types=1);

namespace Kamephis\Avatar\Controller\Index;

use Kamephis\Avatar\Block\Avatar;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Index
 * @package Kamephis\Avatar\Controller\Index
 */
class Index extends Action
{
    private Avatar $avatarBlock;
    private JsonFactory $resultJsonFactory;

    public function __construct(
        Avatar $avatarBlock,
        JsonFactory $resultJsonFactory,
        Context $context
    ) {
        $this->avatarBlock = $avatarBlock;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute(): Json
    {
        $avatarHtml = $this->avatarBlock->getAvatarHtml();

        return $this->resultJsonFactory->create()->setData([
            'avatarHtml' => $avatarHtml
        ]);
    }
}
