<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAANwjODFfemRfMs6O6dPuP8xS0SiBsXWf7z3rHAX3D5eOhC_oKfxS41R0axKkpcqIYOUT1Zs_O7TurRg" type="text/javascript"></script>
<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-msw&key=ABQIAAAANwjODFfemRfMs6O6dPuP8xS0SiBsXWf7z3rHAX3D5eOhC_oKfxS41R0axKkpcqIYOUT1Zs_O7TurRg" type="text/javascript"></script>
<style type="text/css">@import url("http://www.google.com/uds/css/gsearch.css");</style>
<script type="text/javascript">window._uds_msw_donotrepair = true;</script>
<script src="http://www.google.com/uds/solutions/mapsearch/gsmapsearch.js?mode=new" type="text/javascript"></script>
<style type="text/css">@import url("http://www.google.com/uds/solutions/mapsearch/gsmapsearch.css");</style>
<script type="text/javascript">
    function LoadMapSearchControl() {
    var options = {
          zoomControl : GSmapSearchControl.ZOOM_CONTROL_ENABLE_ALL,
          title : "Property Details",
          url : "<?php the_permalink(); ?>",
          idleMapZoom : GSmapSearchControl.ACTIVE_MAP_ZOOM,
          activeMapZoom : GSmapSearchControl.ACTIVE_MAP_ZOOM
          }		
    new GSmapSearchControl(
          document.getElementById("mapsearch"),
          "<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?>, <?php zipcode(); ?>",
          options
          );
    }
    GSearch.setOnLoadCallback(LoadMapSearchControl);
</script>
<div id="location" class="right">
    <div id="mapsearch">Loading...</div>
</div>