(function($) {
  'use strict';
  $(function() {

      // ✅ Minimize toggle (desktop view)
      $('[data-toggle="minimize"]').on("click", function () {
        $('body').toggleClass('sidebar-icon-only');
      });    

    $('[data-toggle="offcanvas"]').on("click", function() {
      $('.sidebar-offcanvas').toggleClass('active')
    });
  });
})(jQuery);