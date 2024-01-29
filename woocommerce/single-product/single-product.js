/* globals jQuery */
jQuery(document).ready(function() {
      function adjustTabsPosition() {

            var referenceElement = jQuery('.flex-control-nav.flex-control-thumbs');
            if (referenceElement.length === 0) {
                  referenceElement = jQuery('.woocommerce-product-gallery__wrapper');
            }

            if (referenceElement.length === 0) {
                  // Wenn das Referenzelement nicht existiert, brechen Sie die Funktion ab.
                  return;
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

      function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                  var context = this,
                        args = arguments;
                  var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                  };
                  var callNow = immediate && !timeout;
                  clearTimeout(timeout);
                  timeout = setTimeout(later, wait);
                  if (callNow) func.apply(context, args);
            };
      }

      function adjustTabsPositionAfterDelay() {
            setTimeout(adjustTabsPosition, 100); // Verzögerung von 100ms
      }

      var adjustTabsPositionDebounced = debounce(adjustTabsPositionAfterDelay, 200);

      jQuery(window).on('resize', adjustTabsPositionDebounced);
      jQuery(window).on('load', adjustTabsPosition);
});
