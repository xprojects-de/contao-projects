
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
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      var expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
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
      effectTime: 800,
      threshold: 0
    });
    resizeElement('.projectcontainer_contentitem li .image_container');
    $(window).resize(function () {
      resizeElement('.projectcontainer_contentitem li .image_container');
    });
  });
})(jQuery);

