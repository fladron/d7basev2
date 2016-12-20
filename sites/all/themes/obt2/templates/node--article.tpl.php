<?php $tag = ($view_mode != 'full')? 'div' : 'article'; ?>
<<?php print $tag; ?> id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
  <?php if ($view_mode == 'teaser') { ?>
  <?php /* ----------------- TEASER DISPLAY ----------------- */ ?>
  <?php // no teaser display, teasers are done through view fields ?>
  <?php } else if ($view_mode == 'full') { ?>
  <?php /* ----------------- FULL DISPLAY ----------------- */ ?>
    <?php if (isset($breadcrumb)) { ?>
      <?php print $breadcrumb; ?>
    <?php } ?>
    <?php if (isset($title)){ ?>
    <header>
      <h1><?php print $title; ?></h1>
      <?php 
      /**
       * A more customized way to render a field (the creation date), with some control done through template.php's obt_preprocess_node function (look for $vars['creation_date'])
       */ ?>
      <time datetime="<?php print $creation_date; ?>"><?php print $creation_date; ?></time>
    </header>
    <?php } ?>
    <div class="content">
      <?php 
      /**
       * The simplest way to render a field (body and tags), related to the Content type's Manage display form
       */ ?>
      <?php print render($content['body']); ?>
      <?php print render($content['field_tags']); ?>
    </div>
  <?php } ?>
</<?php print $tag; ?>> <!-- /node-->