<?php $tag = ($view_mode != 'full') ? 'div' : 'article'; ?>
<<?php print $tag; ?> id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
<?php if ($view_mode == 'teaser') { ?>
    <?php /* ----------------- TEASER DISPLAY ----------------- */ ?>
    <?php // no teaser display, teasers are done through view fields ?>
<?php } else if ($view_mode == 'full') { ?>
    <?php /* ----------------- FULL DISPLAY ----------------- */ ?>
    <?php if (isset($breadcrumb)) { ?>
        <?php print $breadcrumb; ?>
    <?php } ?>
    <?php if (isset($title)) { ?>
        <header>
            <h1><?php print $title; ?></h1>
        </header>
    <?php } ?>
    <div class="content">
        <?php /*
          * A simple render of a field (the body field), no control whatsoever, as it is configured in the content type's Manage display tab.
          * If some control is needed, it must be done through template.php's obt_preprocess_node function
          */ ?>
        <?php print render($content['body']); ?>
    </div>
<?php } ?>
</<?php print $tag; ?>> <!-- /node-->