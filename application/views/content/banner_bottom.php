<div id="banner-bottom">
    <?php
        $appconfig = $app_config->row();
    ?>
    <div id="banner-bottom-left">
        <p class="banner-title">Related Links :</p>
        <a class="banner-link" href="http://www.telkom.co.id">Telkom Indonesia</a> <br/><br/>
        <a class="banner-link" href="http://portal.telkomspeedy.com">Speedy Portal</a>
    </div>
    <div id="banner-bottom-mid">
        <p class="banner-title">Technical Support : </p>
        <a class="banner-link" href="mailto:<?php echo $appconfig->tech_support; ?>"><?php echo $appconfig->tech_support; ?></a>
    </div>
    <div id="banner-bottom-right">
        <p class="banner-title">Powered By :</p>
        <img id="pic" src="<?php echo base_url(); ?>css/telkom-small.png" />
    </div>
    
    
</div>
