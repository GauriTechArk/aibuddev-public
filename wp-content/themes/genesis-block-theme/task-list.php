<?php
/* Template Name: Task List */
get_header();

$query = new WP_Query([
    'post_type' => 'task',
    'posts_per_page' => -1,
    'order' => 'ASC'
]);

if ($query->have_posts()):
    while ($query->have_posts()): $query->the_post(); 
        $post_id = get_the_ID();
        $categories = get_the_terms($post_id, 'category');
        $current_status = !empty($categories) && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Pending';
        ?>
        <div class="daily-note" data-post-id="<?php echo $post_id; ?>">
            <h2><?php the_title(); ?></h2>
            <p><?php echo get_the_content(); ?></p>
            
            <!-- Dropdown for status -->
            <p><strong>Status:</strong></p>
            <select class="status-select">
                <option value="Pending" <?php selected($current_status, 'Pending'); ?>>Pending</option>
                <option value="In Progress" <?php selected($current_status, 'In Progress'); ?>>In Progress</option>
                <option value="Completed" <?php selected($current_status, 'Completed'); ?>>Completed</option>
            </select>

            <p><strong>Priority:</strong> <?php the_field('priority'); ?></p>
            <p><strong>Due Date:</strong> <?php the_field('due_date'); ?></p>

            <!-- View Task Button -->
            <a href="<?php echo get_permalink($post_id); ?>" class="view-task-button">View Task</a>
        </div>
    <?php endwhile;
    wp_reset_postdata();
else:
    echo 'No tasks found.';
endif;
?>

<!-- Include AJAX script -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.status-select').on('change', function() {
            var postId = $(this).closest('.daily-note').data('post-id');
            var statusValue = $(this).val();
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'update_task_status',
                    post_id: postId,
                    status: statusValue
                },
                success: function(response) {
                    if (response.success) {
                        alert('Status updated successfully.');
                    } else {
                        alert('Failed to update status.');
                    }
                }
            });
        });
    });
</script>
<?php get_footer(); ?>
