<!DOCTYPE html>
<html>
<?php
        include(APP_DIR."/config/link.php");
 ?>

	<head>
		<title>人生咨询平台</title>

		<script src="<?php echo $site_url;?>public/js/jquery1.9.js"></script>
        <script src="<?php echo $site_url;?>public/js/dialog.js"></script>
        <script src="<?php echo $site_url;?>public/js/bootstrap.js"></script>
        <script src="<?php echo $site_url;?>public/js/NovComet.js"></script>
        <!--<script src="/public/js/layer/layer.min.js"></script>-->
        <script src="<?php echo $site_url;?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script src="<?php echo $site_url;?>public/js/check.js"></script>

		<!--<?= $this->tag->stylesheetLink('css/bootstrap.min.css') ?>-->
		<!--<?= $this->tag->stylesheetLink('css/style.css') ?>-->
		<!--<?= $this->tag->stylesheetLink('css/main.css') ?>-->
		<!--<?= $this->tag->stylesheetLink('css/print.css') ?>-->
		<!--<?= $this->tag->stylesheetLink('css/index.css') ?>-->
		<!--<?= $this->tag->stylesheetLink('css/add/center.css') ?>-->
		<!--<?= $this->tag->stylesheetLink('css/add/shop.css') ?>-->
        <!--<?= $this->tag->stylesheetLink('css/jquery-ui.min.css') ?>-->


        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/print.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/index.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/add/center.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/add/prophet.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/jquery-ui.min.css">
           <?php if(isset($ischat) && $ischat == 1){?>
 		<link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>public/css/chat.css">
 		 <?php }?>
	</head>
	<body>
		<?= $this->getContent() ?>
	</body>
    <script type="text/javascript">

        $(document).ready(function() {

            $("#new_message").hide();
            NovComet.seturl("<?= $site_url ?>message/realtime");
            NovComet.subscribe('customAlert', function(data){
                $("#new_message").show();

                shake($("#new_message"),"message_alert_shade",10);
                NovComet.publish('customAlert');
            });
            NovComet.run();

        });
        function shake(element,className,times){
            var i = 0,
                    t = false ,
                    o = element.attr("class"),
                    c = "",
                    times = times||2;

            if(t) return;

            t = setInterval(function(){
                i++;
                c = i%2 ? o + ' ' + className : o;
                element.attr("class",c);

                if(i==2*times){
                    clearInterval(t);
                    element.removeClass(className);
                }
            },500);

        };
    </script>
</html>