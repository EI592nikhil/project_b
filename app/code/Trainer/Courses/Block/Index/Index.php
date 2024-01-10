<?php
/**
 * Copyright © 2016 Jute . All rights reserved.
 */
namespace Trainer\Courses\Block\Index;

use Trainer\Courses\Block\Index\BaseBlock;

class Index extends BaseBlock
{
	/**
	 * Returns action url for contact form. Form submit URL
	 *
	 * @return string
	 */
	public function getFormAction()
	{
		return $this->getUrl('courses/index/post', ['_secure' => true]);
	}
}