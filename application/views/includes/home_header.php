<!DOCTYPE >
<html>
    <head>
        <title><?php echo $title; ?> - eOffice</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main_style.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/home_style.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/drop_style.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ui-darkness/jquery-ui-1.10.3.custom.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/cssmenu/style.css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.json-2.4.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.js"></script>

    </head>

    <body onload="setInterval('updateClock()',200);">
        <div id="header">
            <p>e-Office System</p>
        </div>