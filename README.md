drupal
======
All necessary files for a new Drupal site

Version 2.0
SASS Based

For a non-SASS oriented version, look for Version 1.0 at fladron/drupal7-base-files

Recommended Modules
-------------------
Use drush for the following modules list to upload and enable them, like this (if MODULE_NAME_LIST has more than one module, separate them with spaces)

  > drush en -y MODULE_NAME_LIST

Core-ish MODULE_NAME_LIST:

  > admin_menu admin_views adminimal_admin_menu adminimal_theme chosen ckeditor ctools date entity entity_translation entityconnect entityreference epsacrop field_group honeypot i18n imce jquery_update l10n_update libraries link  module_filter nodequeue pathauto title token transliteration variable views views_bulk_operations webform_localization

Core-ish LIBRARIES:

  > Jcrop
  > json2
  > chosen

Optional modules:
- devel
- media media_browser_plus media_vimeo media_youtube
- file_entity
- search_api search_api_autocomplete search_api_db facetapi
- better_exposed_filters
- site_map
- xmlsitemap
- metatag
- webform
- mandrill mailsystem + mandrill library
- flag
- cdn
- addressfield geocoder geofield geophp
- leaflet leaflet_more_maps leaflet_widget + leaflet libraries
- views_datasource
- role_delegation
- views_tree

Security recommendations
------------------------
- Go to /admin/config/media/file-system and in the field "Temporary directory" put

  > sites/default/files/tmp
  