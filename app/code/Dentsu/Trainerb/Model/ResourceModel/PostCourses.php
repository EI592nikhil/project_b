<?php
namespace Dentsu\Trainerb\Model\ResourceModel;


class PostCourses extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('trainer_course', 'post_id');
    }

}