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
     * Test for valid AvatarTypes
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

        $this->assertIsArray($expected, 'Test if cases list is of the type array.');
        $this->assertEquals($expected, AvatarTypes::cases(), 'Test if array cases match.');
    }

    /**
     * Test if avatar URL is valid
     * @return void
     */
    public function testAvatarUrl()
    {
        $hash = '0bc83cb571cd1c50ba6f3e8a78ef1346';
        $type = 'identicon';
        $expected = urlencode('https://www.gravatar.com/avatar/' . $hash . '?d=' . $type);
        $avatarTestType = AvatarTypes::IDENTICON;
        $result = $this->object->getAvatarUrl($hash, $avatarTestType);

        $this->assertEquals($expected, $result, 'Test if Test URL is equal to actual URL.');
    }

    /**
     * Test email to md5 conversion
     * @return void
     */
    public function testEmailToHash()
    {
        $expected = 'b24a7ab8a255cd5904c5bb56f7fb824c';
        $email = 'Info@test.com ';

        $this->assertEquals($expected, $this->object->emailToHash($email), 'Test if E-Mail hash is correct.');
        $this->assertMatchesRegularExpression('/^[a-f0-9]{32}$/', $this->object->emailToHash($email), 'Test if valid MD5 hash');
    }
}
