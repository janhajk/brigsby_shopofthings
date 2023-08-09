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
 * Gibt eine formatierte Zeile zurück, die alle Produktkategorien des angegebenen Produkts
 * in einer sortierten und hierarchisch strukturierten Weise darstellt.
 *
 * Die Kategorien werden basierend auf ihrer Hierarchie sortiert und anschließend
 * in einer Zeile dargestellt, wobei die übergeordnete Kategorie zuerst und
 * die untergeordneten Kategorien danach (getrennt durch ein ">") aufgeführt werden.
 *
 * Die Funktion überspringt zudem die Kategorie mit dem Slug 'brands', da diese
 * in diesem Kontext nicht benötigt wird.
 *
 * @param int $product_id Die ID des Produkts, für das die Kategorien abgerufen werden sollen.
 * @return string Eine formatierte Zeile, die alle relevanten Produktkategorien des angegebenen Produkts darstellt.
 */
function display_sorted_categories($product_id) {
    $terms = wp_get_post_terms($product_id, 'product_cat', array("fields" => "all"));
    $brands_term_id = get_term_by('slug', 'brands', 'product_cat')->term_id;
    $solution_package_id = get_term_by('slug', 'solution-package', 'product_cat')->term_id;

    $all_lines = array();

    foreach($terms as $term) {
        // Kategorie mit dem Slug 'brands' und ihre untergeordneten Kategorien überspringen
        if ($term->term_id == $brands_term_id || $term->parent == $brands_term_id) {
            continue;
        }

        // Top-Kategorien ohne Unterkategorien ausschließen (außer 'solution-package')
        if ($term->parent == 0 && !get_term_children($term->term_id, 'product_cat') && $term->term_id != $solution_package_id) {
            continue;
        }

        $line = array();
        $current_term = $term;

        while ($current_term && $current_term->term_id != 0) {
            $term_link = get_term_link($current_term, 'product_cat');
            if (is_wp_error($term_link)) {
                continue 2;  // überspringt zur nächsten Iteration der äußeren foreach-Schleife
            }
            array_unshift($line, '<a href="' . esc_url($term_link) . '">' . $current_term->name . '</a>');
            $current_term = get_term($current_term->parent, 'product_cat');
        }

        // Nur Kategorienpfade hinzufügen, die bis zur tiefsten Ebene gehen
        if (!get_term_children($term->term_id, 'product_cat')) {
            // Zeile formatieren
            $formatted_line = join(' > ', $line);
            $all_lines[] = $formatted_line;
        }
    }

    // Kategorien alphabetisch sortieren
    sort($all_lines);

    return '<th scope="row">Kategorien:</th><td>' . join('<br>', $all_lines) . '</td>';
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
                alert('" . __('SKU kopiert:', 'your-text-domain') . "' + text);
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
            echo '<tr><th scope="row">' . __('SKU:', 'your-text-domain') . '</th><td><span class="sku" title="' . skuToSpelling($sku) . '" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        } else {
            echo '<tr><th scope="row">' . __('SKU:', 'your-text-domain') . '</th><td><span class="sku" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        }
    }

    // Herstellernummer Anzeige
    $herstellernummer = $product->get_attribute('pa_herstellernummer');
    if ($herstellernummer) {
        echo '<tr><th scope="row">' . __('P/N:', 'your-text-domain') . '</th><td>' . $herstellernummer . '</td></tr>';
    }

    // Marke Anzeige
    $marke = $product->get_attribute('pa_brand');
    if ($marke) {
        $marke_link = get_term_link($marke, 'pa_brand');  // Erstellt einen Link zur Marke
        echo '<tr><th scope="row">' . __('Marke:', 'your-text-domain') . '</th><td><a href="' . esc_url($marke_link) . '">' . $marke . '</a></td></tr>';
    }

    // Kategorien Anzeige
    echo '<tr>' . display_sorted_categories($product->get_id()) . '</tr>';

    // Tags, falls benötigt
    $tags = wc_get_product_tag_list($product->get_id(), ', ', '<span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</span>');
    if ($tags) {
        echo '<tr><th scope="row">' . __('Tags:', 'your-text-domain') . '</th><td>' . $tags . '</td></tr>';
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
        wp_enqueue_style('woocommerce-customizations', get_stylesheet_directory_uri() . '/woocommerce-customizations.css', array(), '1.0.10' );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


