document.addEventListener('DOMContentLoaded', function() {

      let container = document.createElement('span');
      let b2b = document.createElement('a');
      let b2c = document.createElement('a');


      let getCookie = function(cname) {
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
      };


      //, .woocommerce - price - suffix
      let pricesExclMwst = function() {
            jQuery('.woocommerce-Price-amount bdi').each((i, el) => {
                  el = jQuery(el);
                  let currency = el.children().first();
                  let price = el.text();
                  price = price.replace('CHF', '');
                  price = parseFloat(price) / 1.077;
                  price = Math.round(price, 2);
                  el.empty();
                  el.append(currency);
                  el.append(price);
            });
            jQuery('.woocommerce-price-suffix').each((i, el) => {
                  jQuery(el).replaceWith('<b>exkl.</b> MWST');
            });
      };


      // read cookie
      let is_b2b = getCookie('_is_b2b');

      // if cookie does not exist, create it
      if (is_b2b === '') {
            document.cookie = '_is_b2b=false';
      }

      // change all prices to excl. MWST
      if (is_b2b === 'true') {
            pricesExclMwst();
      }


      b2b.innerHTML = 'B2B';
      b2c.innerHTML = 'B2C';
      b2b.className = 'button';
      b2c.className = 'button';
      container.appendChild(b2b);
      container.appendChild(b2c);

      let section = document.getElementById('search-2');
      section.appendChild(container);

      b2b.addEventListener('click', () => {
            document.cookie = '_is_b2b=true';
      });
      b2c.addEventListener('click', () => {
            document.cookie = '_is_b2b=false';
      });

});
