<?php
/**
 * Genesis Block Theme functions and definitions
 *
 * @package Genesis Block Theme
 */

if ( ! function_exists( 'genesis_block_theme_setup' ) ) :
	/**
	 * Sets up Genesis Block Theme's defaults and registers support for various WordPress features.
	 */
	function genesis_block_theme_setup() {
		/*
		* Add page template switcher watching.
		*/
		require_once get_template_directory() . '/inc/admin/page-template-toggle/php/page-template-toggle.php';

		/*
		 * Tell WordPress that this theme supports the way Gutenberg parses and replaces the style-editor.css file in wp-admin.
		 * @see: https://developer.wordpress.org/block-editor/developers/themes/theme-support/#editor-styles
		 */
		add_theme_support( 'editor-styles' );

		/*
		 * Tell WordPress to load the "Gutenberg Theme" stylesheet on the frontend and in the editor.
		 * @see: https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles
		 * @see: https://github.com/WordPress/gutenberg/commit/429558ad320c55e3e8b5236dfb6ce139fa3a7d25
		 */
		add_theme_support( 'wp-block-styles' );

		/**
		 * Add support for custom line heights.
		 */
		add_theme_support( 'custom-line-height' );

		/**
		 * Add styles to post editor.
		 */
		add_editor_style( array( genesis_block_theme_fonts_url(), 'style-editor.css' ) );

		/*
		* Make theme available for translation.
		*/
		load_theme_textdomain( 'genesis-block-theme', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		* Post thumbnail support and image sizes.
		*/
		add_theme_support( 'post-thumbnails' );

		/*
		* Add title output.
		*/
		add_theme_support( 'title-tag' );

		/**
		 * Custom Background support.
		 */
		$defaults = array(
			'default-color' => 'ffffff',
		);
		add_theme_support( 'custom-background', $defaults );

		/**
		 * Add wide image support.
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Selective Refresh for Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add excerpt support to pages.
		add_post_type_support( 'page', 'excerpt' );

		// Featured image.
		add_image_size( 'genesis-block-theme-featured-image', 1200 );

		// Wide featured image.
		add_image_size( 'genesis-block-theme-featured-image-wide', 1400 );

		// Logo size.
		add_image_size( 'genesis-block-theme-logo', 300 );

		/**
		 * Register Navigation menu.
		 */
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'genesis-block-theme' ),
				'footer'  => esc_html__( 'Footer Menu', 'genesis-block-theme' ),
			)
		);

		/**
		 * Add Site Logo feature.
		 */
		add_theme_support(
			'custom-logo',
			array(
				'header-text' => array( 'titles-wrap' ),
				'size'        => 'genesis-block-theme-logo',
			)
		);

		/**
		 * Enable HTML5 markup.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'gallery',
				'style',
				'script',
			)
		);

		// Make media embeds responsive.
		add_theme_support( 'responsive-embeds' );
		add_filter(
			'body_class',
			function( $classes ) {
				$classes[] = 'wp-embed-responsive';
				return $classes;
			}
		);
	}
endif; // genesis_block_theme_setup.
add_action( 'after_setup_theme', 'genesis_block_theme_setup' );

/**
 * Register widget area.
 */
function genesis_block_theme_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer - Column 1', 'genesis-block-theme' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Widgets added here will appear in the left column of the footer.', 'genesis-block-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer - Column 2', 'genesis-block-theme' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Widgets added here will appear in the center column of the footer.', 'genesis-block-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer - Column 3', 'genesis-block-theme' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Widgets added here will appear in the right column of the footer.', 'genesis-block-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'genesis_block_theme_widgets_init' );


if ( ! function_exists( 'genesis_block_theme_fonts_url' ) ) :
	/**
	 * Return the Google font stylesheet URL.
	 *
	 * @return string
	 */
	function genesis_block_theme_fonts_url() {

		$fonts_url = '';

		/*
		 * Translators: If there are characters in your language that are not
		 * supported by these fonts, translate this to 'off'. Do not translate
		 * into your own language.
		 */

		$font = esc_html_x( 'on', 'Public Sans font: on or off', 'genesis-block-theme' );

		if ( 'off' !== $font ) {
			$fonts_url = get_template_directory_uri() . '/inc/fonts/css/font-style.css';
		}

		return $fonts_url;
	}
endif;


/**
 * Enqueue scripts and styles.
 */
function genesis_block_theme_scripts() {

	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'genesis-block-theme-style', get_stylesheet_uri(), [], $version );

	/**
	* Load fonts.
	*/
	wp_enqueue_style( 'genesis-block-theme-fonts', genesis_block_theme_fonts_url(), [], null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- see https://core.trac.wordpress.org/ticket/49742

	/**
	 * Icons stylesheet.
	 */
	wp_enqueue_style( 'gb-icons', get_template_directory_uri() . '/inc/icons/css/icon-style.css', [], $version, 'screen' );

	/**
	 * Load Genesis Block Theme's javascript.
	 */
	wp_enqueue_script( 'genesis-block-theme-js', get_template_directory_uri() . '/js/genesis-block-theme.js', [ 'jquery' ], $version, true );

	/**
	 * Localizes the genesis-block-theme-js file.
	 */
	wp_localize_script(
		'genesis-block-theme-js',
		'genesis_block_theme_js_vars',
		array(
			'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
		)
	);

	/**
	 * Load the comment reply script.
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'genesis_block_theme_scripts' );


/**
 * Enqueue admin scripts and styles in editor.
 *
 * @param string $hook The admin page.
 */
function genesis_block_theme_admin_scripts( $hook ) {
	if ( 'post.php' !== $hook ) {
		return;
	}

	/**
	* Load editor fonts.
	*/
	wp_enqueue_style( 'genesis-block-theme-admin-fonts', genesis_block_theme_fonts_url(), [], null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- see https://core.trac.wordpress.org/ticket/49742

}
add_action( 'admin_enqueue_scripts', 'genesis_block_theme_admin_scripts', 5 );


/**
 * Enqueue customizer styles for the block editor.
 */
function genesis_block_theme_customizer_styles_for_block_editor() {
	/**
	 * Styles from the customizer.
	 */
	wp_register_style( 'genesis-block-theme-customizer-styles', false ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	wp_enqueue_style( 'genesis-block-theme-customizer-styles' );
	wp_add_inline_style( 'genesis-block-theme-customizer-styles', genesis_block_theme_customizer_css_output_for_block_editor() );
}
add_action( 'enqueue_block_editor_assets', 'genesis_block_theme_customizer_styles_for_block_editor' );


/**
 * Load block editor scripts.
 */
function genesis_block_theme_block_editor_scripts() {

	if ( ! function_exists( 'get_current_screen' ) ) {
		return;
	}

	$current_screen = get_current_screen();
	$post_type      = $current_screen->post_type ?: '';

	// Remove Title Toggle.
	if ( $post_type === 'page' ) {
		$title_toggle_meta = require_once 'js/title-toggle/title-toggle.asset.php';
		wp_enqueue_script(
			'genesis-block-theme-title-toggle',
			get_template_directory_uri() . '/js/title-toggle/title-toggle.js',
			$title_toggle_meta['dependencies'],
			$title_toggle_meta['version'],
			true
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'genesis_block_theme_block_editor_scripts' );


/**
 * Register _genesis-block-theme-tittle-toggle meta.
 */
function genesis_block_theme_register_post_meta() {
	$args = [
		'auth_callback' => '__return_true',
		'type'          => 'boolean',
		'single'        => true,
		'show_in_rest'  => true,
	];
	register_meta( 'post', '_genesis_block_theme_hide_title', $args );
}
add_action( 'init', 'genesis_block_theme_register_post_meta' );


/**
 * Custom template tags for Genesis Block Theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer theme options.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Theme Updates.
 */
require get_template_directory() . '/inc/updates/updates.php';


/**
 * Add button class to next/previous post links.
 *
 * @return string
 */
function genesis_block_theme_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'genesis_block_theme_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'genesis_block_theme_posts_link_attributes' );


/**
 * Add layout style class to body.
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_block_theme_layout_class( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	}

	$featured_image = get_theme_mod( 'genesis_block_theme_featured_image_style', 'wide' );

	if ( $featured_image === 'wide' ) {
		$classes[] = 'featured-image-wide';
	}

	return $classes;
}
add_filter( 'body_class', 'genesis_block_theme_layout_class' );


/**
 * Add featured image class to posts.
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_block_theme_featured_image_class( $classes ) {
	global $post;

	$classes[] = 'post';

	// Check for featured image.
	$classes[] = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';

	$page_template = get_post_meta( $post->ID, '_wp_page_template', true );

	if ( $page_template === 'templates/template-wide-image.php' ) {
		$classes[] = 'has-wide-image';
	}

	return $classes;
}
add_filter( 'post_class', 'genesis_block_theme_featured_image_class' );


/**
 * Adjust the grid excerpt length for portfolio items.
 *
 * @return int
 */
function genesis_block_theme_search_excerpt_length() {
	return 40;
}


/**
 * Add an ellipsis read more link.
 *
 * @param string $more The original more.
 *
 * @return string
 */
function genesis_block_theme_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

	return ' &hellip;';
}
add_filter( 'excerpt_more', 'genesis_block_theme_excerpt_more' );


/**
 * Full size image on attachment pages.
 *
 * @param string $p The attachment HTML output.
 *
 * @return string|none
 */
function genesis_block_theme_attachment_size( $p ) {
	if ( is_attachment() ) {
		return '<p>' . wp_get_attachment_link( 0, 'full-size', false ) . '</p>';
	}
}
add_filter( 'prepend_attachment', 'genesis_block_theme_attachment_size' );


/**
 * Add a js class.
 */
function genesis_block_theme_html_js_class() {
	echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>' . "\n";
}
add_action( 'wp_head', 'genesis_block_theme_html_js_class', 1 );


/**
 * Replaces the footer tagline text.
 *
 * @return string
 */
function genesis_block_theme_filter_footer_text() {

	// Get the footer copyright text.
	$footer_copy_text = get_theme_mod( 'genesis_block_theme_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it.
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text.
		/* translators: %s: child theme author URL */
		$footer_text = sprintf( esc_html__( ' Theme by %1$s.', 'genesis-block-theme' ), '<a href="https://www.studiopress.com/" rel="noreferrer noopener">StudioPress</a>' );
	}

	return wp_kses_post( $footer_text );

}
add_filter( 'genesis_block_theme_footer_text', 'genesis_block_theme_filter_footer_text' );

/**
 * Check whether the current screen is a Gutenberg Block Editor, or not.
 *
 * @return bool
 */
function genesis_block_theme_is_block_editor() {

	// If the get_current_screen function doesn't exist, we're not even in wp-admin.
	if ( ! function_exists( 'get_current_screen' ) ) {
		return false;
	}

	// Get the WP_Screen object.
	$current_screen = get_current_screen();

	// Check to see if this version of WP_Screen has the is_block_editor_method.
	if ( ! method_exists( $current_screen, 'is_block_editor' ) ) {
		return false;
	}

	if ( ! $current_screen->is_block_editor() ) {
		return false;
	}

	// This is a Gutenberg Block Editor page.
	return true;
}

/*function generate_daily_summary() {
    $notes = new WP_Query([
        'post_type' => 'daily_notes',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'completion_status',
                'value' => '0',
                'compare' => '='
            ]
        ]
    ]);

    $note_data = [];
    if ($notes->have_posts()) {
        while ($notes->have_posts()) {
            $notes->the_post();
            $note_data[] = get_the_title() . ': ' . get_the_content();
        }
        wp_reset_postdata();
    } else {
        return 'No notes available.';
    }

    $api_key = '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';
    $prompt = "Summarize the following daily tasks:\n\n" . implode("\n", $note_data);
    $response = wp_remote_post('https://api.openai.com/v1/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ],
        'body' => json_encode([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 150,
        ]),
    ]);

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    return $data['choices'][0]['text'] ?? 'Summary not available.';
} */
function display_daily_summary() {
    $summary = generate_daily_summary();
    return '<div class="daily-summary">' . esc_html($summary) . '</div>';
}
add_shortcode('daily_task_summary', 'display_daily_summary');

function mark_task_complete() {
    if (isset($_POST['task_id']) && current_user_can('edit_post', $_POST['task_id'])) {
        update_post_meta($_POST['task_id'], 'completion_status', '1'); // 1 for completed
        wp_send_json_success('Task marked as complete.');
    } else {
        wp_send_json_error('Error marking task complete.');
    }
}
add_action('wp_ajax_mark_task_complete', 'mark_task_complete');

function enqueue_custom_js() {
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', ['jquery'], null, true);
   // wp_localize_script('custom-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_js');
// AJAX handler to update task status
function update_task_status() {
    if (!isset($_POST['post_id'], $_POST['status']) || !current_user_can('edit_posts')) {
        wp_send_json_error('Invalid request');
        return;
    }

    $post_id = intval($_POST['post_id']);
    $status = sanitize_text_field($_POST['status']);

    // Check if the category exists
    $term = get_term_by('name', $status, 'category');
    if ($term) {
        // Update the category of the post
        wp_set_post_terms($post_id, [$term->term_id], 'category');
        wp_send_json_success('Category updated');
    } else {
        wp_send_json_error('Category not found');
    }
}
add_action('wp_ajax_update_task_status', 'update_task_status');
add_action('wp_ajax_nopriv_update_task_status', 'update_task_status');
function add_custom_comment() {
    // Log incoming data for debugging
    error_log('Post ID: ' . print_r($_POST['post_id'], true));
    error_log('Comment: ' . print_r($_POST['comment'], true));

    // Verify required fields
    if (empty($_POST['post_id']) || empty($_POST['comment'])) {
        wp_send_json_error(['message' => 'Missing post ID or comment content.']);
        return;
    }

    // Sanitize input
    $post_id = intval($_POST['post_id']);
    $comment_content = sanitize_text_field($_POST['comment']);

    // Check if the post exists
    if (get_post_status($post_id) === false) {
        wp_send_json_error(['message' => 'Invalid post ID.']);
        return;
    }

    // Prepare the comment data
    $current_user = wp_get_current_user();
    $author = $current_user->exists() ? $current_user->display_name : 'Guest';

    $new_comment = [
        'content' => $comment_content,
        'author' => $author,
        'date' => current_time('mysql')
    ];

    // Get existing comments from post meta
    $existing_comments = get_post_meta($post_id, 'custom_comments', true);
    if (!is_array($existing_comments)) {
        $existing_comments = [];
    }

    // Add the new comment to the existing comments
    $existing_comments[] = $new_comment;
    $updated = update_post_meta($post_id, 'custom_comments', $existing_comments);

    if ($updated) {
        wp_send_json_success([
            'comment_content' => $comment_content,
            'comment_author' => $author
        ]);
    } else {
        wp_send_json_error(['message' => 'Failed to update comments.']);
    }
}
add_action('wp_ajax_add_custom_comment', 'add_custom_comment');
add_action('wp_ajax_nopriv_add_custom_comment', 'add_custom_comment');
function flush_rewrite_rules_on_init() {
    flush_rewrite_rules();
}
add_action('init', 'flush_rewrite_rules_on_init');
/*function ai_search_enhance($query) {
    // Only apply to front-end and the search query (not in admin)
    if (is_admin() || !isset($_GET['ai_search_query'])) {
        return $query;
    }

    $api_key = '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'; // Replace with your OpenAI API key

    // Capture the user query from the search form
    $user_query = isset($_GET['ai_search_query']) ? sanitize_text_field($_GET['ai_search_query']) : '';

    if (empty($user_query)) {
        return $query; // If no search query, don't modify the query
    }

    // Set up the AI prompt to interpret the search query
    $prompt = "Refine this search query for WordPress tasks: \"" . $user_query . "\". Specify if the user is searching for tasks by title, category, or any custom fields (like priority, due_date), and format the query appropriately.";

    // Make the request to the OpenAI API
    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', array(
        'method'    => 'POST',
        'body'      => json_encode(array(
            'model'     => 'gpt-3.5-turbo',
            'messages'  => array(
                array(
                    'role' => 'user',
                    'content' => $prompt
                )
            ),
            'max_tokens'=> 100, // Adjust length of response
        )),
        'headers'   => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ),
        'timeout'   => 15,
    ));

    // Check for errors in the API response
    if (is_wp_error($response)) {
        return $query; // If API call fails, return the original query
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Log the AI response for debugging
    error_log(print_r($data, true));

    // Get the AI's response and sanitize it
    if (isset($data['choices'][0]['message']['content']) && !empty($data['choices'][0]['message']['content'])) {
        $enhanced_query = sanitize_text_field($data['choices'][0]['message']['content']);

        // Process the AI-enhanced query:
        // Look for title, category, or other specific fields and adjust the WP query accordingly
        if (stripos($enhanced_query, 'title') !== false) {
            preg_match('/title\s*["\']([^"\']+)["\']/', $enhanced_query, $matches);
            if (isset($matches[1])) {
                set_query_var('ai_title', $matches[1]); // Store the title filter
            }
        }

        // Look for category
        if (stripos($enhanced_query, 'category') !== false) {
            preg_match('/category\s*["\']([^"\']+)["\']/', $enhanced_query, $category_matches);
            if (isset($category_matches[1])) {
                set_query_var('ai_category', $category_matches[1]); // Store the category filter
            }
        }

        // Look for custom fields (priority, due_date, etc.)
        if (stripos($enhanced_query, 'priority') !== false) {
            preg_match('/priority\s*["\']([^"\']+)["\']/', $enhanced_query, $priority_matches);
            if (isset($priority_matches[1])) {
                set_query_var('ai_priority', $priority_matches[1]); // Store the priority filter
            }
        }
        // More custom field checks can go here...
    }

    return $query;
}

add_action('pre_get_posts', 'ai_search_enhance');*/
// Create custom REST API endpoint for AI search
function ai_search_endpoint() {
    register_rest_route('ai-search/v1', '/query/', [
        'methods' => 'GET',
        'callback' => 'ai_search_callback',
        'permission_callback' => '__return_true', // Or use a more secure permission callback
    ]);
}
add_action('rest_api_init', 'ai_search_endpoint');

// Handle AI search requests
function ai_search_callback(WP_REST_Request $request) {
    $query = sanitize_text_field($request->get_param('query'));

    // Call the AI API (OpenAI in this case)
    $ai_response = ai_query($query);

    return new WP_REST_Response($ai_response, 200);
}
// Register shortcode for the AI search form
function ai_search_form() {
    ?>
    <form id="ai-search-form">
        <input type="text" id="ai-query" name="query" placeholder="Enter task query (e.g., 'high priority tasks')">
        <button type="submit">Search</button>
    </form>
    <div id="ai-search-results"></div>

    <script>
        document.getElementById('ai-search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = document.getElementById('ai-query').value;

            fetch(`/wp-json/ai-search/v1/query/?query=${query}`)
                .then(response => response.text())  // Get the response as text
                .then(text => {
                    if (text.trim() === '') {
                        throw new Error('Empty response from server');
                    }
                    return JSON.parse(text);  // Manually parse the text into JSON
                })
                .then(data => {
                    console.log(data);
                    document.getElementById('ai-search-results').innerHTML = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('ai-search-results').innerHTML = 'Error processing your request.';
                });
        });
    </script>
    <?php
}
add_shortcode('ai_search_form', 'ai_search_form');
function ai_query($query) {
    $api_key = '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';
    $api_url = 'https://api.openai.com/v1/chat/completions';

    // Prepare messages for OpenAI API
    $messages = [
        [
            'role' => 'system',
            'content' => "You are a helpful assistant. Return tasks by searching fields like 'title', 'notes', 'priority', 'due', or 'categories'."
        ],
        [
            'role' => 'user',
            'content' => $query
        ]
    ];

    $data = [
        'model' => 'gpt-4',
        'messages' => $messages,
        'max_tokens' => 100,
        'temperature' => 0.7,
    ];

    // Call OpenAI API
    $response = wp_remote_post($api_url, [
        'body' => json_encode($data),
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
        ],
    ]);

    if (is_wp_error($response)) {
        return ['error' => 'AI search failed'];
    }

    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);

    if (!$result) {
        return 'No tasks found';
    }

    $response_text = strtolower($result['choices'][0]['message']['content'] ?? 'No tasks found');

    // Query arguments
    $args = [
        'post_type' => 'task',
        'posts_per_page' => 10,
        's' => $query, // Search title and content
        'meta_query' => [],
        'tax_query' => [],
    ];

    // Check for specific fields in AI response
    if (preg_match('/(high|medium|low)\s*priority/i', $response_text, $matches)) {
        $priority = strtolower(trim($matches[1]));
        $args['meta_query'][] = [
            'key' => 'priority',
            'value' => $priority,
            'compare' => 'LIKE',
        ];
    }

    if (preg_match('/(?:due|date|deadline)[^\w]*(\d{4}-\d{2}-\d{2})/i', $response_text, $matches)) {
        $due_date = trim($matches[1]);
        $args['meta_query'][] = [
            'key' => 'due',
            'value' => $due_date,
            'compare' => '=',
        ];
    }

    if (preg_match('/category:([a-zA-Z0-9\s]+)/i', $response_text, $matches)) {
        $category = trim($matches[1]);
        $args['tax_query'][] = [
            'taxonomy' => 'category', // Replace with your taxonomy slug
            'field' => 'name',
            'terms' => $category,
            'operator' => 'LIKE',
        ];
    }

    // Run WP_Query
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $results = [];
        while ($query->have_posts()) {
            $query->the_post();

            $categories = get_the_terms(get_the_ID(), 'task_category');
            $category_names = $categories ? wp_list_pluck($categories, 'name') : [];

            $results[] = [
                'title' => get_the_title(),
                'content' => get_the_content(),
                'priority' => get_post_meta(get_the_ID(), 'priority', true),
                'categories' => $category_names,
                'due' => get_post_meta(get_the_ID(), 'due', true),
            ];
        }
        wp_reset_postdata();
        return $results;
    } else {
        return 'No tasks found matching your query.';
    }
}



