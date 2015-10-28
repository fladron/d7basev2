<?php
/**
 * Site environment
 * dev, pre or pro
 */
$conf['environment'] = 'dev';

// the database settings for this environment
$databases = array (
  'default' => 
  array (
    'default' => 
    array (
      'database' => 'nouu2015',
      'username' => 'nouu2015u',
      'password' => 'R9yNPi4e6oPo',
      'host' => 'localhost',
      'port' => '',
      'driver' => 'mysql',
      'prefix' => '',
    ),
  ),
);

// Taken from: http://brockboland.com/drupaldork/2011/11/local-settings-development-sites

// Make sure I can always run update.php
$update_free_access = FALSE;

// Some sites use memcache, which overrides the cache include file from the core
// Since I don't have memcache running on my machine, I override it back to the
// default, and test caching on the staging server
$conf['cache_inc'] = './includes/cache.inc';

// error reporting
error_reporting(1);
$conf['error_level'] = 2;
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);