// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f() {
    log.history = log.history || [];
    log.history.push(arguments);
    if (this.console) {
        var args = arguments, newarr;
        args.callee = args.callee.caller;
        newarr = [].slice.call(args);
        if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);
    }
};

// make it safe to use console.log always
(function (a) {
    function b() {}
    for (var c = "assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","), d; !!(d = c.pop());) {
        a[d] = a[d] || b;
    }
})
(function () {
    try {
        console.log();
        return window.console;
    } catch (a) {
        return (window.console = {});
    }
}());

/**
 * Helper methods
 * @Author: Omitsis SL
 * @Author URI: http://www.omitsis.com
 *
 **/
// get number with 'size' leading zeros
function pad(num, size) {
    var s = num + '';
    while (s.length < size) s = '0' + s;
    return s;
}

//strips pixels from measure
function stripMagnitude(measure) {
    var index = measure.indexOf('px');
    if (index != -1) return parseInt(measure.substring(0, index));
    return -1;
}

// get a value from an url get parameter
function getURLParameter(name, url) {
    //location.search
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(url) || [, null])[1]
    );
}

// cookies management
function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}
function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
    return "";
}

// easy debounce function
function debounce(fn, delay) {
    var timer = null;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            fn.apply(context, args);
        }, delay);
    };
}

(function ($) {
    /**
     * Group some content into a Tabbed group
     * @params
     *   Object options: options for the instance
     * @return void
     * @Author: Omitsis SL
     * @Author URI: http://www.omitsis.com
     *
     **/
    GrouppedTabs = function (options) {
        this.selector = options.selector;
        this.$panes = null;
        this.block_name = options.block_name;
        this.active_tab = options.active_tab || 0;
        this.$pane_items = $(this.selector);
        this.$global_pane = this.$pane_items.closest('.async-container');
        this.events = {};
        this.$nav_list = null;

        var self = this;

        this.init = function (events) {
            this.events = events;
            if (this.$pane_items.length) {
                this.prepareTabs();
                this.prepareNavigation();
                try {
                    this.events.on_start();
                } catch (err) {
                }
            }
        };

        this.prepareTabs = function () {
            this.$pane_items.wrapAll('<div id="' + this.block_name + '" class="block tabs"><div class="tab-panes"></div></div>');
            this.$panes = this.$pane_items.parent();
            this.$panes.parent().prepend('<div class="tab-nav"><ul></ul></div>');
            this.$nav_list = this.$panes.parent().find('.tab-nav ul');
            this.$pane_items.each(function (i) {
                var this_pane = $(this);
                var id = this_pane.attr('data-id');
                if (id == undefined) id = 'tab-' + (i + 1);
                this_pane.removeAttr('class');
                var title = this_pane.find('> header');
                title.hide();
                self.$nav_list.append('<li data-tab-id="' + id + '"><a href="#">' + title.text() + '</a></li>');
                if (i != self.active_tab) this_pane.hide();
            });
        };

        this.prepareNavigation = function () {
            this.$nav_list.find('> li').each(function (j) {
                var this_nav_item = $(this);
                if (j == self.active_tab) this_nav_item.addClass('active');
                this_nav_item.find('> a').click(function () {
                    if (self.$global_pane.length) self.$global_pane.attr('data-selected-tab', j);
                    self.$nav_list.attr('data-tab', (j + 1));
                    self.$nav_list.find('> li').each(function (k) {
                        if (j == k) {
                            $(this).addClass('active');
                        } else {
                            $(this).removeClass('active');
                        }
                    });
                    self.$pane_items.each(function (k) {
                        if (j == k) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                    return false;
                });
            });
        };

        // initiate!
        this.init();
    };

    /**
     * Create a basic carroussel
     * @params
     *   Object options: options for the instance
     * @return void
     * @Author: felip @ omitsis
     * @Author URI: http://www.omitsis.com
     *
     **/
    BasicCarroussel = function (options) {
        this.selector = options.selector;
        this.$obj = $(this.selector);
        this.$items = this.$obj.find('.views-row');
        this.$nav_list;
        this.current_slide = 0;
        this.fade_time = 300; // miliseconds
        this.auto_play = options.auto_play || true;
        this.change_slide_time = options.change_slide_time || 4000; // miliseconds
        this.timer = -1;

        var self = this;

        this.init = function () {
            if (self.$obj.length) {
                self.$obj.attr('data-js', 'true');
                self.$obj.append('<div class="nav-list"><ul /></div>');
                self.$nav_list = self.$obj.find('.nav-list > ul');
                self.prepareNavList();
                self.prepareInteraction();
                self.prepareMotion();
            }
        };
        this.prepareNavList = function () {
            self.$items.each(function (i) {
                var $item = $(this).find('.image-and-content');
                var url = $item.attr('href');
                var title = $item.find('> .content h2').text();
                self.$nav_list.append('<li data-index="' + i + '"><h2><a href="' + url + '">' + title + '</a></h2></li>');
            });
        };
        this.prepareInteraction = function () {
            self.$nav_list.find('li').mouseover(function (e) {
                self.pauseMotion();
                var index = $(this).attr('data-index');
                self.selectItem(index);
            });

            self.selectItem(self.current_slide);
        };
        this.selectItem = function (index) {
            self.$items.each(function (i) {
                var nav_item = self.$nav_list.find('> li').eq(i);
                if (i != index) {
                    $(this).attr('data-current', 'false');
                    nav_item.attr('data-current', 'false');
                    $(this).fadeOut(self.fade_time);
                } else {
                    $(this).attr('data-current', 'true');
                    nav_item.attr('data-current', 'true');
                    $(this).fadeIn(self.fade_time);
                }
            });

            self.current_slide = index;
        };
        this.prepareMotion = function () {
            self.timer = setInterval(self.nextSlide, self.change_slide_time);
        };
        this.nextSlide = function (e) {
            var future_slide = self.current_slide + 1;
            if (future_slide >= self.$items.length) future_slide = 0;
            self.selectItem(future_slide);
        };
        this.pauseMotion = function () {
            if (self.timer != -1) clearInterval(self.timer);
        };

        // initiate!
        this.init();
    };

    /**
     * Creates a simple collapsible item
     * @params
     *   Object options: options for the instance
     *     - jQuery obj: jquery instance to be made collapsible, mandatory
     *     - String btnSelector: selector of the button that makes the collapse action, mandatory
     *     - String collapsibleSelector: selector of the element that collapses/uncollapses, mandatory
     *     - Boolean startFolded: true if starts folded, or false otherwise
     *     - Integer speed: the speed in miliseconds the folding animation lasts
     * @return void
     * @Author: felip @ Omitsis SL
     * @Author URI: http://www.omitsis.com
     *
     **/
    SimpleCollapsible = function (options) {
        this.$obj = options.obj;
        this.$btn = this.$obj.find(options.btnSelector);
        this.$collapsible = this.$obj.find(options.collapsibleSelector);
        this.collapsed = (options.startFolded !== 'undefined') ? options.startFolded : false;
        this.anim_speed = (options.speed !== 'undefined') ? options.speed : 300;

        var self = this;

        this.init = function () {
            self.$obj.addClass('simple-collapsible');
            self.$btn.addClass('simple-collapsible-btn');
            self.$collapsible.addClass('simple-collapsible-inner');
            self.$obj.attr('data-status', 'open');
            if (self.collapsed) self.collapse();
            self.prepareInteraction();
            return self.$obj;
        };

        this.prepareInteraction = function () {
            self.$btn.click(function (e) {
                e.preventDefault();
                self.toggleCollapse();
            });
        };

        this.toggleCollapse = function () {
            if (self.collapsed) {
                self.uncollapse();
            } else {
                self.collapse();
            }
        };

        this.collapse = function () {
            self.collapsed = true;
            self.$obj.attr('data-status', 'closed');
            self.$collapsible.slideUp(self.anim_speed);
        };

        this.uncollapse = function () {
            self.collapsed = false;
            self.$obj.attr('data-status', 'open');
            self.$collapsible.slideDown(self.anim_speed);
        };

        // initiate!
        this.init();
    };

})(jQuery);