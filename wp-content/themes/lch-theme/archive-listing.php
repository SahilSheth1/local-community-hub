<?php
/**
 * Template: Archive for Listings CPT
 * URL: /listings/
 * Includes: Search bar + Category/Tag filters via WP_Query
 */
get_header(); ?>

<main class="lch-archive">

    <div class="lch-archive__header">
        <h1>Local Business Directory</h1>
        <p>Browse all local businesses in the community.</p>
    </div>

    <!-- =====================
         SEARCH & FILTER FORM
         ===================== -->
    <form class="lch-filter" method="GET" action="">

        <!-- Keyword Search -->
        <div class="lch-filter__group">
            <input
                type="text"
                name="lch_search"
                class="lch-filter__input"
                placeholder="Search businesses..."
                value="<?php echo isset( $_GET['lch_search'] ) ? esc_attr( $_GET['lch_search'] ) : ''; ?>"
            />
        </div>

        <!-- Category Filter -->
        <div class="lch-filter__group">
            <select name="lch_category" class="lch-filter__select">
                <option value="">All Categories</option>
                <?php
                $categories = get_terms( array(
                    'taxonomy'   => 'listing_category',
                    'hide_empty' => true,
                ));
                foreach ( $categories as $cat ) :
                    $selected = ( isset( $_GET['lch_category'] ) && $_GET['lch_category'] === $cat->slug ) ? 'selected' : '';
                ?>
                    <option value="<?php echo esc_attr( $cat->slug ); ?>" <?php echo $selected; ?>>
                        <?php echo esc_html( $cat->name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tag Filter -->
        <div class="lch-filter__group">
            <select name="lch_tag" class="lch-filter__select">
                <option value="">All Tags</option>
                <?php
                $tags = get_terms( array(
                    'taxonomy'   => 'listing_tag',
                    'hide_empty' => true,
                ));
                foreach ( $tags as $tag ) :
                    $selected = ( isset( $_GET['lch_tag'] ) && $_GET['lch_tag'] === $tag->slug ) ? 'selected' : '';
                ?>
                    <option value="<?php echo esc_attr( $tag->slug ); ?>" <?php echo $selected; ?>>
                        <?php echo esc_html( $tag->name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Price Range Filter -->
        <div class="lch-filter__group">
            <select name="lch_price" class="lch-filter__select">
                <option value="">Any Price</option>
                <?php
                $prices = array( '$' => 'Budget', '$$' => 'Moderate', '$$$' => 'Expensive' );
                foreach ( $prices as $value => $label ) :
                    $selected = ( isset( $_GET['lch_price'] ) && $_GET['lch_price'] === $value ) ? 'selected' : '';
                ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php echo $selected; ?>>
                        <?php echo esc_html( $value . ' — ' . $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="lch-filter__submit">Search</button>

        <?php if ( isset( $_GET['lch_search'] ) || isset( $_GET['lch_category'] ) || isset( $_GET['lch_tag'] ) || isset( $_GET['lch_price'] ) ) : ?>
            <a href="<?php echo get_post_type_archive_link( 'listing' ); ?>" class="lch-filter__reset">
                Clear Filters
            </a>
        <?php endif; ?>

    </form>

    <!-- =====================
         WP_QUERY LOGIC
         ===================== -->
    <?php
    // Build query args
    $query_args = array(
        'post_type'      => 'listing',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
    );

    // Keyword search
    if ( ! empty( $_GET['lch_search'] ) ) {
        $query_args['s'] = sanitize_text_field( $_GET['lch_search'] );
    }

    // Category filter
    if ( ! empty( $_GET['lch_category'] ) ) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'listing_category',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['lch_category'] ),
        );
    }

    // Tag filter
    if ( ! empty( $_GET['lch_tag'] ) ) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'listing_tag',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['lch_tag'] ),
        );
    }

    // Price range filter (ACF meta field)
    if ( ! empty( $_GET['lch_price'] ) ) {
        $query_args['meta_query'][] = array(
            'key'     => 'price_range',
            'value'   => sanitize_text_field( $_GET['lch_price'] ),
            'compare' => '=',
        );
    }

    // If multiple tax_query items, set relation
    if ( isset( $query_args['tax_query'] ) && count( $query_args['tax_query'] ) > 1 ) {
        $query_args['tax_query']['relation'] = 'AND';
    }

    $listings_query = new WP_Query( $query_args );
    ?>

    <!-- Results Count -->
    <?php if ( $listings_query->have_posts() ) : ?>
        <p class="lch-results-count">
            Showing <?php echo $listings_query->found_posts; ?> listing<?php echo $listings_query->found_posts !== 1 ? 's' : ''; ?>
        </p>
    <?php endif; ?>

    <!-- =====================
         LISTINGS GRID
         ===================== -->
    <div class="lch-archive__grid">

        <?php if ( $listings_query->have_posts() ) : while ( $listings_query->have_posts() ) : $listings_query->the_post(); ?>

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

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="lch-no-results">
                <p>No listings found matching your search.</p>
                <a href="<?php echo get_post_type_archive_link( 'listing' ); ?>">
                    Clear filters and try again
                </a>
            </div>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>