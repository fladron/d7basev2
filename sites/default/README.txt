Add this in settings.php

/**
 * Secret settings file for local development only.
 *
 * This file should NEVER be committed to version control and should never exist
 * on a non-local development machine.
 */
if (file_exists('./' . conf_path() . '/secret.settings.php')) {
  require './' . conf_path() . '/secret.settings.php';
}