<?php
/**
 * Footer – komplett hardgecoded für ShopOfThings
 * Child-Theme: brigsby_shopofthings
 */
?>

<?php do_action( 'hoot_template_main_wrapper_end' ); ?>
</div><!-- #main -->
</div><!-- #page-wrapper -->

<footer class="site-footer">

    <!-- Newsletter-Bereich -->
    <div class="footer-newsletter">
        <div class="col-full">
            <h3>Newsletter abonnieren</h3>
            <p>Bleiben Sie informiert über neue Produkte und IoT-Trends</p>
            
            <!-- Hier kannst du später ein echtes Formular einbauen (z. B. mit Mailchimp, Brevo oder WP-Plugin) -->
            <form class="newsletter-form">
                <input type="email" placeholder="Ihre E-Mail-Adresse" required>
                <label class="checkbox-label">
                    <input type="checkbox" required>
                    Mit meiner Anmeldung erkläre ich mich mit der Datenschutzerklärung einverstanden
                </label>
                <button type="submit">Anmelden</button>
            </form>
        </div>
    </div>

    <!-- Haupt-Footer mit 4 Spalten -->
    <div class="footer-main">
        <div class="col-full">
            <div class="footer-columns">

                <!-- Spalte 1: Unternehmen -->
                <div class="footer-column">
                    <h4>Unternehmen</h4>
                    <ul>
                        <li><a href="/ueber-uns">Über uns</a></li>
                        <li><a href="/agb">AGB</a></li>
                        <li><a href="/datenschutz">Datenschutz</a></li>
                        <li><a href="/impressum">Impressum</a></li>
                        <li><a href="/nachhaltigkeit">Nachhaltigkeit</a></li>
                    </ul>
                </div>

                <!-- Spalte 2: Support -->
                <div class="footer-column">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="/versand-rueckgabe">Versand & Rückgabe</a></li>
                        <li><a href="/faq">FAQ</a></li>
                        <li><a href="/kontakt">Kontakt</a></li>
                        <li><a href="/supportportal">Supportportal</a></li>
                    </ul>
                </div>

                <!-- Spalte 3: Ressourcen -->
                <div class="footer-column">
                    <h4>Ressourcen</h4>
                    <ul>
                        <li><a href="/partner-werden">Partner werden</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/katalog">Katalog</a></li>
                        <li><a href="/newsletter">Newsletter</a></li>
                    </ul>
                </div>

                <!-- Spalte 4: Kontakt -->
                <div class="footer-column footer-contact">
                    <h4>Kontakt</h4>
                    <p>
                        Thingware GmbH<br>
                        Brühlstrasse 20<br>
                        4415 Lausen<br>
                        +41 61 551 41 07<br>
                        <a href="mailto:hallo@shopofthings.ch">hallo@shopofthings.ch</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright-Zeile -->
    <div class="footer-bottom">
        <div class="col-full">
            <p>&copy; <?php echo date('Y'); ?> Thingware GmbH | Wir versenden grün 🌿 mit Biobiene®</p>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>