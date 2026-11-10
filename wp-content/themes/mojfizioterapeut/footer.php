        </main>

        <?php
        $footer_title = function_exists('get_field') ? get_field('footer_title', 'option') : '';
        $footer_text = function_exists('get_field') ? get_field('footer_text', 'option') : '';
        $footer_link = function_exists('get_field') ? get_field('footer_link', 'option') : null;

        $footer_title = $footer_title ? $footer_title : 'MOJ FIZIOTERAPEUT';
        $footer_text = $footer_text ? $footer_text : 'Digitalni edukativni vodič dostupan kroz marinafit.online';

        if (empty($footer_link['url'])) {
            $footer_link = array(
                'url'    => 'https://marinafit.online',
                'title'  => 'marinafit.online',
                'target' => '_blank',
            );
        }
        ?>

        <footer class="footer" role="contentinfo">
            <div class="container">
                <strong class="footer-title"><?php echo esc_html($footer_title); ?></strong>
                <?php if ($footer_text) : ?>
                    <p><?php echo wp_kses_post($footer_text); ?></p>
                <?php endif; ?>
                <?php if (!empty($footer_link['url']) && !empty($footer_link['title'])) : ?>
                    <p>
                        <a href="<?php echo esc_url($footer_link['url']); ?>" <?php echo !empty($footer_link['target']) ? 'target="' . esc_attr($footer_link['target']) . '" rel="noopener"' : ''; ?>>
                            <?php echo esc_html($footer_link['title']); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        </footer>

    </div>

    <?php wp_footer(); ?>

</body>

</html>
