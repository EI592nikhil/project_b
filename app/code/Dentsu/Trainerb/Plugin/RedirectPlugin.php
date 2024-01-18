<?php

namespace Dentsu\Trainerb\Plugin;

use Magento\Customer\Model\Account\Redirect as Subject;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\UrlInterface;

class RedirectPlugin
{
    protected $resultRedirectFactory;
    protected $customerSession;
    protected $urlInterface;

    public function __construct(
        RedirectFactory $resultRedirectFactory,
        Session $customerSession,
        UrlInterface $urlInterface
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->customerSession = $customerSession;
        $this->urlInterface = $urlInterface;
    }

    public function aroundGetRedirect(Subject $subject, callable $proceed)
    {
        // Call the original method
        $resultRedirect = $proceed();

        // Check if the customer is a trainer (based on the customer group)
        if ($this->isTrainer()) {
            // Redirect to 'My Orders' section
            $resultRedirect->setPath('sales/order/history');
        }

        return $resultRedirect;
    }

    private function isTrainer()
    {
        // Replace YOUR_TRAINER_CUSTOMER_GROUP_ID with the actual ID of the trainer customer group
        $trainerGroupIds = ['2'];

        $customerGroupId = $this->customerSession->getCustomerGroupId();

        return in_array($customerGroupId, $trainerGroupIds);
    }
}
