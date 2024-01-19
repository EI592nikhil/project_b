<?php

namespace Dentsu\Trainerb\Block\View\Element\Html\Link;

use Magento\Customer\Model\Session as CustomerSession;

class Current extends \Magento\Framework\View\Element\Html\Link\Current
{

    protected $_customerSession;
    protected $_defaultPath;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\DefaultPathInterface $defaultPath
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\DefaultPathInterface $defaultPath,
        CustomerSession $CustomerSession,
        array $data = []
    ) {
        parent::__construct($context, $defaultPath, $data);
        $this->_customerSession = $CustomerSession;
    }

    public function toHtml()
    {
        if ($this->_customerSession->getCustomer()->getGroupId() == '2') {
            return parent::toHtml();
        }
        return '';
    }
}
?>