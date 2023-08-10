<?php


// JavaScript zum Kopieren von Text in die Zwischenablage
$translatedString = __('SKU kopiert', 'shopofthings');
define('COPY_TO_CLIPBOARD_JS', <<<JS
<script>
function copyToClipboard(element) {
    var text = element.innerText;
    var textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    alert('{$translatedString}');
}
</script>
JS
);




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

    // Holen Sie die term_id von 'sensorik' und alle seine Unterordnungen
    $sensorik_term_id = get_term_by('slug', 'sensorik', 'product_cat')->term_id;
    $sensorik_children = get_term_children($sensorik_term_id, 'product_cat');
    $sensorik_all_terms = array_merge([$sensorik_term_id], $sensorik_children);

    $all_lines = array();

    foreach($terms as $term) {
        // Kategorie mit dem Slug 'brands' und ihre untergeordneten Kategorien überspringen
        if ($term->term_id == $brands_term_id || $term->parent == $brands_term_id) {
            continue;
        }

        // Überspringen von "sensorik" und allen seinen Unterordnungen
        if (in_array($term->term_id, $sensorik_all_terms)) {
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

    return '<th scope="row">' . __( 'Kategorien:', 'textdomain' ) . '</th><td>' . join('<br>', $all_lines) . '</td>';
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

      echo COPY_TO_CLIPBOARD_JS; // Das JS-Script einfügen

      // Start der Tabelle
      echo '<table class="product-meta-table"><tbody>';

      // SKU Anzeige
      $sku = $product->get_sku();
      if ($sku) {
        if (isSKU($sku)) {
            echo '<tr><th scope="row">' . __('SKU:', 'shopofthings') . '</th><td><span class="sku" title="' . skuToSpelling($sku) . '" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        } else {
            echo '<tr><th scope="row">' . __('SKU:', 'shopofthings') . '</th><td><span class="sku" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        }
      }

      // Herstellernummer Anzeige
      $herstellernummer = $product->get_attribute('pa_herstellernummer');
      if ($herstellernummer) {
        echo '<tr><th scope="row">' . __('P/N:', 'shopofthings') . '</th><td>' . $herstellernummer . '</td></tr>';
      }

      // Marke Anzeige
      $marke = $product->get_attribute('pa_brand');
      if ($marke) {
        $marke_link = get_term_link($marke, 'pa_brand');  // Erstellt einen Link zur Marke
        echo '<tr><th scope="row">' . __('Marke:', 'shopofthings') . '</th><td><a href="' . esc_url($marke_link) . '">' . $marke . '</a></td></tr>';
      }

      // Kategorien Anzeige
      echo '<tr>' . display_sorted_categories($product->get_id()) . '</tr>';

      // Tags, falls benötigt
      // $tag_count = count($product->get_tag_ids());
      // $tags_label = _n('Tag:', 'Tags:', $tag_count, 'shopofthings');
      // $tags = wc_get_product_tag_list($product->get_id(), ', ');
      // if ($tags) {
      //       echo '<tr><th scope="row">' . $tags_label . '</th><td>' . $tags . '</td></tr>';
      // }
      
      // Sensoren Anzeige (mit icon)
      $sensoren = $product->get_attribute('pa_sensoren');
      if ($sensoren) {
          $sensoren_terms = explode(', ', $sensoren);
          $thumbnail_elements = [];
          $no_thumbnail_elements = []; // Ein separates Array für Werte ohne Thumbnails

            foreach ($sensoren_terms as $sensoren_terms_name) {
                $term = get_term_by('name', $sensoren_terms_name, 'pa_sensoren');

                if ($term) {
                    $thumbnail_id = get_term_meta($term->term_id, 'product_search_image_id', true);
                    $thumbnail_url = wp_get_attachment_url($thumbnail_id);
                    $term_link = get_term_link($term);  // Link zum Term holen

                    if ($thumbnail_url) {
                        $thumbnail_elements[$sensoren_terms_name] = '<a style="display:flex" href="' . esc_url($term_link) . '"><img src="' . esc_url($thumbnail_url) . '" alt="Sensoren Thumbnail" style="max-height: 30px;" title="' . esc_attr($sensoren_terms_name) . '"></a>';  // Den Link um das Bild herum hinzufügen
                    } else {
                        $no_thumbnail_elements[] = '<a style="display:flex" href="' . esc_url($term_link) . '">' . $sensoren_terms_name . '</a>';  // Den Link um den Namen des Terms herum hinzufügen
                    }
                }
            }

          // Sortieren Sie die Arrays
          ksort($thumbnail_elements);
          sort($no_thumbnail_elements);

          // Die sortierten Elemente zu einem Gesamtarray zusammenführen
          $all_elements = array_merge(array_values($thumbnail_elements), $no_thumbnail_elements);

          // Wenn unser Array Einträge hat, zeigen wir alle gesammelten Thumbnails und/oder Texte in einer Zeile an
          if (!empty($all_elements)) {
              echo '<tr style="line-height: 4em; border-bottom:1px solid gray;border-top:1px solid gray"><td colspan="2" style="align-items: center; justify-content: center; height: 100%;"><div style="display: flex; width: 100%; align-items: center; justify-content: space-between; padding:10px 0px">' . implode(' ', $all_elements) . '</div></td></tr>';
          }
      }

      // Produktkennzeichen Anzeige (mit icon)
      $produktkennzeichen = $product->get_attribute('pa_produktkennzeichen');
      if ($produktkennzeichen) {
          $kennzeichen_terms = explode(', ', $produktkennzeichen);
          $thumbnail_elements = [];
          $no_thumbnail_elements = []; // Ein separates Array für Werte ohne Thumbnails

            foreach ($kennzeichen_terms as $kennzeichen_term_name) {
                $term = get_term_by('name', $kennzeichen_term_name, 'pa_produktkennzeichen');

                if ($term) {
                    $thumbnail_id = get_term_meta($term->term_id, 'product_search_image_id', true);
                    $thumbnail_url = wp_get_attachment_url($thumbnail_id);
                    $term_link = get_term_link($term);  // Link zum Term holen

                    if ($thumbnail_url) {
                        $thumbnail_elements[$kennzeichen_term_name] = '<a style="display:flex" href="' . esc_url($term_link) . '"><img src="' . esc_url($thumbnail_url) . '" alt="Produktkennzeichen Thumbnail" style="max-height: 30px;" title="' . esc_attr($kennzeichen_term_name) . '"></a>';  // Den Link um das Bild herum hinzufügen
                    } else {
                        $no_thumbnail_elements[] = '<a style="display:flex" href="' . esc_url($term_link) . '">' . $kennzeichen_term_name . '</a>';  // Den Link um den Namen des Terms herum hinzufügen
                    }
                }
            }

          // Sortieren Sie die Arrays
          ksort($thumbnail_elements);
          sort($no_thumbnail_elements);

          // Die sortierten Elemente zu einem Gesamtarray zusammenführen
          $all_elements = array_merge(array_values($thumbnail_elements), $no_thumbnail_elements);

          // Wenn unser Array Einträge hat, zeigen wir alle gesammelten Thumbnails und/oder Texte in einer Zeile an
          if (!empty($all_elements)) {
              echo '<tr style="line-height: 4em; border-bottom:1px solid gray;border-top:1px solid gray"><td colspan="2" style="align-items: center; justify-content: center; height: 100%;"><div style="display: flex; width: 100%; align-items: center; justify-content: space-between; padding:10px 0px">' . implode(' ', $all_elements) . '</div></td></tr>';
          }
      }
      
      // Lagerverfügbarkeit
      $stock_info = get_stock_info($product);
      $stock_display = join(array_slice($stock_info,0,3), '&nbsp;');
      if ($stock_info['canBackorder'] && $stock_info['stock'] > 0) {
        $stock_display .= '<br />Externes Lager: +' . $stock_info['lieferzeit'] . ' Tage.';
      }
      elseif (!$stock_info['canBackorder'] && $stock_info['stock'] > 0) {
        $stock_display .= '<br />Weitere Mengen auf Anfrage.';
      }
      echo '<tr><th scope="row">' . __('Lager:', 'shopofthings') . '</th><td>' . $stock_display . '</td></tr>';



      // Ende der Tabelle
      echo '</tbody></table>';
}



// Dieser Filter wird nun geändert, um nichts zurückzugeben, da wir den Lagerbestand bereits oben angezeigt haben.
add_filter( 'woocommerce_get_availability', 'remove_default_stock_display', 1, 2);
function remove_default_stock_display( $availability, $_product ) {
    // Wenn es sich nicht um eine Produktvariation handelt, verstecken Sie die Verfügbarkeitsnachricht
    if ( ! $_product->is_type( 'variation' ) ) {
            $availability['availability'] = '<span style="display:none;">' . $availability['availability'] . '</span>';
    }
    else {
            $stock_info = get_stock_info($_product);
            $stock_display = join(array_slice($stock_info,0,3), '&nbsp;');
            if ($stock_info['canBackorder'] && $stock_info['stock'] > 0) {
                  $stock_display .= '<br />Externes Lager: +' . $stock_info['lieferzeit'] . ' Tage.';
            }
            elseif (!$stock_info['canBackorder'] && $stock_info['stock'] > 0) {
                  $stock_display .= '<br />Weitere Mengen auf Anfrage.';
            }
            $availability['availability'] = '<span style="">' . $stock_display . '</span>';
    }
    return $availability;
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


