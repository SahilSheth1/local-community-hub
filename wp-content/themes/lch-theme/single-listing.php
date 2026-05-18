<?php
/**
 * Template: Single Listing
 * URL: /listings/{listing-slug}/
 */
get_header(); ?>

<main class="lch-single">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article class="lch-single__listing">

            <div class="lch-single__header">
                <h1><?php the_title(); ?></h1>

                <?php
                $categories = get_the_terms( get_the_ID(), 'listing_category' );
                if ( $categories && ! is_wp_error( $categories ) ) :
                    foreach ( $categories as $cat ) : ?>
                        <span class="lch-badge lch-badge--category">
                            <?php echo esc_html( $cat->name ); ?>
                        </span>
                    <?php endforeach;
                endif; ?>
            </div>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="lch-single__image">
                    <?php the_post_thumbnail( 'large' ); ?>
                </div>
            <?php endif; ?>

            <div class="lch-single__meta">

                <?php $address = get_field( 'address' ); ?>
                <?php if ( $address ) : ?>
                    <div class="lch-meta-row">
                        <span class="lch-meta-row__icon">📍</span>
                        <span><?php echo esc_html( $address ); ?></span>
                    </div>
                <?php endif; ?>

                <?php $hours = get_field( 'business_hours' ); ?>
                <?php if ( $hours ) : ?>
                    <div class="lch-meta-row">
                        <span class="lch-meta-row__icon">🕐</span>
                        <span><?php echo esc_html( $hours ); ?></span>
                    </div>
                <?php endif; ?>

                <?php $phone = get_field( 'phone_number' ); ?>
                <?php if ( $phone ) : ?>
                    <div class="lch-meta-row">
                        <span class="lch-meta-row__icon">📞</span>
                        <span><?php echo esc_html( $phone ); ?></span>
                    </div>
                <?php endif; ?>

                <?php $email = get_field( 'email_address' ); ?>
                <?php if ( $email ) : ?>
                    <div class="lch-meta-row">
                        <span class="lch-meta-row__icon">✉️</span>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php $website = get_field( 'website_url' ); ?>
                <?php if ( $website ) : ?>
                    <div class="lch-meta-row">
                        <span class="lch-meta-row__icon">🌐</span>
                        <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener">
                            <?php echo esc_html( $website ); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php $price = get_field( 'price_range' ); ?>
                <?php if ( $price ) : ?>
                    <div class="lch-meta-row">
                        <span class="lch-meta-row__icon">💰</span>
                        <span><?php echo esc_html( $price ); ?></span>
                    </div>
                <?php endif; ?>

            </div>

            <?php
            $tags = get_the_terms( get_the_ID(), 'listing_tag' );
            if ( $tags && ! is_wp_error( $tags ) ) : ?>
                <div class="lch-single__tags">
                    <?php foreach ( $tags as $tag ) : ?>
                        <span class="lch-badge lch-badge--tag">
                            <?php echo esc_html( $tag->name ); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( get_the_content() ) : ?>
                <div class="lch-single__content">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

            <a href="<?php echo get_post_type_archive_link( 'listing' ); ?>" class="lch-back-link">
                ← Back to All Listings
            </a>

        </article>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>