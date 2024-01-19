<?php
declare(strict_types=1);

namespace Dentsu\Trainerb\Observer\Frontend\Customer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\ResponseInterface; 

class Login implements ObserverInterface
{
    protected $customerSession;
    protected $urlInterface;
    protected $redirect;
    protected $response; 

    public function __construct(
        CustomerSession $customerSession,
        UrlInterface $urlInterface,
        RedirectInterface $redirect,
        ResponseInterface $response
    ) {
        $this->customerSession = $customerSession;
        $this->urlInterface = $urlInterface;
        $this->redirect = $redirect;
        $this->response = $response;
    }

    public function execute(Observer $observer)
    {
        // Code to work on redirect with hard coded customer IDs
         // $customer = $observer->getEvent()->getCustomer();  // code
       //   $groupId = $customer->getGroupId(); // code
       // if ($groupId == '1') {   // code
            // Redirect to 'My Orders' section  (Comment)
            //$this->redirect->redirect($this->customerSession->getBeforeAuthUrl() ?: $this->urlInterface->getUrl('sales/order/history')); (Comment)

      // $this->redirect->redirect($this->response, 'sales/order/history');  //code

            //   $this->redirect->redirect($this->customerSession->getBeforeAuthUrl() ?: $this->urlInterface->getUrl('sales/order/history'));

       // } // code





        // Code to work on redirect to fetch customer group ID dynamically
        $customerGroupId = $this->customerSession->getCustomerGroupId(); // code
        // Check if the customer group is 'Trainer'
        if ($customerGroupId == ' ') {  // code
            // Redirect to 'My Orders' section
            //$this->redirect->redirect($this->customerSession->getBeforeAuthUrl() ?: $this->urlInterface->getUrl('sales/order/history'));

            $this->redirect->redirect($this->response, 'sales/order/history');  // code

            //   $this->redirect->redirect($this->customerSession->getBeforeAuthUrl() ?: $this->urlInterface->getUrl('sales/order/history'));

         } // code

    }
}


