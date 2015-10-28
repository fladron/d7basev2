<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function obt2_preprocess_maintenance_page(&$vars) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  obt2_preprocess_html($vars, $hook);
  obt2_preprocess_page($vars, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function obt2_preprocess_html(&$vars) {
  $vars['environment'] = variable_get('environment', 'dev');

  if ($vars['is_front']) {
    $vars['head_title'] = $vars['head_title_array']['name'];
  }

  // Attributes for html element.
  $vars['html_attributes_array'] = array(
    'lang' => $vars['language']->language,
    'dir' => $vars['language']->dir,
  );

  // Send X-UA-Compatible HTTP header to force IE to use the most recent
  // rendering engine or use Chrome's frame rendering engine if available.
  // This also prevents the IE compatibility mode button to appear when using
  // conditional classes on the html tag.
  if (is_null(drupal_get_http_header('X-UA-Compatible'))) {
    drupal_add_http_header('X-UA-Compatible', 'IE=edge,chrome=1');
  }

  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  if (!$vars['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    // Add unique class for each website section.
    list($section, ) = explode('/', $path, 2);
    $arg = explode('/', $_GET['q']);
    if ($arg[0] == 'node' && isset($arg[1])) {
      if ($arg[1] == 'add') {
        $section = 'node-add';
      }
      elseif (isset($arg[2]) && is_numeric($arg[1]) && ($arg[2] == 'edit' || $arg[2] == 'delete')) {
        $section = 'node-' . $arg[2];
      }
    }
    $vars['classes_array'][] = drupal_html_class('section-' . $section);
  }

  // external styles
  drupal_add_css('//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array('type' => 'external', 'group' => CSS_THEME));

  // external scripts
  drupal_add_js(libraries_get_path('modernizr'). '/modernizr.custom.87176.js');

  // Touch screen icons
  /*$icon =  array(
    '#tag' => 'link',
    '#attributes' => array(
      'href' => base_path() . path_to_theme() . '/touch-icon.png',
      'rel' => 'apple-touch-icon',
    ),
  );
  drupal_add_html_head($icon, 'meta_touch_icon');
  $icon_sizes = array(76, 120, 152);
  foreach($icon_sizes as $size){
    $icon = array(
      '#tag' => 'link',
      '#attributes' => array(
        'href' => base_path() . path_to_theme() . '/touch-icon-' . $size . 'x' . $size . '.png',
        'rel' => 'apple-touch-icon',
        'sizes' => $size . 'x' . $size,
      ),
    );
    drupal_add_html_head($icon, 'meta_touch_icon_' . $size);
  }*/

  // Page formats
  // if is body, print just the contents of the body, without anything else (to use in async calls that also need the wrapping)
  $vars['is_format_body'] = obt2_is_format('body');
  // if is oasync, print just the content, without anything else (pure data to use in async calls)
  $vars['is_format_ajax'] = obt2_is_format('oasync');
  // if is oasis, print just the content and also styles (<head>) and scripts (useful for an overlay showing just the content but with styles)
  $vars['is_format_oasis'] = obt2_is_format('oasis');
}

/**
 * Override or insert variables into the html templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function obt2_process_html(&$vars, $hook) {
  // Flatten out html_attributes.
  $vars['html_attributes'] = drupal_attributes($vars['html_attributes_array']);
}

function obt2_is_format($format){
  return (arg(0) == $format || (isset($_GET[$format]) && $_GET[$format] == '1'));
}

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function obt2_preprocess_page(&$vars) {
  // Error pages templating
  $header = drupal_get_http_header("status");
  if($header == "404 Not Found" || $header == "403 Forbidden" || $header == "500 Internal server error") {
     $vars['error']['info'] = t($header);
     $vars['classes_array'][] = 'error-page';
     $vars['theme_hook_suggestions'][] = 'page__error';
  }

  // Page formats
  $vars['is_format_ajax'] = obt2_is_format('oasync');
  $vars['is_format_oasis'] = obt2_is_format('oasis');

  // Adding classes if it has navigation
  if (!empty($vars['page']['navigation'])) {
    $vars['classes_array'][] = 'with-navigation';
  }

  // must show title
  $vars['must_show_title'] = FALSE;
  if (arg(0) == 'contact') {
    $vars['must_show_title'] = TRUE;
  }

  // taxonomy page
  if (arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2))) {
    // proper wrapping
    $vars['page']['content']['system_main']['nodes']['#prefix'] = '<div class="term-nodes">';
    $vars['page']['content']['system_main']['nodes']['#suffix'] = '</div>';
  }
}

/**
 * Override or insert variables into the region templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function obt2_preprocess_region(&$vars) {
  // Page formats
  $vars['is_format_ajax'] = obt2_is_format('oasync');
  $vars['is_format_oasis'] = obt2_is_format('oasis');

  // Use a template with no wrapper for this cases
  if ($vars['region'] == 'content') {
    array_unshift($vars['theme_hook_suggestions'], 'region__no_wrapper');
  }
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function obt2_preprocess_node(&$vars) {
  $node_obj = $vars['elements']['#node'];

  // Add view mode class (if not teaser, because it already has it)
  //if ($vars['view_mode'] != 'teaser') $vars['classes_array'][] = 'node-' . $vars['view_mode'];

  // entity title
  if ($vars['view_mode'] == 'full'){
    if (drupal_is_front_page()){
      unset($vars['title']);
    }else{
      $entity_title = field_get_items('node', $node_obj, 'title_field');
      if (isset($entity_title[0]['safe_value'])){
        $vars['title'] = $entity_title[0]['safe_value'];
      }
    }
  }

  // body and summary
  $body = field_get_items('node', $node_obj, 'body');
  if (isset($body[0]['safe_value'])){
    $vars['node_body_html'] = $body[0]['safe_value'];
    $summary = $body[0]['safe_value'];
    if (isset($body[0]['safe_summary']) && $body[0]['safe_summary'] != ''){
      $summary = $body[0]['safe_summary'];
    }
    $vars['node_body_summary_html'] = oh_truncate($summary, 160);
  }

  // other type specific fields
  switch ($vars['type']) {
    case 'page': /********** PAGE **********/
      if ($vars['view_mode'] == 'full') {
        /*$main_image = field_get_items('node', $node_obj, 'field_image');
        if (!empty($main_image)) {
          $vars['main_image'] = theme('image_style', array('path' => $main_image[0]['uri'], 'style_name' => 'detail_top'));
        }*/
      }
      break;
    case 'post':
      if ($vars['view_mode'] == 'full') {
        $vars['creation_date'] = oh_get_date_array($vars['created'], 'day', $is_timestamp = TRUE);
      }
      break;
  }
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
function obt2_preprocess_comment(&$vars) {
  /*$comment = $vars['elements']['#comment'];
  $vars['picture'] = theme('user_picture', array('account' => $comment));*/
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function obt2_preprocess_block(&$vars, $hook) {
  // is this a navigation block
  $vars['is_navigation'] = FALSE;
  if ($vars['block']->module == 'menu' || in_array($vars['block']->delta, array('main-menu'))){
    $vars['is_navigation'] = TRUE;
    $vars['attributes_array']['role'] = 'navigation';
  }

  // search block
  if ($vars['block']->module == 'views' && $vars['block']->delta == '-exp-search-page'){
    $vars['attributes_array']['role'] = 'search';
  }
  
  // Use a template with no wrapper for this cases
  if ($vars['block_html_id'] == 'block-system-main') {
    $vars['theme_hook_suggestions'][] = 'block__no_wrapper';
  }
}

/**
 * Process variables for search-result.tpl.php.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function obt2_preprocess_search_result(&$vars) {
  $node_obj = $vars['result']['node'];

}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function obt2_breadcrumb($vars) {
  $breadcrumb = $vars['breadcrumb'];  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('obt2_breadcrumb');
  if ($show_breadcrumb == 'yes' || ($show_breadcrumb == 'admin' && arg(0) == 'admin')) {
    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('obt2_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }
    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = '<span class="separator">' . theme_get_setting('obt2_breadcrumb_separator') . '</span>';
      $trailing_separator = $title = '';
      if (theme_get_setting('obt2_breadcrumb_title')) {
        $item = menu_get_item();
        if (!empty($item['tab_parent'])) {
          // If we are on a non-default tab, use the tab's title.
          $title = check_plain($item['title']);
        }
        else {
          $title = drupal_get_title();
        }
        if ($title) {
          $trailing_separator = $breadcrumb_separator;
        }
      }
      elseif (theme_get_setting('obt2_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }
      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users. Make the heading invisible with .element-invisible.
      $heading = '<h2 class="element-invisible sure">' . t('You are here') . '</h2>';
      return $heading . '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . $trailing_separator . $title . '</div>';
    }
  }
  // Otherwise, return an empty string.
  return '';
}

/**
 * Returns HTML for a marker for new or updated content.
 */
function obt2_mark($variables) {
  $type = $variables['type'];
  if ($type == MARK_NEW) {
    return ' <mark class="new">' . t('new') . '</mark>';
  }
  elseif ($type == MARK_UPDATED) {
    return ' <mark class="updated">' . t('updated') . '</mark>';
  }
}


/******************
 * TODO: the following is inherited exactly from the Zen theme: 
 *   should analyze and simplify this code 
 *****************/

/**
 * Returns HTML for primary and secondary local tasks.
 *
 * @ingroup themeable
 */
function obt2_menu_local_tasks(&$variables) {
  $output = '';

  // Add theme hook suggestions for tab type.
  foreach (array('primary', 'secondary') as $type) {
    if (!empty($variables[$type])) {
      foreach (array_keys($variables[$type]) as $key) {
        if (isset($variables[$type][$key]['#theme']) && ($variables[$type][$key]['#theme'] == 'menu_local_task' || is_array($variables[$type][$key]['#theme']) && in_array('menu_local_task', $variables[$type][$key]['#theme']))) {
          $variables[$type][$key]['#theme'] = array('menu_local_task__' . $type, 'menu_local_task');
        }
      }
    }
  }

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs-primary tabs primary">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs-secondary tabs secondary">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

/**
 * Returns HTML for a single local task link.
 *
 * @ingroup themeable
 */
function obt2_menu_local_task($variables) {
  $type = $class = FALSE;

  $link = $variables['element']['#link'];
  $link_text = $link['title'];

  // Check for tab type set in obt2_menu_local_tasks().
  if (is_array($variables['element']['#theme'])) {
    $type = in_array('menu_local_task__secondary', $variables['element']['#theme']) ? 'tabs-secondary' : 'tabs-primary';
  }

  // Add SMACSS-style class names.
  if ($type) {
    $link['localized_options']['attributes']['class'][] = $type . '-tab-link';
    $class = $type . '-tab';
  }

  if (!empty($variables['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = ' <span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));

    if (!$type) {
      $class = 'active';
    }
    else {
      $link['localized_options']['attributes']['class'][] = 'is-active';
      $class .= ' is-active';
    }
  }

  return '<li' . ($class ? ' class="' . $class . '"' : '') . '>' . l($link_text, $link['href'], $link['localized_options']) . "</li>\n";
}

/**
 * Implements hook_preprocess_menu_link().
 */
function obt2_preprocess_menu_link(&$variables, $hook) {
  foreach ($variables['element']['#attributes']['class'] as $key => $class) {
    switch ($class) {
      // Menu module classes.
      case 'expanded':
      case 'collapsed':
      case 'leaf':
      case 'active':
      // Menu block module classes.
      case 'active-trail':
        array_unshift($variables['element']['#attributes']['class'], 'is-' . $class);
        break;
      case 'has-children':
        array_unshift($variables['element']['#attributes']['class'], 'is-parent');
        break;
    }
  }
  array_unshift($variables['element']['#attributes']['class'], 'menu-item');
  if (empty($variables['element']['#localized_options']['attributes']['class'])) {
    $variables['element']['#localized_options']['attributes']['class'] = array();
  }
  else {
    foreach ($variables['element']['#localized_options']['attributes']['class'] as $key => $class) {
      switch ($class) {
        case 'active':
        case 'active-trail':
          array_unshift($variables['element']['#localized_options']['attributes']['class'], 'is-' . $class);
          break;
      }
    }
  }
  array_unshift($variables['element']['#localized_options']['attributes']['class'], 'menu-link');
}

/**
 * Returns HTML for status and/or error messages, grouped by type.
 */
function obt2_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"messages--$type messages $type\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul class=\"messages-list\">\n";
      foreach ($messages as $message) {
        $output .= '  <li class=\"messages-item\">' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  return $output;
}

