<?php

declare(strict_types=1);

namespace Kamephis\Avatar\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\LogFactory;
use Magento\Framework\App\Helper\Context;
use DateTimeZone;
use DateTime;

class Data extends AbstractHelper
{
    private CustomerRepositoryInterface $customerRepository;
    private CustomerSession $customerSession;
    private LogFactory $logFactory;
    private DateTimeZone $timeZone;

    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerSession $customerSession
     * @param LogFactory $logFactory
     */
    public function __construct(
        Context                     $context,
        CustomerRepositoryInterface $customerRepository,
        CustomerSession             $customerSession,
        LogFactory                  $logFactory
    )
    {
        $this->customerRepository = $customerRepository;
        $this->customerSession = $customerSession;
        $this->logFactory = $logFactory;
        parent::__construct($context);
    }

    /**
     * Get the current customer's ID
     *
     * @throws LocalizedException if the customer is not logged in
     */
    public function getCustomerId(): int
    {
        if (!$this->customerSession->isLoggedIn()) {
            throw new LocalizedException(__('Customer is not logged in'));
        }

        return (int)$this->customerSession->getCustomerId();
    }

    /**
     * Get the current customer's data as an array
     *
     * @throws LocalizedException if the customer is not logged in
     */
    public function getCustomerData(): array
    {
        if (!$this->customerSession->isLoggedIn()) {
            throw new LocalizedException(__('Customer is not logged in'));
        }
        $customerId = $this->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);

        return $customer->__toArray();
    }

    /**
     * Get a specific customer attribute for the current customer
     *
     * @param string $attributeCode The code of the customer attribute to retrieve
     *
     * @throws LocalizedException if the customer is not logged in
     * @throws LocalizedException if the attribute does not exist
     */
    public function getCustomerAttribute(string $attributeCode)
    {
        if (!$this->customerSession->isLoggedIn()) {
            throw new LocalizedException(__('Customer is not logged in'));
        }

        $customerData = $this->getCustomerData();

        if (!isset($customerData[$attributeCode])) {
            throw new LocalizedException(__("Customer attribute '%1' does not exist", $attributeCode));
        }

        return $customerData[$attributeCode];
    }

    /**
     * Get the last login date of the current customer
     *
     * @throws LocalizedException if the customer is not logged in
     */
    public function getCustomerLastLoginDate(): string
    {
        if (!$this->customerSession->isLoggedIn()) {
            throw new LocalizedException(__('Customer is not logged in'));
        }

        try {
            $customerId = $this->getCustomerId();
            $customerSession = $this->customerSession;
            $loginDate = $customerSession->getData('customer_last_login_date');
            $timezone = $this->getTimeZoneConfig();
            $dateTime = new DateTime('' . $loginDate, new DateTimeZone($timezone));

            return $dateTime->format('d.m.Y H:i');
        } catch (LocalizedException $e) {
            throw new LocalizedException(__('Error retrieving customer last login date: %1', $e->getMessage()), $e);
        } catch (\Exception $e) {
            throw new LocalizedException(__('An error occurred while retrieving customer last login date: %1', $e->getMessage()), $e);
        }
    }

    /**
     * Get Timezone from the store configuration
     * @return string
     */
    private function getTimeZoneConfig(): string
    {
        try {
            return $this->scopeConfig?->getValue(
                'general/locale/timezone',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? 'UTC';
        } catch (LocalizedException $e) {
            throw new LocalizedException(__('Error retrieving timezone: %1', $e->getMessage()), $e);
        }
    }
}
