(function ($) {
    $(document).ready(function () {

        function resizeElement(element) {
            var height = 0;
            $(element).each(function () {
                var p = $(this).parent();
                if (height === 0) {
                    height = $(this).height();
                }
                p.css('height', height);
                p.css('overflow', 'hidden');
                p.css('display', 'block');
            });
        }

        function setCookie(cname, cvalue, exdays) {
            const now = new Date();
            const item = {
                value: cvalue,
                expiry: now.getTime() + (exdays * 24 * 60 * 60 * 1000),
            }

            localStorage.setItem(cname, JSON.stringify(item));
        }

        function getCookie(cname) {

            const itemStr = localStorage.getItem(cname);
            if (!itemStr) {
                return "";
            }

            const item = JSON.parse(itemStr);
            const now = new Date();
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(cname)
                return "";
            }

            return item.value;
        }

        $(".ce_xprojects_overview .item").each(function (index) {
            var self = $(this);
            $(this).find('div.textcontainer').hide();
            if ('ontouchstart' in document.documentElement) {
                //$(this).on('touchend', function () {
                $(this).on('click', function () {
                    var current = self.find('div.textcontainer');
                    $("div.textcontainer").each(function (index) {
                        if ($(this).attr('data-id') !== current.attr('data-id')) {
                            $(this).hide();
                        }
                    });
                    current.css('height', self.find('div.imagecontainer').first().height() + "px");
                    current.fadeToggle(150);
                });
            } else {
                $(this).hover(function () {
                    self.find('div.textcontainer').css('height', self.find('div.imagecontainer').first().height() + "px");
                    self.find('div.textcontainer').stop(true).fadeToggle(150);
                });
            }
        });

        var pTagCookie = getCookie('contao-projecttag');
        var tagURL = document.location.href;
        if (tagURL.indexOf('#') !== -1) {
            var tagFromURL = tagURL.substring(tagURL.indexOf('#') + 1);
            if (tagFromURL.startsWith("p_")) {
                pTagCookie = tagFromURL.substring(2, tagFromURL.length);
            }
        }

        if (pTagCookie !== '' && pTagCookie !== '-') {
            $(".ce_xprojects_overview .item").each(function () {
                var tagsItems = $(this).attr('data-tags');
                if (tagsItems.includes(pTagCookie) || pTagCookie === '-') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $(".ce_xprojects_overview .tagselector").each(function () {
                $(this).removeClass('active');
                if ($(this).attr('data-tag') === pTagCookie) {
                    $(this).addClass('active');
                }
            });
        }

        $(".ce_xprojects_overview .tagselector").each(function () {
            $(this).on('click', function () {
                $(".ce_xprojects_overview .tagselector").each(function () {
                    $(this).removeClass('active');
                });
                var current = $(this);
                current.addClass('active');
                var tag = current.attr('data-tag');
                setCookie('contao-projecttag', tag, 1);
                var url = document.location.href;
                if (url.indexOf('#') !== -1) {
                    url = url.substring(0, url.indexOf('#'));
                }
                if (tag !== '-') {
                    document.location = url + "#p_" + tag;
                } else {
                    document.location = url;
                }

                $(".ce_xprojects_overview .item").each(function () {
                    var tagsItems = $(this).attr('data-tags');
                    if (tagsItems.includes(tag) || tag === '-') {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        $('.ce_xprojects_overview .lazy').lazy({
            effect: "fadeIn",
            effectTime: 500,
            threshold: 0
        });

        resizeElement('.projectcontainer_contentitem li .image_container');
        $(window).resize(function () {
            resizeElement('.projectcontainer_contentitem li .image_container');
        });
    });
})(jQuery);

