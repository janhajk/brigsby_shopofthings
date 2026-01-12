<?php
/*
Template Name: Test Startseite
*/
get_header();
?>

<main id="main-content" class="sot-frontpage">

	<!-- 1. Hero-Bereich – rechtslastiges Layout mit Bild rechts, Text links -->
	<section class="sot-hero">
	    <div class="hgrid hero-grid">
	        
	        <!-- Linker Text-Bereich (ca. 50–60%) -->
	        <div class="hero-text hgrid-span-6 hgrid-span-tablet-12">
	            <p class="hero-subtitle">
	                IoT einfach gemacht – von Sensor bis Cloud.
	            </p>
	
	            <h1 class="hero-title">
	                Ihr Schweizer <span class="highlight">Shop</span><br>
	                für IoT-Hardware<br>
	                und Integration.
	            </h1>
	
	            <div class="hero-buttons">
	                <a href="/shop/" class="btn btn-primary">Produkte entdecken</a>
	                <a href="/projekt-starten/" class="btn btn-secondary">Projekt starten</a>
	            </div>
	
	            <div class="hero-badges">
	                <span class="badge">🇨🇭 Schweizer Lager</span>
	                <span class="badge">Offizieller Distributor</span>
	                <span class="badge">Schnelle Lieferung & Support</span>
	            </div>
	        </div>
	
	        <!-- Rechter Bild-Bereich (ca. 40–50%, überstehend) -->
	        <div class="hero-image hgrid-span-6 hgrid-span-tablet-12">
	            <img 
	                src="<?php echo get_stylesheet_directory_uri(); ?>/images/hero01.png" 
	                alt="Surreal Schweizer IoT-Landschaft" 
	                loading="eager"
	                width="1440" 
	                height="852"
	            >
	        </div>
	    </div>
	</section>

    <!-- 2. Für wen? – 3 Karten -->
    <section class="sot-target-groups">
        <div class="hgrid">
            <h2>Für wen ist ShopOfThings?</h2>
            <p>Wir unterstützen Unternehmen, Integratoren und Entwickler bei jedem Schritt Ihres IoT-Projekts.</p>

            <div class="target-cards">
                <div class="card">
                    <h3>Unternehmen & Städte</h3>
                    <p>End-to-End-Lösungen für Smart-City- und Industrie-Projekte.</p>
                    <a href="/anwendungen/smart-city/" class="card-link">Mehr erfahren →</a>
                </div>

                <div class="card">
                    <h3>Systemintegratoren</h3>
                    <p>End-to-End-Lösungen für Smart-City- und Industrie-Projekte.</p>
                    <a href="/partner/systemintegratoren/" class="card-link">Jetzt entdecken →</a>
                </div>

                <div class="card">
                    <h3>Techniker & Entwickler</h3>
                    <p>Prototyping, Tools und Sensoren für Ihre individuellen Anforderungen.</p>
                    <a href="/produkte/sensoren/" class="card-link">Zum Sortiment →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Der Weg zum IoT – 4 Schritte -->
    <section class="sot-process">
        <div class="hgrid">
            <h2>Der Weg zum IoT – in vier Schritten</h2>
            <p>Von der Messung bis zur Visualisierung: So bringen wir Ihr IoT-Projekt zum Erfolg.</p>

            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Sensorik</h3>
                    <p>Daten erfassen</p>
                    <p>Hochpräzise Sensoren für alle Anwendungen</p>
                    <a href="/sensorik/">Mehr erfahren →</a>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Connectivity</h3>
                    <p>Sichere Datenübertragung</p>
                    <p>LoRaWAN, NB-IoT und weitere Technologien</p>
                    <a href="/konnektivitaet/">Mehr erfahren →</a>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Integration & Steuerung</h3>
                    <p>Analyse & Steuerung</p>
                    <p>Dashboards und Schnittstellen</p>
                    <a href="/integration/">Mehr erfahren →</a>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Installation & Support</h3>
                    <p>Fachgerechte Umsetzung</p>
                    <p>Beratung und technischer Support</p>
                    <a href="/support/">Mehr erfahren →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Kategorien-Kacheln (kannst du als Gutenberg-Block oder Shortcode machen) -->
    <section class="sot-categories">
        <div class="hgrid">
            <h2>Unsere beliebtesten Kategorien</h2>

            <!-- Hier könntest du Gutenberg-Blöcke laden oder Shortcodes nutzen -->
            <?php echo do_shortcode('[products columns="4" limit="8" orderby="popularity"]'); ?>
            <!-- Oder statisch hardcoden, falls du willst -->
        </div>
    </section>

    <!-- 5. Warum ShopOfThings? – Vorteile -->
    <section class="sot-why-us">
        <div class="hgrid">
            <h2>Warum ShopOfThings?</h2>

            <div class="why-grid">
                <div class="why-item">
                    <span class="icon">🏢</span>
                    <h3>Offizieller Distributor</h3>
                    <p>Autorisierter Partner führender IoT-Hersteller</p>
                </div>
                <!-- weitere 5-6 Karten analog -->
            </div>
        </div>
    </section>

    <!-- 6. Partner-Logos -->
    <section class="sot-partners">
        <div class="hgrid">
            <h2>Unsere Technologiepartner</h2>
            <div class="partner-logos">
                <!-- Logos als <img> mit lazy loading -->
                <img src="..." alt="Adeunis" loading="lazy">
                <!-- alle weiteren -->
            </div>
        </div>
    </section>

    <!-- 7. Kunden-Logos -->
    <section class="sot-customers">
        <div class="hgrid">
            <h2>Unsere Kunden vertrauen auf ShopOfThings</h2>
            <div class="customer-logos">
                <!-- Logos der Städte / Firmen -->
            </div>
        </div>
    </section>

    <!-- 8. Zahlen, die überzeugen -->
    <section class="sot-stats">
        <div class="hgrid">
            <h2>Zahlen, die überzeugen</h2>
            <div class="stats-grid">
                <div class="stat">
                    <span class="number">>50</span>
                    <p>Städte vernetzt</p>
                </div>
                <!-- weitere -->
            </div>
        </div>
    </section>

    <!-- 9. Aktuelles aus der IoT-Welt (Blog-Teaser) -->
    <section class="sot-news">
        <div class="hgrid">
            <h2>Aktuelles aus der IoT-Welt</h2>
            <?php
            $recent_posts = new WP_Query([
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ]);
            if ($recent_posts->have_posts()) : ?>
                <div class="news-grid">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <article class="news-item">
                            <?php the_post_thumbnail('medium'); ?>
                            <time><?php echo get_the_date(); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <a href="<?php the_permalink(); ?>">Mehr lesen →</a>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>