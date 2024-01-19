<?php
declare(strict_types=1);

namespace Dentsu\Trainerb\Observer\Frontend\Customer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Response\RedirectInterface;

class Login implements \Magento\Framework\Event\ObserverInterface
{
    protected $customerSession;
    protected $urlInterface;
    protected $redirect;

    public function __construct(
        CustomerSession $customerSession,
        UrlInterface $urlInterface,
        RedirectInterface $redirect
    ) {
        $this->customerSession = $customerSession;
        $this->urlInterface = $urlInterface;
        $this->redirect = $redirect;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $groupId = $customer->getGroupId();

        // Check if the customer group is 'Trainer'
        if ($groupId =='2') {
            // Redirect to 'My Orders' section
            //$this->redirect->redirect($this->customerSession->getBeforeAuthUrl() ?: $this->urlInterface->getUrl('sales/order/history'));
        
            $this->_redirect->redirect($this->_response, 'sales/order/history');
        }

    }
}

