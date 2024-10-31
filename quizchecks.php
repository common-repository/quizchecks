<?php
/**
  * Plugin Name: 	Quizchecks
  * Author: 		Quizchecks
  * Description: 	Intelligent Qnline Quiz Software for creating quizzes, tests, analyzes, application, sweepstakes and much more. Only with Quizchecks will visitors get a personal (email) answer based on their given quiz-answers.
  * Text Domain: 	quizchecks
  * Author URI: 	https://quizchecks.com
  * License: 		GPLv2
  * Version: 		1.0.2
  */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!defined('QUIZCHECKS_PLUGIN_VERSION')) {
  define('QUIZCHECKS_PLUGIN_VERSION', '1.0.0');
}

if (!class_exists('quizchecks')) {

    class quizchecks {


        public function __construct() {
            // add_action( 'admin_init', array($this, 'quizchecks_script'));
            add_action('admin_menu', array($this, 'quizchecks_submenu_page' ));

			      add_shortcode('quizchecks', array($this, 'quizchecks_layout' ));
        }


        public function quizchecks_submenu_page() {

          $icon = esc_url(plugins_url('assets/img/Quizchecks-Icon-22x22.png', __FILE__));
			
            add_menu_page(
              'Quizchecks', // page <title>Title</title>
              'Quizchecks', // menu link text
              'manage_options', // capability to access the page
              'quizchecks-slug', // page URL slug
              array( $this, 'quizchecks_options' ), // callback function /w content
             // 'dashicons-star-half', // menu icon
              $icon,
              125 // priority
            );
	
        }

	
        public function quizchecks_options() {
          if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Error! Only site admin can perform this operation' );
          }
      		?>
          <div class="clearfix"></div>
          <div class="box">
          <h1>Quizchecks</h1>
          <h3>Create intelligent online quizzes & tests with personalized results</h3>
          <div style="width:600px;">
            <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/533208608?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Quizchecks Demo 2021 - Short - EN"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
          </div>
          <p>
            <ol>
              <li>To get started, create your account on <a href="https://www.quizchecks.com/" target="_blank">www.quizchecks.com</a> first and create your quiz.</li>
              <li>Copy your "Quiz-URL" from your Quizchecks dashboard and paste below. <br>Following URL you can paste to see a Demo: https://app.quizchecks.com/quiz/60299808cf9816680eca373c/view
              </li>
              <li>Simply implement the short code on your website.</li>
            </ol>
          </p>
          <br>
          <p><strong>Please enter here your Quizchecks Quiz-URL:</strong></p>
            <form method="POST">
              <input type="text" name="url" style="width:800px;padding:10px;">
              <br>
              <input type="submit" style="width:800px;padding:10px;margin-top:10px;" name="senden" value="Generate short code">
            </form>
            <?php 
            if (esc_url($_POST['url']) != ""){
            ?>
              <p><strong>Copy the short code and paste it into the page:</strong></p> 
			        <input type="text" style="width:800px;padding:10px;" value='[quizchecks url="<?php echo esc_url($_POST['url']);?>" width="100%" height="100%"]'>
            <?php 
            }
            ?>
            <br><br>
            <p>If you need any kind of support for the creation or implementation, please don’t hesitate to contact us: <a href="https://app.quizchecks.com/support" target="_blank">https://app.quizchecks.com/support</a>
            <br><br>
            Thank you for using Quizchecks!
            <br>
            <strong>Your Quizchecks Team</strong>
          </div>
			  <?php
      	}


        public function quizchecks_layout($atts){

          $mywidth = esc_attr($atts['width']);
          $myheight = esc_attr($atts['height']);
          $myurl = esc_attr($atts['url']);

          if($mywidth == ""){
            $boxwidth = "100%";
          } else {
            $boxwidth = $mywidth;
          }

          if($myheight == ""){
            $boxheight = "100%";
          } else {
            $boxheight = $myheight;
          }
          
          if ($myurl == ""){
            $url = "60316874cf9816680eca4392"; // Demo Quiz
          } else {
            $url = parse_url($myurl);
            $keydata = explode("/",$url['path']); 
            $key = $keydata[2];
          }
        	
          ob_start();
          ?>

          <style type="text/css">
            .quiz-iframe {
              background:url(https://app.quizchecks.com/static/media/loading-icon.b6a1217a.gif) center center no-repeat;
            }
            @media screen and (max-width: 1200px) {
              .quiz-iframe {
                background:url(https://app.quizchecks.com/static/media/loading-icon-mobile.79930893.gif) center center no-repeat;
              }
            }

            .quiz-iframe__element {
              display: block;
              border: none;
              overflow:hidden;
            }
          </style>

          <script
              defer
              type="text/javascript"
              src="https://app.quizchecks.com/js/embed-quiz.min.js?v=1642966041228"
              data-iframe-script="true"
              data-quiz-id="<?php echo esc_attr($key); ?>"></script>

          <div class="quiz-iframe">
            <iframe
              id="<?php echo esc_attr($key); ?>"
              class="quiz-iframe__element"
              style="min-height:300px;opacity:0;"
              width="<?php echo esc_attr($boxwidth); ?>"
              height="<?php echo esc_attr($boxheight); ?>"
              data-scroll-offset="70"
              frameborder="0"
              scrolling="no"
              allowTransparency="true"
              src="https://app.quizchecks.com/quiz/<?php echo esc_attr($key); ?>"></iframe>
          </div>

        <?php
          return ob_get_clean();
        }
    }
}

new quizchecks();
