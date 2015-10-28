<?php $tag = ($view_mode != 'full')? 'div' : 'article'; ?>
<<?php print $tag; ?> id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
  <?php if ($view_mode == 'teaser') { ?>
  <?php /* ----------------- TEASER DISPLAY ----------------- */ ?>
  <?php // no teaser display, teasers are done through view fields ?>
  <?php } else if ($view_mode == 'full') { ?>
  <?php /* ----------------- FULL DISPLAY ----------------- */ ?>
  <?php if (isset($main_image)){ ?>
  <div class="main-image">
    <?php print $main_image; ?>
  </div>
  <?php } ?>
  <div class="content">
    <div class="main-content">
      <?php if (isset($breadcrumb)) { ?>
        <?php print $breadcrumb; ?>
      <?php } ?>
      <?php if (isset($title)){ ?>
        <header>
          <h1><?php print $title; ?></h1>
        </header>
      <?php } ?>
      <?php if (isset($node_body_html)){ ?>
        <div class="body">
          <?php print $node_body_html; ?>
        </div>
      <?php } ?>
    </div>
    <aside class="extra-content">
    </aside>
  </div>
  <?php } ?>
</<?php print $tag; ?>> <!-- /node-->