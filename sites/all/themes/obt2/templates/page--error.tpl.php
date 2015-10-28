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

  <div id="main">
    <div class="inner">
      <div id="content" class="column" role="main">
        <a id="main-content"></a>

        <?php if (isset($error)): ?>
          <h1 class="page__title title" id="page-title"><?php print $error['info']; ?></h1>
          <p><?php print render($page['content']); ?></p>
          <a href="<?php print $front_page; ?>"><?php print t("Go back to frontpage"); ?></a>
        <?php endif; ?>
      </div>

    </div>
  </div>

</div>

<?php print render($page['bottom']); ?>
