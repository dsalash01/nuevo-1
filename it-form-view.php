<script type='text/javascript'>
  var jq = jQuery.noConflict();
  jq(document).ready(function() {
    incaTrailProcess();
  });
  function incaTrailProcess() {
    jq('#it-calendar').html(" ");
    jq('#it-calendar').addClass('loader');
    jq.ajax({
      url: '<?php echo $plugins_url = plugins_url(); ?>/wp-inca-trail/it-form.php',
      type: 'post',
      data: jq('#it-form').serialize(),
      beforeSend: function(data){
        console.log(data);
      },
      success:
        function(request, settings) {
          jq('#it-calendar').html(request);
          jq('#it-calendar').removeClass('loader');
        }
    });
  }
</script>
<div id='inca-trail-calendar'>
  <div class="it-form-content">
    <form id='it-form' action='#' method='post'>
    <?php
      require_once ('config.inc');
      $month = 0;
      $year = 0;
      $place = 0;
      shortcode_atts( array(
          'it_month' => '',
          'it_year' => '',
          'it_place' => '',
      ), $atts );

      $month = $atts['it_month'];
      $year = $atts['it_year'];
      $place = $atts['it_place'];

      $lang = languageSmall(get_bloginfo('language'));
     ?>
      <input name="incatrail_lang" value="<?php echo get_bloginfo('language'); ?>" type="hidden">
      <p class="it-text-center">
        <select name="incatrail_place" id="incatrail_place" class="place" onchange="incaTrailProcess()">
        <?php echo incaTrailToOption($lang,$place); ?>
        </select>
        <select name="incatrail_month" id="incatrail_month" class="mes" onchange="incaTrailProcess()">
        <?php echo monthToOption($lang,$month); ?>
        </select>
      <select name="incatrail_year" onchange="incaTrailProcess()">
          <?php echo  yearToOption($year); ?>
      </select>
      </p>
    </form>
  </div>
  <div id="it-calendar" class="loader">
  </div>
</div>