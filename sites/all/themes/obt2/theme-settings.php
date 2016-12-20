<?php
/**
 * Implements hook_form_system_theme_settings_alter() function.
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function obt_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  // Create the form using Forms API
  $form['breadcrumb'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Breadcrumb settings'),
  );
  $form['breadcrumb']['obt_breadcrumb'] = array(
    '#type'          => 'select',
    '#title'         => t('Display breadcrumb'),
    '#default_value' => theme_get_setting('obt_breadcrumb'),
    '#options'       => array(
                          'yes'   => t('Yes'),
                          'admin' => t('Only in admin section'),
                          'no'    => t('No'),
                        ),
  );
  $form['breadcrumb']['breadcrumb_options'] = array(
    '#type' => 'container',
    '#states' => array(
      'invisible' => array(
        ':input[name="obt_breadcrumb"]' => array('value' => 'no'),
      ),
    ),
  );
  $form['breadcrumb']['breadcrumb_options']['obt_breadcrumb_separator'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Breadcrumb separator'),
    '#description'   => t('Text only. Don’t forget to include spaces.'),
    '#default_value' => theme_get_setting('obt_breadcrumb_separator'),
    '#size'          => 5,
    '#maxlength'     => 10,
  );
  $form['breadcrumb']['breadcrumb_options']['obt_breadcrumb_home'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show home page link in breadcrumb'),
    '#default_value' => theme_get_setting('obt_breadcrumb_home'),
  );
  $form['breadcrumb']['breadcrumb_options']['obt_breadcrumb_trailing'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append a separator to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('obt_breadcrumb_trailing'),
    '#description'   => t('Useful when the breadcrumb is placed just before the title.'),
    '#states' => array(
      'disabled' => array(
        ':input[name="obt_breadcrumb_title"]' => array('checked' => TRUE),
      ),
    ),
  );
  $form['breadcrumb']['breadcrumb_options']['obt_breadcrumb_title'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append the content title to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('obt_breadcrumb_title'),
    '#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
  );
}
