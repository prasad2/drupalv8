<?php

/**
 * @file
 * Contains \Drupal\cntform\Form\ContactForm.
 */

namespace Drupal\cntform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class ContactForm extends FormBase
{
	/**
   	* {@inheritdoc}
   	*/
	public function getFormId() {
   			 
   		return 'cntform';
  	}

  	public function buildForm(array $form, FormStateInterface $form_state) 
  	{
    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate Name:'),
      '#required' => TRUE,
    );
    $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
    );
    $form['candidate_number'] = array (
      '#type' => 'tel',
      '#title' => t('Mobile no'),
    );
    
    $form['candidate_copy'] = array(
      '#type' => 'checkbox',
      '#title' => t('Send me a copy of the application.'),
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }


}