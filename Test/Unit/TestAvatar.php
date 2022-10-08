<?php

namespace Kamephis\Avatar\Test\Unit;

use Kamephis\Avatar\Model\Avatar;
use Kamephis\Avatar\Enum\AvatarTypes;
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
     * @return void
     */
    public function testAvatarTypes()
    {
        $expected = 'identicon';
        $type = AvatarTypes::IDENTICON;
        $this->assertEquals($expected, AvatarTypes::tryFrom(0)->getType());
    }

    /**
     * @return void
     */
    public function testAvatarCases()
    {
        $expected = [
            AvatarTypes::IDENTICON,
            AvatarTypes::MONSTERID,
            AvatarTypes::WAVATAR,
            AvatarTypes::RETRO,
            AvatarTypes::ROBOHASH,
            AvatarTypes::BLANK,
            AvatarTypes::NOTFOUND
        ];

        $this->assertIsArray($expected, 'Cases list is not of type array.');
        $this->assertEquals($expected, AvatarTypes::cases(), 'Arrays are not identical.');
    }
}
