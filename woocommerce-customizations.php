<?php

/**
 *
 *
 * format content on single product page before price (sku, herstellernummer, categories)
 *
 *
 *
 *
 */
 function skuToSpelling($sku) {
    if (!isSKU($sku)) {
        return 'Ungültige SKU';
    }

    $mapping = array(
        '3' => 'three',
        '4' => 'four',
        '7' => 'seven',
        'A' => 'alpha',
        'E' => 'echo',
        'H' => 'hotel',
        'J' => 'juliet',
        'L' => 'lima',
        'N' => 'november',
        'Q' => 'quebec',
        'R' => 'romeo',
        'T' => 'tango',
        'U' => 'uniform',
        'Y' => 'yankee'
    );

    $characters = str_split($sku);
    $spelledOutSKU = array();

    foreach($characters as $character) {
        if(isset($mapping[$character])) {
            $spelledOutSKU[] = $mapping[$character];
        }
    }

    return implode(' / ', $spelledOutSKU);
}

function isSKU($sku) {
    // Regulärer Ausdruck, der überprüft:
    // ^ - Start des Strings
    // [347AEHJLNQRTUY] - nur die genannten Zeichen sind erlaubt
    // {4} - genau vier Zeichen lang
    // $ - Ende des Strings
    $pattern = '/^[347AEHJLNQRTUY]{4}$/';

    return preg_match($pattern, $sku);
}


 /**
  *
  * Move  Meta data (categorie, sku) to top of single-product page
  *
  *
  *
  *
  */
function sot_show_product_meta_custom() {
    global $product;

    // JavaScript zum Kopieren von Text in die Zwischenablage
    $copyToClipboardJS = "
                  <script>
                  function copyToClipboard(element) {
                      var text = element.innerText;
                      var textarea = document.createElement('textarea');
                      textarea.value = text;
                      document.body.appendChild(textarea);
                      textarea.select();
                      document.execCommand('copy');
                      document.body.removeChild(textarea);
                      alert('SKU kopiert: ' + text);
                  }
                  </script>
                      ";
    echo $copyToClipboardJS; // Das JS-Script einfügen

    // SKU Anzeige
    $sku = $product->get_sku();
    if ($sku) {
        if (isSKU($sku)) {
            echo '<div class="sku_wrapper">SKU: <span class="sku" title="' . skuToSpelling($sku) . '" onclick="copyToClipboard(this)">' . $sku . '</span></div>';
        } else {
            echo '<div class="sku_wrapper">SKU: <span class="sku" onclick="copyToClipboard(this)">' . $sku . '</span></div>';
        }
    }

    // Herstellernummer Anzeige
    $herstellernummer = $product->get_attribute('pa_herstellernummer');
    if ($herstellernummer) {
        echo '<div class="herstellernummer_wrapper">Herstellernummer: <span>' . $herstellernummer . '</span></div>';
    }

    // Kategorien Anzeige
    echo '<div class="product-categories">Produktkategorien: ' . wc_get_product_category_list($product->get_id()) . '</div>';

    // Tags, falls benötigt
    echo wc_get_product_tag_list($product->get_id(), ', ', '<span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</span>');
}


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'sot_show_product_meta_custom', 5);






function enqueue_custom_styles() {
    // Überprüft, ob wir uns auf einer Einzelproduktseite befinden
    if (is_product()) {
        // Verlinken Sie zur CSS-Datei
        wp_enqueue_style('woocommerce-customizations', get_stylesheet_directory_uri() . '/woocommerce-customizations.css', array(), '1.0.4' );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
