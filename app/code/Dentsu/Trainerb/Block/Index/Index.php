<?php
/**
 * Copyright © 2024 Dentsu . 
 * Author: Sumit Sharma
 * All rights reserved.
 */
namespace Dentsu\Trainerb\Block\Index;

use Dentsu\Trainerb\Block\Index\BaseBlock;

class Index extends BaseBlock
{
	/**
	 * Returns action url for contact form. Form submit URL
	 *
	 * @return string
	 */
	public function getFormAction()
	{
		return $this->getUrl('courses/index/addcourse', ['_secure' => true]);
	}
}