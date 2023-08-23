/* globals jQuery */
jQuery(document).ready(function() {
      function adjustTabsPosition() {
            // Überprüfen Sie die Fensterbreite
            if (jQuery(window).width() > 800) {
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
                  var referenceHeight = referenceElement.height();

                  // Die gewünschte Position berechnen
                  var desiredPosition = referencePosition + referenceHeight + 20;

                  // Aktuelle Position von .wc-tabs-wrapper ermitteln
                  var tabsPosition = jQuery('.wc-tabs-wrapper').offset().top;

                  // Den benötigten Abstand berechnen
                  var offset = desiredPosition - tabsPosition;

                  jQuery('.wc-tabs-wrapper').css('margin-top', offset + 'px');
            }
            else {
                  // Setzen Sie den margin-top für mobile Ansichten zurück
                  jQuery('.wc-tabs-wrapper').css('margin-top', '0px');
            }
      }

      // Aufruf der Funktion beim Laden der Seite
      adjustTabsPosition();

      // Aufruf der Funktion, wenn die Fenstergröße geändert wird
      jQuery(window).resize(adjustTabsPosition);
});
