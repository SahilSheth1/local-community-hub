<?php
/**
 * Template: Archive for Listings CPT
 * URL: /listings/
 */
get_header(); ?>

<main class="lch-archive">

    <div class="lch-archive__header">
        <h1>Local Business Directory</h1>
        <p>Browse all local businesses in the community.</p>
    </div>

    <div class="lch-archive__grid">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <article class="lch-card">

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="lch-card__image">
                        <?php the_post_thumbnail( 'medium' ); ?>
                    </div>
                <?php endif; ?>

                <div class="lch-card__body">

                    <h2 class="lch-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <?php
                    // Get listing categories
                    $categories = get_the_terms( get_the_ID(), 'listing_category' );
                    if ( $categories && ! is_wp_error( $categories ) ) : ?>
                        <div class="lch-card__categories">
                            <?php foreach ( $categories as $cat ) : ?>
                                <span class="lch-badge lch-badge--category">
                                    <?php echo esc_html( $cat->name ); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Get ACF fields
                    $address     = get_field( 'address' );
                    $phone       = get_field( 'phone_number' );
                    $price_range = get_field( 'price_range' );
                    ?>

                    <?php if ( $address ) : ?>
                        <p class="lch-card__address">📍 <?php echo esc_html( $address ); ?></p>
                    <?php endif; ?>

                    <?php if ( $phone ) : ?>
                        <p class="lch-card__phone">📞 <?php echo esc_html( $phone ); ?></p>
                    <?php endif; ?>

                    <?php if ( $price_range ) : ?>
                        <span class="lch-badge lch-badge--price">
                            <?php echo esc_html( $price_range ); ?>
                        </span>
                    <?php endif; ?>

                    <a href="<?php the_permalink(); ?>" class="lch-card__link">
                        View Details →
                    </a>

                </div>

            </article>

        <?php endwhile; else : ?>
            <p>No listings found.</p>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>