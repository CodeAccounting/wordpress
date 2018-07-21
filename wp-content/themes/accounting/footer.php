 
  <?php 
  global $anps_options_data;
  $coming_soon = get_option('coming_soon', '0');
  if((!$coming_soon || $coming_soon=="0") || is_super_admin()) {
    get_sidebar( 'footer' );
  }
  ?>
 
  <?php global $anps_parallax_slug;
  if (count($anps_parallax_slug)>0) : ?>
  <script>
      jQuery(function($) {
          <?php for($i=0;$i<count($anps_parallax_slug);$i++) : ?>
              $("#<?php echo esc_js($anps_parallax_slug[$i]); ?>").parallax("50%", 0.6);
          <?php endfor; ?>
      });
  </script>
  <?php endif;?>
  <?php  if(anps_get_option($anps_options_data, 'preloader')=="on") : ?>
  <script>
    jQuery(function ($) {
      $("body").queryLoader2({
        backgroundColor: "#fff",
        barColor: "333",
          barHeight: 0,
        percentage: true,
          onComplete : function() {
            $(".site-wrapper, .colorpicker").css("opacity", "1");
          }
      });
    });
  </script>
  <?php endif; ?>


<div id="scrolltop" class="fixed scrollup"><button href="#"  title="<?php esc_html_e('Scroll to top', 'accounting'); ?>"><i class="fa fa-angle-up"></i></button></div>
<input type="hidden" id="theme-path" value="<?php echo get_template_directory_uri(); ?>" />


<?php wp_footer(); ?>
<!-- Google Analytics code -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73415466-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Google Adwords Code for 1&amp;1 Conversion Page
In your html page, add the snippet and call
goog_report_conversion when someone clicks on the
chosen link or button. -->

<script type="text/javascript">
  /* <![CDATA[ */
  goog_snippet_vars = function() {
    var w = window;
    w.google_conversion_id = 934539956;
    w.google_conversion_label = "lGRHCI6Y63MQtOXPvQM";
    w.google_conversion_value = 1.00;
    w.google_conversion_currency = "USD";
    w.google_remarketing_only = false;
  }
  // DO NOT CHANGE THE CODE BELOW.
  goog_report_conversion = function(url) {
    goog_snippet_vars();
    window.google_conversion_format = "3";
    var opt = new Object();
    opt.onload_callback = function() {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  }
  var conv_handler = window['google_trackConversion'];
  if (typeof(conv_handler) == 'function') {
    conv_handler(opt);
  }
}
/* ]]> */
</script>
<script type="text/javascript"
  src="//www.googleadservices.com/pagead/conversion_async.js">
</script>

</body>
</html>