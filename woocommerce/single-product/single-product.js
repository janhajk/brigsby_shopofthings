/* globals jQuery */
jQuery(document).ready(function() {
      function adjustTabsPosition() {
            var referenceElement;

            // Überprüfen, ob .flex-control-nav.flex-control-thumbs existiert
            if (jQuery('.flex-control-nav.flex-control-thumbs').length) {
                  referenceElement = jQuery('.flex-control-nav.flex-control-thumbs');
            }
            else {
                  // Wenn nicht, verwenden Sie .woocommerce-product-gallery__wrapper als Referenz
                  referenceElement = jQuery('.woocommerce-product-gallery__wrapper');
            }

            // Position und Höhe des Referenzelements ermitteln
            var referencePosition = referenceElement.offset().top;
            var referenceHeight = referenceElement.outerHeight(true); // outerHeight(true) berücksichtigt auch margin

            // Die gewünschte Position berechnen
            var desiredPosition = referencePosition + referenceHeight + 20;

            // Aktuelle Position von .wc-tabs-wrapper ermitteln
            var tabsPosition = jQuery('.wc-tabs-wrapper').offset().top;

            // Den benötigten Abstand berechnen
            var offset = desiredPosition - tabsPosition;

            jQuery('.wc-tabs-wrapper').css('margin-top', offset + 'px');
      }

      var resizeTimeout;
      jQuery(window).on('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(adjustTabsPosition, 200); // Verzögerung von 200ms
      });

      // Aufruf der Funktion beim Laden der Seite
      adjustTabsPosition();
});
