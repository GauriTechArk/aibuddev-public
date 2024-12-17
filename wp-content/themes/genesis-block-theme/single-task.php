<?php
/* Template for displaying single task */
get_header();

if (have_posts()):
    while (have_posts()): the_post(); 
        $post_id = get_the_ID();
        $categories = get_the_terms($post_id, 'category');
        $current_status = !empty($categories) && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Pending';
        ?>
        <div class="single-task" data-post-id="<?php echo $post_id; ?>">
            <h1><?php the_title(); ?></h1>
            <p><?php the_content(); ?></p>

            <p><strong>Status:</strong></p>
            <select class="status-select">
                <option value="Pending" <?php selected($current_status, 'Pending'); ?>>Pending</option>
                <option value="In Progress" <?php selected($current_status, 'In Progress'); ?>>In Progress</option>
                <option value="Completed" <?php selected($current_status, 'Completed'); ?>>Completed</option>
            </select>

            <p><strong>Priority:</strong> <?php the_field('priority'); ?></p>
            <p><strong>Due Date:</strong> <?php the_field('due_date'); ?></p>

            
        </div>

        <!-- Custom Comments Section -->
        <div class="task-comments">
            <h3>Comments</h3>
            <ul id="comment-list">
                <?php
                // Retrieve custom comments stored in post meta
                $comments = get_post_meta($post_id, 'custom_comments', true);
                if ($comments && is_array($comments)) {
                    foreach ($comments as $comment) {
                        echo '<li>' . esc_html($comment['content']) . ' - <em>' . esc_html($comment['author']) . '</em></li>';
                    }
                }
                ?>
            </ul>

            <!-- Input field for adding comments -->
            <input type="text" id="new-comment" placeholder="Add a comment and press Enter..." data-postid="<?php echo $post_id; ?>">
        </div>
        <!-- Back to Task List -->
            <a href="<?php echo site_url('/task-list'); ?>" class="back-button">Back to Task List</a>
    <?php endwhile;
else:
    echo 'Task not found.';
endif;

get_footer();
?>

<!-- Include AJAX script for adding comments -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    // Handle status dropdown change
    $('.status-select').on('change', function() {
        var postId = $(this).closest('.single-task').data('post-id');
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

    // Handle comment submission on Enter key press
   // Handle comment submission on Enter key press
$('#new-comment').on('keypress', function(e) {
    if (e.which === 13) {
        e.preventDefault();
        var commentContent = $(this).val().trim();
        var postId = $(this).data('postid');

        console.log("Post ID: ", postId);  // Log Post ID
        console.log("Comment Content: ", commentContent);  // Log Comment Content

        if (commentContent !== '') {
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'add_custom_comment',
                    post_id: postId,
                    comment: commentContent
                },
                success: function(response) {
                    console.log(response); // Log the response from the PHP handler
                    if (response.success) {
                        // Append the new comment to the list
                        $('#comment-list').append('<li>' + response.data.comment_content + ' - <em>' + response.data.comment_author + '</em></li>');
                        $('#new-comment').val(''); // Clear the input
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('AJAX request failed: ' + error);
                }
            });
        }
    }
});
});
</script>