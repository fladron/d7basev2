drupal
======
All necessary files for a new Drupal 7 site

Version 2.1.0
SASS Based

For a non-SASS oriented version, look for Version 1.0 at fladron/drupal7-base-files
---
Some nice bare modules and a nice SASS boilerplate theme for a new Drupal 7 site, loosely based on the Zen theme. 

This theme has been carefully created after years of Drupal 7 experience.

The code is made following strictly SoC (Separation of Concerns) principles.

This theme uses npm (node package manager) to load dependencies and to run gulp, which in turn parses the SASS files into css.

Theme dependencies
------------------
- Node.js: https://nodejs.org/en/download/package-manager/
- Drush (recommended): http://docs.drush.org/en/master/install/

Theme installation
------------------
- Put the theme in /sites/all/themes/
- Activate it normally

Deployment
----------
- Go to the theme folder and install dependencies, just the first time:
  
  > npm install

- Each time you deploy, to process the sass files into css you must do:
  
  > npm run gulp

or you can 

  > npm run gulp watch

for continuous watching of sass files changes.

Drupal site general recommendations
===================================

Site Installation Checklist
---------------------------
**Through SSH:**
- Go to the desired folder (e.g. ../httpdocs/) and clone the last Drupal 7 repo:

>  git clone --branch 7.x https://git.drupal.org/project/drupal.git .

- Create a database. Enter in mysql console and:

> CREATE DATABASE `DB_NAME` CHARACTER SET utf8 COLLATE utf8_general_ci; GRANT ALL ON `DB_NAME`.* TO `DB_USER`@localhost IDENTIFIED BY 'DB_PASSWORD'; FLUSH PRIVILEGES;

and exit the mysql console
- Remove install.php from root (will configure database manually)
- In /sites/default/ create a file named secret.settings.php with this inside (This file should NEVER be committed to version control):
    
    ```php
    /**
     * Site environment
     * dev or pro or whatever environment you need
     */
    $conf['environment'] = 'dev';

    // Taken from: http://brockboland.com/drupaldork/2011/11/local-settings-development-sites
    // the database settings for this environment
    $databases = array (
      'default' => 
      array (
        'default' => 
        array (
          'database' => 'DB_NAME',
          'username' => 'DB_NAME',
          'password' => 'DB_PASSWORD',
          'host' => 'localhost',
          'port' => '',
          'driver' => 'mysql',
          'prefix' => '',
        ),
      ),
    );
    ```

- Copy /sites/default/default.settings.php as settings.php and add this at the end of this file (you can safely commit settings.php to version control):
    
    ```php
    /**
     * Secret settings file.
     */
    if (file_exists('./' . conf_path() . '/secret.settings.php')) {
      require './' . conf_path() . '/secret.settings.php';
    }
    ```

- Make settings.php and secret.settings.php non writable
- Install using drush (or manually through ssh wget or sFTP) the recommended modules (list below)
- Activate the Core-ish modules and the necessary Optional modules
- Deactivate the unnecessary modules, including: overlay, toolbar
- If site is multilanguage:
    - Install the Multilanguage modules
    - Go to each core content type and activate multilanguage features (The same must be done for every new content type): 
        - in Edit, check "Enabled, with field translation"
        - in Manage fields, replace the title field, and edit all the translatable fields and Enable translation for them
    - Title settings: check all Automatic field replacement in /admin/config/content/title
    - Add all necessary languages in /admin/config/regional/language
    - Activate URL methods for both detection groups in /admin/config/regional/language/configure
    - In /admin/config/regional/entity_translation, activate Node and Taxonomy term as Translatable entity types
    - Still in this form, for each entity and content type:
        - default language is Default language
        - Uncheck Hide language selector
        - Check Exclude Language neutral from the available languages
        - Check Prevent language from being changed once the entity has been created
        - Check Hide shared elements on translation forms
    - Set the source language in /admin/config/regional/i18n/strings ('english' recommended)
- Create a Home basic page, and point to it in the Configuration > Site information (node/1)
- In /admin/structure/block put Main menu in Navigation Bar, put Language switcher (User interface text) in the Header and deactivate the unneeded blocks
- In /admin/structure/menu/manage/main-menu 

Recommended Modules
-------------------
Use drush for the following modules list to upload and enable them, like this (if MODULE_NAME_LIST has more than one module, separate them with spaces)

  > drush en -y MODULE_NAME_LIST

**Be careful with libraries and server modules dependencies:**

Core-ish MODULE_NAME_LIST:

  > admin_menu admin_views adminimal_admin_menu adminimal_theme ckeditor ctools date devel entity entityconnect entityreference field_group honeypot imagecache_token imce jquery_update libraries link metatag module_filter nodequeue pathauto token transliteration variable views views_bulk_operations xmlsitemap

Multilanguage modules:

  > entity_translation i18n l10n_update title

Optional modules:
- epsacrop
- smtp OR elastic_email mailsystem
- media media_browser_plus media_vimeo media_youtube
- file_entity
- search_api search_api_autocomplete search_api_db facetapi
- better_exposed_filters
- site_map
- webform webform_localization
- flag
- cdn
- addressfield geocoder geofield geophp
- leaflet leaflet_more_maps leaflet_widget + leaflet libraries
- views_datasource
- role_delegation
- views_tree
- memcache entitycache
- imagemagick

Security recommendations
------------------------
- Go to /admin/config/media/file-system and in the field "Temporary directory" put

  > sites/default/files/tmp
