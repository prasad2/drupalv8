<?php

/**
* 
*/

namespace Drupal\cntform\Controller;
use Drupal\Core\Controller\ControllerBase;


class ContactFormController extends ControllerBase
{
	
	public function content()
	{
		return array(
				      '#type' => 'markup',
				      '#markup' => $this->t('Hello, World!'),
				    );
	}
}