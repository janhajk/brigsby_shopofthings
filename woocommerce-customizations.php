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


function display_sorted_categories($product_id) {
    $terms = wp_get_post_terms($product_id, 'product_cat', array("fields" => "all"));
    $sorted_terms = array();

    foreach($terms as $term) {
        if($term->parent == 0) { // Überprüfen, ob es sich um eine Top-Kategorie handelt
            $sorted_terms[$term->term_id] = array($term);
        } else {
            if(!isset($sorted_terms[$term->parent])){
                $sorted_terms[$term->parent] = array(get_term($term->parent, 'product_cat'));
            }
            $sorted_terms[$term->parent][] = $term;
        }
    }

    $output = '';
    foreach($sorted_terms as $parent_term_id => $children_terms) {
        $line = array();

        // Das Hauptelement zuerst hinzufügen
        $parent_term = get_term($parent_term_id, 'product_cat');
        $line[] = $parent_term->name;

        // Füge untergeordnete Begriffe hinzu
        foreach($children_terms as $child_term) {
            if($child_term->term_id != $parent_term_id) {
                $line[] = $child_term->name;
            }
        }

        // Zeile formatieren
        $formatted_line = join(' > ', $line);
        $output .= '<tr><th scope="row">Kategorie:</th><td>' . $formatted_line . '</td></tr>';
    }

    return $output;
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

    // Start der Tabelle
    echo '<table class="product-meta-table"><tbody>';

    // SKU Anzeige
    $sku = $product->get_sku();
    if ($sku) {
        if (isSKU($sku)) {
            echo '<tr><th scope="row">SKU:</th><td><span class="sku" title="' . skuToSpelling($sku) . '" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        } else {
            echo '<tr><th scope="row">SKU:</th><td><span class="sku" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        }
    }

    // Herstellernummer Anzeige
    $herstellernummer = $product->get_attribute('pa_herstellernummer');
    if ($herstellernummer) {
        echo '<tr><th scope="row">P/N:</th><td>' . $herstellernummer . '</td></tr>';
    }

    // Kategorien Anzeige
    echo display_sorted_categories($product->get_id());

    // Tags, falls benötigt
    $tags = wc_get_product_tag_list($product->get_id(), ', ', '<span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</span>');
    if ($tags) {
        echo '<tr><th scope="row">Tags:</th><td>' . $tags . '</td></tr>';
    }

    // Ende der Tabelle
    echo '</tbody></table>';
}



remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'sot_show_product_meta_custom', 5);






function enqueue_custom_styles() {
    // Überprüft, ob wir uns auf einer Einzelproduktseite befinden
    if (is_product()) {
        // Verlinken Sie zur CSS-Datei
        wp_enqueue_style('woocommerce-customizations', get_stylesheet_directory_uri() . '/woocommerce-customizations.css', array(), '1.0.7' );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


