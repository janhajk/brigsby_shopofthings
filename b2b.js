document.addEventListener('DOMContentLoaded', function() {

      let container = document.createElement('span');
      let b2b = document.createElement('a');
      let b2c = document.createElement('a');

      container.style.float = 'right';
      container.style.marginRight = '5px';


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

      let setCookie = function(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      };


      //, .woocommerce - price - suffix
      let pricesExclMwst = function() {
            if (window.location.pathname === '/cart/') return;
            jQuery('.woocommerce-Price-amount bdi').each((i, el) => {
                  el = jQuery(el);
                  let currency = el.children().first();
                  let price = el.text();
                  price = price.replace('CHF', '');
                  price = price.replace('\'', '');
                  price = parseFloat(price) / 1.077;
                  price = (price.toFixed(2)).toLocaleString('de-CH', { minimumFractionDigits: 2 });
                  el.empty();
                  el.append(currency);
                  el.append(price);
            });
            jQuery('.woocommerce-price-suffix').each((i, el) => {
                  jQuery(el).replaceWith('exkl. MWST');
            });
      };



      let switchButtons = function(is_b2b) {
            let active = b2b;
            let passive = b2c;
            if (!is_b2b) {
                  active = b2c;
                  passive = b2b;
            }
            active.style.backgroundColor = '#004a7f';
            active.style.color = '#fff';
            passive.style.backgroundColor = '#ebe9eb';
            passive.style.color = '#515151';
      };


      // read cookie
      let is_b2b = getCookie('_is_b2b');

      // if cookie does not exist, create it
      if (is_b2b == '') {
            is_b2b = true;
            setCookie('_is_b2b', true, 3650);
      }

      // change all prices to excl. MWST
      if (is_b2b == 'true' || is_b2b === true) {
            is_b2b = true;
            pricesExclMwst();
      }
      else {
            is_b2b = false;
      }



      b2b.innerHTML = 'B2B';
      b2c.innerHTML = 'B2C';
      b2b.className = 'button';
      b2c.className = 'button';
      b2b.title = 'Geschäftskundenpreise (exkl. MWST)';
      b2c.title = 'Privatkundenpreise (inkl. MWST)';
      switchButtons(is_b2b);
      container.appendChild(b2b);
      container.appendChild(b2c);

      let section = document.getElementById('search-2');
      section.appendChild(container);

      b2b.addEventListener('click', () => {
            if (getCookie('_is_b2b') == 'false') {
                  setCookie('_is_b2b', true, 3650);
                  pricesExclMwst();
                  switchButtons(true);
            }
      });
      b2c.addEventListener('click', () => {
            setCookie('_is_b2b', false, 3650);
            window.location.reload(true);
      });

});
