<?php
namespace Dentsu\Trainerb\Model;

class PostCourses extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'trainer_course';

    protected $_cacheTag = 'trainer_course';

    protected $_eventPrefix = 'trainer_course';

    protected function _construct()
    {
        $this->_init('Dentsu\Trainerb\Model\ResourceModel\PostCourses');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}