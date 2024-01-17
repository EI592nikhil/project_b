<?php
namespace Dentsu\Trainerb\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;

class AddCourse extends \Magento\Framework\App\Action\Action
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
	protected $filesystem;
	protected $uploaderFactory;
	protected $messageManager;
	protected $mediaDirectory;
	protected $fileId = 'course_attachment';
	protected $allowedExtensions = ['.pdf, .png, .jpg, .jpeg, .docx'];
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
		Filesystem $filesystem,
		UploaderFactory $uploaderFactory,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Framework\App\Filesystem\DirectoryList $mediaDirectory
	) {
		parent::__construct($context);
		$this->_cacheTypeList = $cacheTypeList;
		$this->_cacheState = $cacheState;
		$this->_cacheFrontendPool = $cacheFrontendPool;
		$this->postCoursesFactory = $postCoursesFactory;
		$this->resultPageFactory = $resultPageFactory;
		$this->filesystem = $filesystem;
		$this->uploaderFactory = $uploaderFactory;
		$this->mediaDirectory = $filesystem->getDirectoryWrite($mediaDirectory::MEDIA);
		$this->messageManager = $messageManager;

	}
	/**
	 * Flush cache storage
	 */
	public function execute()
	{
		try {
			$data = (array) $this->getRequest()->getPost();
			$attachedfileName = $_FILES['course_attachment']['name'];

			if ($data && isset($_POST['submit'])) {
				$model = $this->postCoursesFactory;
				//File upload start
				$destinationPath = $this->getFileUploadPath();
				try {
					$uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
						->setAllowCreateFolders(true);
					if (!$uploader->save($destinationPath)) {
						throw new LocalizedException('File cannot be saved to path: $1', $destinationPath);
					}
					// process the uploaded file
				} catch (\Exception $e) {
					$this->messageManager->addErrorMessage($e->getMessage());
				}
				//	$uploadedFile = $this->uploadFile();

				//Data save to database start
				$post['course_name'] = $data['course_name'];
				$post['course_url'] = $data['course_url'];
				$post['course_attachment'] = $attachedfileName;
				$post['approval_flag'] = $data['approval_flag'];

				$model->setData($post)->save();
				$sendApprovalMail = $this->sendApprovalMail();
				$this->messageManager->addSuccessMessage(__("Course Added Successfully."));

			}
		} catch (\Exception $e) {
			$this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
		}

		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		$resultRedirect->setUrl($this->_redirect->getRefererUrl());
		return $resultRedirect;
	}

	public function getFileUploadPath()
	{
		return $this->filesystem
			->getDirectoryWrite(DirectoryList::MEDIA)
			->getAbsolutePath('course_attachment/');
	}

	public function sendApprovalMail()
	{
		// update with your recipients
		$to = "sumit.isobar@gmail.com";
		// update with your email subject
		$subject = "Training Course submitted for Approval";

		// update with your template requirements
		$message = "
		<html>
		<head>
		<title>Trainer Course for Approval</title>
		</head>
		<body>
		<p>Hello! Kindly review training course and approve!</p>
		</body>
		</html>
		";

		// From is required - update with your sender
		$headers = 'From: <sumit.sharma@dentsu.com>' . "\r\n";

		// The content type is required when sending HTML Based emails.
		$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers = "MIME-Version: 1.0" . "\r\n";

		// calling the mail function to send the mail using the hosted web server.
		mail($to, $subject, $message, $headers);

	}
	public function uploadFile()
	{
		// this folder will be created inside "pub/media" folder
		$yourFolderName = 'course_attachment/';

		// "upload_custom_file" is the HTML input file name
		$yourInputFileName = 'course_attachment';

		try {
			$file = $this->getRequest()->getFiles('course_attachment');

			$fileName = ($file && array_key_exists('name', $file)) ? $file['name'] : null;

			//if ($file && $fileName) {

			$target = $this->mediaDirectory->getAbsolutePath($yourFolderName);
			echo $target;
			print_r($fileName);
			die('test');
			/** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
			$uploader = $this->fileUploader->create(['fileId' => $yourInputFileName]);

			// set allowed file extensions
			$uploader->setAllowedExtensions(['jpg', 'pdf', 'doc', 'png', 'zip']);

			// allow folder creation
			$uploader->setAllowCreateFolders(true);

			// rename file name if already exists 
			$uploader->setAllowRenameFiles(true);

			// upload file in the specified folder
			$result = $uploader->save($target);

			//echo '<pre>'; print_r($result); exit;

			if ($result['file']) {
				$this->messageManager->addSuccess(__('File has been successfully uploaded.'));
			}

			return $target . $uploader->getUploadedFileName();
			//}
		} catch (\Exception $e) {
			$this->messageManager->addError($e->getMessage());
		}

		return false;
	}

}
