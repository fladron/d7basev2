<?php if (!$is_format_ajax && !$is_format_oasis){ ?>
<div id="page" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <header class="header" id="header" role="banner">
    <div class="inner">
      <?php if ($logo){ ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
      <?php } ?>

      <?php if ($site_name || $site_slogan){ ?>
      <div class="name-and-slogan">
        <?php if ($site_name){ ?>
        <h1 class="site-name">
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">
            <span><?php print $site_name; ?></span>
          </a>
        </h1>
        <?php } ?>

        <?php if ($site_slogan){ ?>
        <div class="site-slogan"><?php print $site_slogan; ?></div>
        <?php } ?>
      </div>
      <?php } ?>

      <?php print render($page['header']); ?>
    </div>
  </header>

  <div id="main" role="main">
    <div class="inner">

      <?php // Move this navigation region where appropiate ?>
      <?php if (!empty($page['navigation'])){ ?>
      <div id="navigation">
        <?php print render($page['navigation']); ?>
      </div>
      <?php } ?>
      <?php // -------------------------------------------- ?>

      <div id="content" class="column" role="main">
        <?php if (!empty($page['highlighted'])){ ?>
        <?php print render($page['highlighted']); ?>
        <?php } ?>
        <?php print $breadcrumb; ?> 
        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if ($title && $must_show_title){ ?>
        <h1 class="page-title title" id="page-title"><?php print $title; ?></h1>
        <?php } ?>
        <?php print render($title_suffix); ?>
        <?php print $messages; ?>
        <?php print render($tabs); ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links){ ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php } ?>
        <?php print render($page['content']); ?>
        <?php print $feed_icons; ?>
      </div>
    </div>
  </div>

  <footer id="footer" role="contentinfo">
    <div class="inner">
      <?php if (!empty($page['footer'])){ ?>
      <?php print render($page['footer']); ?>
      <?php } ?>

      <?php if (!empty($page['footer_bottom'])){ ?>
      <?php print render($page['footer_bottom']); ?>
      <?php } ?>
    </div>
  </footer>

</div>

<?php print render($page['bottom']); ?>

<?php }else{ ?>
  <?php print render($page['content']) ?>
<?php }
