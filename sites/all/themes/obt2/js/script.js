var config = {
    LANGUAGE: 'en'
};

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

    // ON READY
    $(window).ready(function () {
        // this always on top
        config.LANGUAGE = $('html').attr('lang');
        //-------------------

        // For all links with rel external, open link in new tab
        $('body').on('click', 'a[rel="external"]', function (e) {
            e.preventDefault();
            window.open($(this).attr('href'));
        });

        // main menu
        var $main_menu = $('#block-system-main-menu');
        if ($main_menu.length) {
            // responsive menu
            $('#page').before('<div class="mobile-menu"><button data-action="open-mobile-menu">Menu</button></div>');
            var $mobile_menu = $('.mobile-menu');
            $mobile_menu.append($main_menu.find('> .content').html());
            $('button[data-action="open-mobile-menu"]').click(function (e) {
                $mobile_menu.toggleClass('opened');
            });
        }

        // basic custom carroussel
        /*var carroussel = new BasicCarroussel(
         {
         selector: '.some-selector',
         auto_play: true,
         change_slide_time: 4000
         }
         );*/

        // tabs
        /*var most_tabs = new GrouppedTabs(
         {
         selector: '.some-selector',
         block_name: 'id-name-for-the-block'
         }
         );*/

        // collapsible containers
        /*$('.some-collapsible-containers').each(function(i){
         var collapsible = new SimpleCollapsible(
         {
         obj: $(this),
         btnSelector: '> legend',
         collapsibleSelector: '> .fieldset-wrapper',
         startFolded: true
         }
         );
         });*/
    });

})(jQuery, Drupal, this, this.document);
