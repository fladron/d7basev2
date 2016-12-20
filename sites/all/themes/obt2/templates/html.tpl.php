<?php if (!$is_format_ajax && !$is_format_body) { ?>
    <!doctype html>
    <!--[if IEMobile 7]>
    <html class="no-js iem7"<?php print $html_attributes; ?>><![endif]-->
    <!--[if lte IE 6]>
    <html class="no-js lt-ie9 lt-ie8 lt-ie7"<?php print $html_attributes; ?>><![endif]-->
    <!--[if (IE 7)&(!IEMobile)]>
    <html class="no-js lt-ie9 lt-ie8"<?php print $html_attributes; ?>><![endif]-->
    <!--[if IE 8]>
    <html class="no-js lt-ie9"<?php print $html_attributes; ?>><![endif]-->
    <!--[if (gte IE 9)|(gt IEMobile 7)]><!-->
    <html class="no-js"<?php print $html_attributes . $rdf_namespaces; ?>><!--<![endif]-->

    <head>
        <?php print $head; ?>
        <title><?php print $head_title; ?></title>

        <meta name="MobileOptimized" content="width">
        <meta name="HandheldFriendly" content="true">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="cleartype" content="on">

        <?php print $styles; ?>
        <!--[if lt IE 9]>
        <script src="<?php print base_path() . path_to_theme(); ?>/js/dist/html5shiv.min.js"></script>
        <![endif]-->

        <?php if (isset($environment) && $environment == 'pro') { ?>
            <?php // Insert here the Google Analytics code ?>

        <?php } ?>
    </head>
    <body class="<?php print $classes; ?>" <?php print $attributes; ?>>
    <?php if (!$is_format_oasis) { ?>

        <p id="skip-link">
            <a href="#main" class="element-invisible element-focusable"><?php print t("Skip to content") ?></a>
        </p>
        <?php print $page_top; ?>
        <?php print $page; ?>

    <?php } else { ?>
        <?php print $page; ?>
    <?php } ?>

    <?php print $scripts; ?>
    <?php print $page_bottom; ?>
    </body>
    </html>
<?php } else { ?>
    <?php print $page; ?>
<?php }