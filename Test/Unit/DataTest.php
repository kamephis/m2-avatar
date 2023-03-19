<?php
namespace Kamephis\Test\Unit;

use PHPUnit\Framework\TestCase;
use Kamephis\Avatar\Helper\Data;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\LogFactory;
use Magento\Framework\Exception\LocalizedException;

class DataTest extends TestCase
{
    private Data $object;
    private Context $contextMock;
    private CustomerSession $sessionMock;
    private CustomerRepositoryInterface $customerRepositoryMock;
    private LogFactory $logFactoryMock;

    protected function setUp(): void
    {
        $this->contextMock = $this->getMockBuilder(Context::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->customerRepositoryMock = $this->getMockBuilder(CustomerRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sessionMock = $this->getMockBuilder(CustomerSession::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->logFactoryMock = $this->getMockBuilder(LogFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new Data(
            $this->contextMock,
            $this->customerRepositoryMock,
            $this->sessionMock,
            $this->logFactoryMock
        );
    }

    /**
     * @test
     */
    public function testGetCustomerIdThrowsExceptionIfCustomerIsNotLoggedIn(): void
    {
        $this->expectException(LocalizedException::class);
        $this->expectExceptionMessage('Customer is not logged in');

        // Set the return value of isLoggedIn() method to false
        $this->sessionMock
            ->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $this->object->getCustomerId();
    }

    /**
     * @test
     */
    public function testGetCustomerData(): void
    {
        $this->sessionMock
            ->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $this->expectException(LocalizedException::class);
        $this->object->getCustomerData();
    }

    /**
     * @test
     */
    public function testGetCustomerAttribute(): void
    {
        $attributeCode = 'email';

        $this->sessionMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $this->expectException(LocalizedException::class);
        $this->object->getCustomerAttribute($attributeCode);
    }

    /**
     * @test
     */
    public function testGetCustomerLastLoginDate(): void
    {
        $this->sessionMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $this->expectException(LocalizedException::class);
        $this->object->getCustomerLastLoginDate();
    }
}
