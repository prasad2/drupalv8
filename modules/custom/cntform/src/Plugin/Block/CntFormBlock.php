<?php

namespace Drupal\cntform\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "cntform_block",
 *   admin_label = @Translation("Contact Form block"),
 *   category = @Translation("Hello World"),
 * )
 */
class CntFormBlock extends BlockBase implements BlockPluginInterface
{

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => $this->t('contact, form!'),
    );    	
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    // Get the list of options to populate the first dropdown.
  	$options_first = $this->first_dropdown_options();


	  // If we have a value for the first dropdown from $form_state['values'] we use
	  // this both as the default value for the first dropdown and also as a
	  // parameter to pass to the function that retrieves the options for the
	  // second dropdown.
	  $selected = isset($form_state->values['content_type']) ? $form_state->values['content_type'] : key($options_first);

    $form['path'] = array(
      '#type' => 'textfield',
      '#title' => t('Path to return to'),
      //'#required' => TRUE,
    );
    $form['content_type'] = array(
      '#type' => 'select',
      '#title' => t('Content Type'),
      '#options' => $options_first,
      //'#required' => TRUE,
      '#ajax' => array(
	      // When 'event' occurs, Drupal will perform an ajax request in the
	      // background. Usually the default value is sufficient (eg. change for
	      // select elements), but valid values include any jQuery event,
	      // most notably 'mousedown', 'blur', and 'submit'.
	      // 'event' => 'change',
	      'callback' => [$this,'ajax_example_dependent_dropdown_callback'],
	      'wrapper' => 'dropdown-second-replace',
    	),
    );

    $form['d_content_type'] = array (
      	'#type' => 'select',
      	'#title' => t('Dependent Content Options'),
      	// The entire enclosing div created here gets replaced when dropdown_first
    	// is changed.
    	'#prefix' => '<div id="dropdown-second-replace">',
    	'#suffix' => '</div>',
      	'#options' => $this->second_dropdown_options($selected),
    	'#default_value' => isset($form_state->values['d_content_type']) ? $form_state->values['d_content_type'] : '',
    );
    
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );

    return $form;
  }

   /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['cntform_name'] = $values['cntform_name'];
  }

   /**
   * {@inheritdoc}
   */
  public function first_dropdown_options() 
  {

	  // drupal_map_assoc() just makes an array('String' => 'String'...).
	  return array_combine(
		  	array('Content Types','Pages','Roles'),
		  	array('Content Types','Pages','Roles')
		);
	}	

	/**
   * {@inheritdoc}
   */
  public function second_dropdown_options($key = '')
  {
  	$options = array(
	    t('Content Types') => array_combine(array('Article','Basic Page'), 
	    									array('Article','Basic Page') 
	    									),
	    t('Pages') => array_combine(array('Show listed','Hide listed'), 													array('Show listed','Hide listed')
									),
	    t('Roles') => array_combine(array('Anonymous User','Authentic User','Administrator'), 							array('Anonymous User','Authentic User','Administrator')
									),
  	);

  	if (isset($options[$key])) 
  	{
    	return $options[$key];
  	}
  	else 
  	{
    	return array();
  	}	
  }

  	/**
   * {@inheritdoc}
   */
  	public function ajax_example_dependent_dropdown_callback($form, $form_state) {

  		return $form['d_content_type'];
	}	
}