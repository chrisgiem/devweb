<?php
/**
 * Template for displaying content of Recent Courses widget.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/widgets/recent-courses/default.php.
 *
 * @author  ThimPress
 * @category Widgets
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $courses ) ) {
	esc_html_e( 'No courses', 'airi' );

	return;
}

global $post;
//widget instance
$instance = $this->instance;
?>

<div class="archive-course-widget-outer airi-course <?php esc_attr( $instance["css_class"] ); ?>">

    <div class="widget-body clearfix">
    <div class="row">
		<?php foreach ( $courses as $course_id ) {

			$post = get_post( $course_id );
			setup_postdata( $post );
			$course = learn_press_get_course( $course_id );

			?>
            
            <div class="course-entry col-md-4">
                <div class="course-entry-inner">
                    <!-- course thumbnail -->
                    <?php if ( ! empty( $instance['show_thumbnail'] ) && $image = $course->get_image( 'large' ) ) { ?>
                        <div class="course-cover">
                            <a href="<?php echo $course->get_permalink(); ?>">
                                <?php echo $image; ?>
                            </a>
                        </div>
                    <?php } ?>

                    <div class="course-detail">
                        <!-- course title -->
                        <h3 class="course-title"><a href="<?php echo get_the_permalink( $course->get_id() ) ?>"><?php echo $course->get_title(); ?></a></h3>

                        <!-- instructor -->
                        <?php if ( ! empty( $instance['show_teacher'] ) ) { ?>
                            <div class="course-meta-field course-instructor"><?php echo esc_html( 'By', 'airi' ); ?>&nbsp;<?php echo $course->get_instructor_html(); ?></div>
                        <?php } ?>

                        <div class="course-meta-data">                           

                            <!-- price -->
                            <?php if ( ! empty( $instance['show_price'] ) ) { ?>
                                <div class="course-meta-field"><?php echo $course->get_price_html(); ?></div>
                            <?php } ?>

                            <!-- number students -->
                            <?php if ( ! empty( $instance['show_enrolled_students'] ) ) { ?>
                                <div class="course-student-number course-meta-field">
                                    <i class="fa fa-users"></i><?php echo $course->get_users_enrolled(); ?>
                                </div>
                            <?php } ?>

                            <!-- number lessons -->
                            <?php if ( ! empty( $instance['show_lesson'] ) ) { ?>
                                <div class="course-lesson-number course-meta-field">
                                    <?php
                                    $lesson_count = $course->count_items( LP_LESSON_CPT );
                                    echo $lesson_count > 1 ? sprintf( __( '%d lessons', 'airi' ), $lesson_count ) : sprintf( __( '%d lesson', 'airi' ), $lesson_count ); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
		<?php } ?>

        </div>
    </div>

	<?php wp_reset_postdata();?>

</div>