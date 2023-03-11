<?php

declare(strict_types=1);

namespace Kamephis\Avatar\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Helper\AbstractHelper;


class CustomerHelper extends AbstractHelper
{
    private CustomerRepositoryInterface $customerRepository;
    private CustomerSession $customerSession;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerSession $customerSession
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerSession = $customerSession;
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

        return (int) $this->customerSession->getCustomerId();
    }

    /**
     * Get the current customer's data as an array
     *
     * @throws LocalizedException if the customer is not logged in
     */
    public function getCustomerData(): array
    {
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
        $customerData = $this->getCustomerData();

        if (!isset($customerData[$attributeCode])) {
            throw new LocalizedException(__("Customer attribute '%1' does not exist", $attributeCode));
        }

        return $customerData[$attributeCode];
    }
}
