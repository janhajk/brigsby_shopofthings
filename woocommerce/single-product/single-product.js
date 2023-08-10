/* globals $ */
$(document).ready(function() {
      function adjustTabsPosition() {
            // Überprüfen Sie die Fensterbreite
            if ($(window).width() > 800) {
                  // Basiswert für die negative Verschiebung
                  var baseOffset = -250;

                  // Höhe von .entry-summary ermitteln
                  var summaryHeight = $('.entry-summary').height();

                  if (summaryHeight > 1000) {
                        // Berechnen Sie den zusätzlichen negativen Abstand, basierend auf wie viel größer die Höhe ist als 1000px
                        var extraOffset = summaryHeight - 1000;
                        $('.wc-tabs-wrapper').css('margin-top', (baseOffset - extraOffset) + 'px');
                  }
                  else {
                        $('.wc-tabs-wrapper').css('margin-top', baseOffset + 'px');
                  }
            }
            else {
                  // Setzen Sie den margin-top für mobile Ansichten zurück
                  $('.wc-tabs-wrapper').css('margin-top', '0px');
            }
      }

      // Aufruf der Funktion beim Laden der Seite
      adjustTabsPosition();

      // Aufruf der Funktion, wenn die Fenstergröße geändert wird
      $(window).resize(adjustTabsPosition);
});
