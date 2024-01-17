<?php
namespace Dentsu\Trainerb\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	/**
	 * @var \Magento\Framework\App\Cache\TypeListInterface
	 */
	protected $_cacheTypeList;
	/**
	 * @var \Magento\Framework\App\Cache\StateInterface
	 */
	protected $_cacheState;
	/**
	 * @var \Magento\Framework\App\Cache\Frontend\Pool
	 */
	protected $_cacheFrontendPool;
	/**
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
	protected $postCoursesFactory;
	protected $resultPageFactory;
	protected $messageManager;
	/**
	 * @param Action\Context $context
	 * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
	 * @param \Magento\Framework\App\Cache\StateInterface $cacheState
	 * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
	 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
	 */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
		\Magento\Framework\App\Cache\StateInterface $cacheState,
		\Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
		\Dentsu\Trainerb\Model\PostCourses $postCoursesFactory,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\Message\ManagerInterface $messageManager
	) {
		parent::__construct($context);
		$this->_cacheTypeList = $cacheTypeList;
		$this->_cacheState = $cacheState;
		$this->_cacheFrontendPool = $cacheFrontendPool;
		$this->postCoursesFactory = $postCoursesFactory;
		$this->resultPageFactory = $resultPageFactory;
		$this->messageManager = $messageManager;

	}
	/**
	 * Flush cache storage
	 */
	public function execute()
	{
		$this->_view->loadLayout();
		$this->_view->getLayout()->initMessages();
		$this->_view->getPage()->getConfig()->getTitle()->set(__('Add Course'));
		/** @var \Magento\Framework\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		return $resultPage;
	}
}
