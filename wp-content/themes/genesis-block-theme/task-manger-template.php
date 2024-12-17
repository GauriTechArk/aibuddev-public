<?php
/* Template Name: Task Manager */
get_header();
if (function_exists('acf_form')) {
    acf_form(array(
        'post_id' => 'new_post',
        'new_post' => array(
            'post_type' => 'tasks',
            'post_status' => 'publish'
        ),
        'post_title' => true,
        'submit_value' => 'Add Task'
    ));
}
add_shortcode('daily_task_summary', 'display_daily_task_summary');
function display_daily_task_summary() {
    return '<h2>Today\'s Task Summary</h2><p>' . get_daily_task_summary() . '</p>';
}
if ($status != 'Completed') {
    echo '<form method="post" action="">';
    echo '<input type="hidden" name="task_id" value="' . get_the_ID() . '">';
    echo '<input type="submit" name="complete_task" value="Mark as Complete">';
    echo '</form>';
}

get_footer();
?>