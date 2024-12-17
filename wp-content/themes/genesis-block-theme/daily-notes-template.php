<?php
/* Template Name: Daily Notes */
get_header();

$query = new WP_Query([
    'post_type' => 'daily_notes',
    'posts_per_page' => -1,
]);

if ($query->have_posts()):
    while ($query->have_posts()): $query->the_post(); ?>
        <div class="daily-note">
            <h2><?php the_title(); ?></h2>
            <p><?php the_field('note_content'); ?></p>
            <p><?php the_content(); ?></p>
            <p><strong>Reminder:</strong> <?php the_field('reminder_date'); ?></p>
            <p>Status: <?php echo get_field('completion_status') ? 'Completed' : 'Incomplete'; ?></p>
        </div>
    <?php endwhile;
    wp_reset_postdata();
else:
    echo 'No notes found.';
endif;
?>
<div class="daily-note">
    <h2><?php the_title(); ?></h2>
    <p><?php the_field('note_content'); ?></p>
    <p><strong>Reminder:</strong> <?php the_field('reminder_date'); ?></p>
    <p>Status: <?php echo (get_field('completion_status') == '1') ? 'Completed' : 'Pending'; ?></p>
    <?php if (get_field('completion_status') != '1'): ?>
        <button class="mark-complete" data-task-id="<?php echo get_the_ID(); ?>">Mark as Complete</button>
    <?php endif; ?>
   
</div>

<?php get_footer(); ?>