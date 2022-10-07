<?php

namespace Kamephis\Avatar\Test\Unit;

use Kamephis\Avatar\Model\Avatar;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use PHPUnit\Framework\TestCase;

class TestAvatar extends TestCase
{
    /**
     * @var Avatar|object
     */
    private Avatar $object;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        $objectManager = new ObjectManager($this);
        $this->object = $objectManager->getObject(Avatar::class);
    }

    /**
     * Test emailToHash
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testEmailToHash()
    {
        $email = "MyEmailAddress@example.com ";
        $hash = "0bc83cb571cd1c50ba6f3e8a78ef1346";
        $this->assertEquals($hash, $this->object->emailToHash($email));
    }
}
