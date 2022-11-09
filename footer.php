        </main>
        <footer class="footer mt-auto text-bg-dark py-2">
            <div class="container-xxl">
                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav mx-auto justify-content-center text-white'
                ) ); ?>
                <div class="footer-copyrigt border-top text-center pt-1">© <?php echo date('Y') ?> Company, Inc</div>
            </div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
