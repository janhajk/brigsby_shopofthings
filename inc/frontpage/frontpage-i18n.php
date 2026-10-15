<?php
/**
 * Mehrsprachige Startseite (DE/FR/IT/EN).
 *
 * Deutsch kommt wie bisher aus der Admin-Seite „Startseite“ (Option sot_frontpage).
 * Für FR/IT/EN liegen hier die Übersetzungen; sie überschreiben beim Rendern einer Variante
 * die Texte der Option (Listen wie Karten/Schritte je Position und Feld). Bilder, Logos,
 * Reihenfolge und Sichtbarkeit bleiben die der deutschen Fassung.
 *
 * ⚠️ Wird ein Text in der Admin-Seite geändert, hier die Übersetzung nachführen.
 *
 * Darstellung: template-parts/frontpage/render.php gibt alle Sprachen aus (Cache-sicher);
 * die Sprache wählt das Skript des Plugins sot-landingpages (sot_lp_multi_script):
 * ?lang= > gespeicherte Wahl > Browsersprache, Crawler immer Deutsch.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function sot_fp_langs() {
    return array( 'de', 'fr', 'it', 'en' );
}

/** Sprache, die gerade gerendert wird (nur während render.php gesetzt). */
function sot_fp_lang() {
    return isset( $GLOBALS['sot_fp_lang'] ) ? $GLOBALS['sot_fp_lang'] : 'de';
}

/** Feste Texte aus den Sektionsvorlagen. */
function sot_fp_t( $key ) {
    $t = array(
        'more' => array( 'de' => 'Mehr erfahren →', 'fr' => 'En savoir plus →', 'it' => 'Scopri di più →', 'en' => 'Learn more →' ),
        'read' => array( 'de' => 'Mehr lesen →', 'fr' => 'Lire la suite →', 'it' => 'Leggi di più →', 'en' => 'Read more →' ),
    );
    $l = sot_fp_lang();
    return isset( $t[ $key ][ $l ] ) ? $t[ $key ][ $l ] : $t[ $key ]['de'];
}

/** Übersetzungen der Startseiten-Texte. */
function sot_fp_i18n_data() {
    return array(
        'fr' => array(
            'hero_subtitle' => 'L’IoT en toute simplicité – du capteur au cloud.',
            'hero_title'    => 'Votre <span class="highlight">boutique</span> suisse<br>pour le matériel <span class="highlight">IoT</span><br>et l’intégration',
            'hero_btn1_text' => 'Découvrir les produits',
            'hero_btn2_text' => 'Démarrer un projet',
            'hero_badges'   => array( 'Stock en Suisse', 'Distributeur officiel', 'Livraison rapide et support' ),
            'zg_eyebrow'    => 'Pour qui est ShopOfThings ?',
            'zg_heading'    => 'Nous accompagnons entreprises, intégrateurs et développeurs à chaque étape de leur projet IoT',
            'zg_cards'      => array(
                array( 'title' => 'Entreprises et villes', 'text' => 'Solutions de bout en bout pour projets Smart City et industriels.', 'link_text' => 'En savoir plus →' ),
                array( 'title' => 'Intégrateurs système', 'text' => 'Solutions de bout en bout pour projets Smart City et industriels.', 'link_text' => 'Découvrir →' ),
                array( 'title' => 'Techniciens et développeurs', 'text' => 'Prototypage, outils et capteurs pour vos besoins spécifiques.', 'link_text' => 'Vers l’assortiment →' ),
            ),
            'pr_eyebrow'    => 'Le chemin vers l’IoT – en quatre étapes',
            'pr_heading'    => 'De la mesure à la visualisation : voici comment nous faisons réussir votre projet IoT',
            'pr_steps'      => array(
                array( 'title' => 'Capteurs', 'line1' => 'Saisir les données', 'line2' => 'Capteurs de haute précision pour toutes les applications' ),
                array( 'title' => 'Connectivité', 'line1' => 'Transmission sécurisée', 'line2' => 'LoRaWAN, NB-IoT et autres technologies' ),
                array( 'title' => 'Intégration et visualisation', 'line1' => 'Analyse et pilotage', 'line2' => 'Tableaux de bord et interfaces' ),
                array( 'title' => 'Installation et support', 'line1' => 'Mise en œuvre professionnelle', 'line2' => 'Conseil et support technique' ),
            ),
            'kacheln_tab1_label' => 'Produits',
            'kacheln_tab2_label' => 'Applications',
            'kacheln_tab1_cards' => array(
                array( 'title' => 'Capteurs', 'text' => 'Température, humidité, CO2 et plus', 'btn_text' => 'Découvrir les capteurs' ),
                array( 'title' => 'Connectivité', 'text' => 'Passerelles LoRaWAN, NB-IoT, LTE, BLE', 'btn_text' => 'Assurer la connectivité' ),
                array( 'title' => 'Accessoires', 'text' => 'Antennes, câbles, boîtiers', 'btn_text' => 'Découvrir les accessoires' ),
                array( 'title' => 'Traceurs', 'text' => 'Traceurs GPS et de biens', 'btn_text' => 'Découvrir les traceurs' ),
            ),
            'kacheln_tab2_cards' => array(
                array( 'title' => 'Agriculture connectée', 'text' => 'Capteurs pour l’agriculture', 'btn_text' => 'En savoir plus', 'url' => '/agriculture-connectee/' ),
                array( 'title' => 'Télérelève', 'text' => 'Saisir intelligemment les consommations', 'btn_text' => 'En savoir plus', 'url' => '/telereleve-compteurs/' ),
                array( 'title' => 'Suivi de biens', 'text' => 'Position et état en un coup d’œil', 'btn_text' => 'En savoir plus', 'url' => '/traceurs-gps/' ),
            ),
            'cta_badge'     => 'Disponible immédiatement',
            'cta_heading'   => 'Prêt à faire passer votre projet IoT au niveau supérieur ?',
            'cta_text'      => 'Découvrez nos produits les plus demandés ou parlez directement à un expert – nous vous aidons à trouver la bonne solution.',
            'cta_btn1_text' => 'Voir les best-sellers',
            'cta_btn2_text' => 'Demander conseil',
            'cta_btn2_url'  => '/kontakt/?lang=fr',
            'cta_footnote'  => 'Plus de 1000 projets IoT réalisés avec succès',
            'why_heading'   => 'Pourquoi ShopOfThings ?',
            'why_items'     => array(
                array( 'title' => 'Distributeur officiel', 'text' => 'Partenaire agréé des principaux fabricants IoT' ),
                array( 'title' => 'Stock en Suisse', 'text' => 'Livraison en 48 heures dans toute la Suisse. Entreprise familiale 100 % suisse' ),
                array( 'title' => '7 ans d’expérience sur le marché IoT', 'text' => 'Expertise en LoRaWAN et solutions IoT' ),
                array( 'title' => 'Support et conseil personnels', 'text' => 'Conseil technique par des experts' ),
                array( 'title' => 'Solutions de bout en bout', 'text' => 'Du matériel à l’intégration cloud' ),
                array( 'title' => 'Expédition durable avec Biobiene®', 'text' => 'Expédition neutre en carbone pour un avenir vert' ),
            ),
            'partner_eyebrow' => 'Nos partenaires technologiques',
            'partner_heading' => 'Nous travaillons avec les principaux fabricants du monde entier',
            'kunden_heading'  => 'Nos clients font confiance à ShopOfThings',
            'stats_heading'   => 'Des chiffres qui convainquent',
            'stats_items'     => array(
                array( 'label' => 'villes connectées' ),
                array( 'label' => 'produits en stock' ),
                array( 'number' => '9 ans', 'label' => 'd’expérience' ),
                array( 'label' => 'clients' ),
            ),
            'news_heading' => 'Actualités du monde IoT',
            'ber_eyebrow'  => 'Vous avez un projet IoT ?',
            'ber_heading'  => 'Nous vous conseillons personnellement et trouvons la bonne solution – du choix à l’installation – au téléphone en allemand et en anglais, par écrit aussi en français',
            'ber_btn_text' => 'Demander un conseil',
            'ber_btn_url'  => '/kontakt/?angebot=1&lang=fr',
            'ber_role'     => 'Consultant IoT',
        ),
        'it' => array(
            'hero_subtitle' => 'L’IoT semplice – dal sensore al cloud.',
            'hero_title'    => 'Il vostro <span class="highlight">shop</span> svizzero<br>per hardware <span class="highlight">IoT</span><br>e integrazione',
            'hero_btn1_text' => 'Scoprire i prodotti',
            'hero_btn2_text' => 'Avviare un progetto',
            'hero_badges'   => array( 'Magazzino in Svizzera', 'Distributore ufficiale', 'Consegna rapida e supporto' ),
            'zg_eyebrow'    => 'Per chi è ShopOfThings?',
            'zg_heading'    => 'Accompagniamo aziende, integratori e sviluppatori in ogni fase del loro progetto IoT',
            'zg_cards'      => array(
                array( 'title' => 'Aziende e città', 'text' => 'Soluzioni end-to-end per progetti Smart City e industriali.', 'link_text' => 'Scopri di più →' ),
                array( 'title' => 'Integratori di sistemi', 'text' => 'Soluzioni end-to-end per progetti Smart City e industriali.', 'link_text' => 'Scopri ora →' ),
                array( 'title' => 'Tecnici e sviluppatori', 'text' => 'Prototipazione, strumenti e sensori per le vostre esigenze.', 'link_text' => 'All’assortimento →' ),
            ),
            'pr_eyebrow'    => 'La strada verso l’IoT – in quattro passi',
            'pr_heading'    => 'Dalla misura alla visualizzazione: così portiamo al successo il vostro progetto IoT',
            'pr_steps'      => array(
                array( 'title' => 'Sensori', 'line1' => 'Rilevare i dati', 'line2' => 'Sensori ad alta precisione per ogni applicazione' ),
                array( 'title' => 'Connettività', 'line1' => 'Trasmissione sicura', 'line2' => 'LoRaWAN, NB-IoT e altre tecnologie' ),
                array( 'title' => 'Integrazione e visualizzazione', 'line1' => 'Analisi e controllo', 'line2' => 'Dashboard e interfacce' ),
                array( 'title' => 'Installazione e supporto', 'line1' => 'Realizzazione professionale', 'line2' => 'Consulenza e supporto tecnico' ),
            ),
            'kacheln_tab1_label' => 'Prodotti',
            'kacheln_tab2_label' => 'Applicazioni',
            'kacheln_tab1_cards' => array(
                array( 'title' => 'Sensori', 'text' => 'Temperatura, umidità, CO2 e altro', 'btn_text' => 'Scoprire i sensori' ),
                array( 'title' => 'Connettività', 'text' => 'Gateway LoRaWAN, NB-IoT, LTE, BLE', 'btn_text' => 'Garantire la connettività' ),
                array( 'title' => 'Accessori', 'text' => 'Antenne, cavi, custodie', 'btn_text' => 'Scoprire gli accessori' ),
                array( 'title' => 'Tracker', 'text' => 'Tracker GPS e per beni', 'btn_text' => 'Scoprire i tracker' ),
            ),
            'kacheln_tab2_cards' => array(
                array( 'title' => 'Smart Farming', 'text' => 'Sensori per l’agricoltura', 'btn_text' => 'Scopri di più' ),
                array( 'title' => 'Smart Metering', 'text' => 'Rilevare i consumi in modo intelligente', 'btn_text' => 'Scopri di più' ),
                array( 'title' => 'Asset Tracking', 'text' => 'Posizione e stato sempre sotto controllo', 'btn_text' => 'Scopri di più' ),
            ),
            'cta_badge'     => 'Subito disponibile',
            'cta_heading'   => 'Pronti a portare il vostro progetto IoT al livello successivo?',
            'cta_text'      => 'Scoprite i nostri prodotti più richiesti o parlate direttamente con un esperto – vi aiutiamo a trovare la soluzione giusta.',
            'cta_btn1_text' => 'Vedere i più venduti',
            'cta_btn2_text' => 'Richiedere consulenza',
            'cta_btn2_url'  => '/kontakt/?lang=it',
            'cta_footnote'  => 'Oltre 1000 progetti IoT realizzati con successo',
            'why_heading'   => 'Perché ShopOfThings?',
            'why_items'     => array(
                array( 'title' => 'Distributore ufficiale', 'text' => 'Partner autorizzato dei principali produttori IoT' ),
                array( 'title' => 'Magazzino in Svizzera', 'text' => 'Consegna entro 48 ore in tutta la Svizzera. Azienda familiare 100 % svizzera' ),
                array( 'title' => '7 anni di esperienza nel mercato IoT', 'text' => 'Competenza in LoRaWAN e soluzioni IoT' ),
                array( 'title' => 'Supporto e consulenza personali', 'text' => 'Consulenza tecnica da parte di esperti' ),
                array( 'title' => 'Soluzioni end-to-end', 'text' => 'Dall’hardware all’integrazione nel cloud' ),
                array( 'title' => 'Spedizione sostenibile con Biobiene®', 'text' => 'Spedizione a impatto climatico zero per un futuro verde' ),
            ),
            'partner_eyebrow' => 'I nostri partner tecnologici',
            'partner_heading' => 'Collaboriamo con i principali produttori di tutto il mondo',
            'kunden_heading'  => 'I nostri clienti si fidano di ShopOfThings',
            'stats_heading'   => 'Numeri che convincono',
            'stats_items'     => array(
                array( 'label' => 'città connesse' ),
                array( 'label' => 'prodotti a magazzino' ),
                array( 'number' => '9 anni', 'label' => 'di esperienza' ),
                array( 'label' => 'clienti' ),
            ),
            'news_heading' => 'Novità dal mondo IoT',
            'ber_eyebrow'  => 'Avete un progetto IoT?',
            'ber_heading'  => 'Vi consigliamo personalmente e troviamo la soluzione giusta – dalla scelta all’installazione – al telefono in tedesco e inglese, per iscritto anche in italiano',
            'ber_btn_text' => 'Richiedere una consulenza',
            'ber_btn_url'  => '/kontakt/?angebot=1&lang=it',
            'ber_role'     => 'Consulente IoT',
        ),
        'en' => array(
            'hero_subtitle' => 'IoT made simple – from sensor to cloud.',
            'hero_title'    => 'Your Swiss <span class="highlight">shop</span><br>for <span class="highlight">IoT</span> hardware<br>and integration',
            'hero_btn1_text' => 'Discover products',
            'hero_btn2_text' => 'Start a project',
            'hero_badges'   => array( 'Warehouse in Switzerland', 'Official distributor', 'Fast delivery & support' ),
            'zg_eyebrow'    => 'Who is ShopOfThings for?',
            'zg_heading'    => 'We support companies, integrators and developers at every step of their IoT project',
            'zg_cards'      => array(
                array( 'title' => 'Companies & cities', 'text' => 'End-to-end solutions for smart city and industrial projects.', 'link_text' => 'Learn more →' ),
                array( 'title' => 'System integrators', 'text' => 'End-to-end solutions for smart city and industrial projects.', 'link_text' => 'Discover now →' ),
                array( 'title' => 'Engineers & developers', 'text' => 'Prototyping, tools and sensors for your individual requirements.', 'link_text' => 'To the range →' ),
            ),
            'pr_eyebrow'    => 'The path to IoT – in four steps',
            'pr_heading'    => 'From measurement to visualisation: this is how we make your IoT project a success',
            'pr_steps'      => array(
                array( 'title' => 'Sensors', 'line1' => 'Capture data', 'line2' => 'High-precision sensors for every application' ),
                array( 'title' => 'Connectivity', 'line1' => 'Secure data transfer', 'line2' => 'LoRaWAN, NB-IoT and other technologies' ),
                array( 'title' => 'Integration & visualisation', 'line1' => 'Analysis & control', 'line2' => 'Dashboards and interfaces' ),
                array( 'title' => 'Installation & support', 'line1' => 'Professional implementation', 'line2' => 'Advice and technical support' ),
            ),
            'kacheln_tab1_label' => 'Products',
            'kacheln_tab2_label' => 'Applications',
            'kacheln_tab1_cards' => array(
                array( 'title' => 'Sensors', 'text' => 'Temperature, humidity, CO2 and more', 'btn_text' => 'Discover sensors' ),
                array( 'title' => 'Connectivity', 'text' => 'LoRaWAN, NB-IoT, LTE gateways, BLE', 'btn_text' => 'Secure connectivity' ),
                array( 'title' => 'Accessories', 'text' => 'Antennas, cables, enclosures', 'btn_text' => 'Discover accessories' ),
                array( 'title' => 'Trackers', 'text' => 'GPS & asset trackers', 'btn_text' => 'Discover trackers' ),
            ),
            'kacheln_tab2_cards' => array(
                array( 'title' => 'Smart Farming', 'text' => 'Sensors for agriculture', 'btn_text' => 'Learn more' ),
                array( 'title' => 'Smart Metering', 'text' => 'Capture consumption intelligently', 'btn_text' => 'Learn more' ),
                array( 'title' => 'Asset Tracking', 'text' => 'Location and condition at a glance', 'btn_text' => 'Learn more' ),
            ),
            'cta_badge'     => 'Available now',
            'cta_heading'   => 'Ready to take your IoT project to the next level?',
            'cta_text'      => 'Discover our most popular products or talk directly to an expert – we help you find the right solution.',
            'cta_btn1_text' => 'See top sellers',
            'cta_btn2_text' => 'Get advice',
            'cta_btn2_url'  => '/kontakt/?lang=en',
            'cta_footnote'  => 'More than 1000 successful IoT projects delivered',
            'why_heading'   => 'Why ShopOfThings?',
            'why_items'     => array(
                array( 'title' => 'Official distributor', 'text' => 'Authorised partner of leading IoT manufacturers' ),
                array( 'title' => 'Warehouse in Switzerland', 'text' => 'Delivery within 48 hours throughout Switzerland. 100% Swiss family business' ),
                array( 'title' => '7 years of IoT market experience', 'text' => 'Expertise in LoRaWAN and IoT solutions' ),
                array( 'title' => 'Personal support & advice', 'text' => 'Technical advice from experts' ),
                array( 'title' => 'End-to-end solutions', 'text' => 'From hardware to cloud integration' ),
                array( 'title' => 'Sustainable shipping with Biobiene®', 'text' => 'Climate-neutral shipping for a green future' ),
            ),
            'partner_eyebrow' => 'Our technology partners',
            'partner_heading' => 'We work with leading manufacturers worldwide',
            'kunden_heading'  => 'Our customers trust ShopOfThings',
            'stats_heading'   => 'Figures that convince',
            'stats_items'     => array(
                array( 'label' => 'cities connected' ),
                array( 'label' => 'products in stock' ),
                array( 'number' => '9 years', 'label' => 'of experience' ),
                array( 'label' => 'customers' ),
            ),
            'news_heading' => 'News from the IoT world',
            'ber_eyebrow'  => 'Do you have an IoT project?',
            'ber_heading'  => 'We advise you personally and find the right solution – from selection to installation – by phone in German and English',
            'ber_btn_text' => 'Request advice',
            'ber_btn_url'  => '/kontakt/?angebot=1&lang=en',
            'ber_role'     => 'IoT Consultant',
        ),
    );
}

/** Übersetzung über die deutschen Optionen legen (Listen je Position und Feld). */
function sot_fp_localize( $opts ) {
    $lang = sot_fp_lang();
    if ( 'de' === $lang ) {
        return $opts;
    }
    static $cache = array();
    if ( isset( $cache[ $lang ] ) ) {
        return $cache[ $lang ];
    }
    $data = sot_fp_i18n_data();
    $tr   = isset( $data[ $lang ] ) ? $data[ $lang ] : array();
    foreach ( $tr as $key => $val ) {
        if ( ! isset( $opts[ $key ] ) ) {
            $opts[ $key ] = $val;
            continue;
        }
        if ( is_array( $val ) && is_array( $opts[ $key ] ) && isset( $val[0] ) && is_array( $val[0] ) ) {
            foreach ( $val as $i => $fields ) {               // Liste von Karten: feldweise je Position
                if ( isset( $opts[ $key ][ $i ] ) && is_array( $opts[ $key ][ $i ] ) ) {
                    $opts[ $key ][ $i ] = array_merge( $opts[ $key ][ $i ], $fields );
                }
            }
        } else {
            $opts[ $key ] = $val;                             // einfache Werte und Textlisten (Badges)
        }
    }
    // Anker innerhalb der Startseite zeigen auf die Sektion der eigenen Sprachvariante
    foreach ( array( 'hero_btn1_url', 'hero_btn2_url', 'cta_btn1_url', 'cta_btn2_url', 'ber_btn_url' ) as $k ) {
        if ( ! empty( $opts[ $k ] ) && 0 === strpos( $opts[ $k ], '#sektion-' ) ) {
            $opts[ $k ] .= '-' . $lang;
        }
    }
    return $cache[ $lang ] = $opts;
}

/** Sprachwähler im Header auf der Startseite (Theme-Filter, siehe header.php). */
add_filter( 'sot_language_switch', function ( $html ) {
    if ( ! is_front_page() || ! function_exists( 'sot_lp_multi_script' ) ) {
        return $html;
    }
    $names = array( 'de' => 'Deutsch', 'fr' => 'Français', 'it' => 'Italiano', 'en' => 'English' );
    $btns  = '';
    foreach ( sot_fp_langs() as $l ) {
        $btns .= '<button type="button" value="' . esc_attr( $l ) . '">' . esc_html( $names[ $l ] ) . '</button>';
    }
    return '<span class="sot-language is-switch" id="sot-lang-switch" role="button" tabindex="0" aria-haspopup="true" aria-label="Sprache / Langue / Lingua / Language">'
         . '<span class="sot-lang-cur">DE</span><span class="sot-lang-menu" hidden>' . $btns . '</span></span>';
}, 5 );
