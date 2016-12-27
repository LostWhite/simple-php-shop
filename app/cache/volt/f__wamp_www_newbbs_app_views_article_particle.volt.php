<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>/public/css/usb.css">

<script charset="utf-8" src="<?= $site_url ?>public/js/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="<?= $site_url ?>public/js/kindeditor/zh_CN.js"></script>
<link rel="stylesheet" href="<?= $site_url ?>public/css/default/default.css" />
<script>
    var editor;
    KindEditor.ready(function(K) {

        editor = K.create('textarea[name="sub_title"]', {
		        resizeType : 1,
			    allowPreviewEmoticons : false,
			    allowImageUpload : false,
			    items : [
				    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				    'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	    });
        editor = K.create('textarea[name="page_text"]', {
		        resizeType : 1,
			    allowPreviewEmoticons : false,
			    allowImageUpload : false,
			    items : [
				    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				    'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	    });
    });

    $(function(){
        var flg =  document.getElementById('flg').value;
        if(flg != 0){
            alert(flg);
        }
    })

</script>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<ol id="pan">
				<li><a href="<?= $site_url ?>">返回首页</a></li>
				<li>预测师随笔</li>
			</ol>
			<div id="main_inner">
				<div id="top_detail">
<h2 id="title_co_kyouhan">预测师随笔</h2>
<div id="co_kyouhan_table">
<div class="desk">
<table class="opu">
<tbody>
        <?php if (isset($flg)) { ?>
            <input type="hidden" name="flg" id="flg" value="<?= $flg ?>">
        <?php } else { ?>
            <input type="hidden" name="flg" id="flg" value="0">
        <?php } ?>

        <?= $this->tag->form([$site_url . 'article/particle', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
            
			
			<tr>
			<p><div>文章标题：</div></p><td><?= $form->render('title', ['style' => 'width:600px;height:30px;']) ?></td></tr>
            <label class="hide" style="color: red;display:block">
                <?php if (isset($title_err)) { ?>
                    <?= $title_err ?>
                <?php } ?>
            </label>
            <br>

            副标题：<?= $form->render('sub_title', ['style' => 'width:700px;height:30px;visibility:hidden;']) ?>

			文章内容：<?= $form->render('page_text', ['style' => 'width:800px;height:400px;visibility:hidden;']) ?>
			<label class="hide" style="color: red;display:block">
                <?php if (isset($page_text_err)) { ?>
                    <?= $page_text_err ?>
                <?php } ?>
            </label>

            <p class="btn_login" style="text-align:center;">
            <?= $this->tag->submitButton(['提交', 'class' => 'btn btn-primary']) ?>
            </p>
		</form>
			</tbody>
			</table>
			</div>

</div>

</div>
			</div>
		</section>

		<section id="r_clm">
			
			<h4>Menu1</h4>
			<ul id="info">
				<li><a href="<?= $site_url ?>user">个 人 中 心<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
                    <li><a href="<?= $site_url ?>prophet/index">预 测 师 管 理<span></span></a></li>
                     <li><a href="<?= $site_url ?>chat/index">交 谈 管 理 <span></span></a></li>
                <?php }else{?>
                    <li><a href="<?= $site_url ?>user/apply">申 请 预 测 师<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>reward/search">赏 金 求 测 大 厅<span></span></a></li>
				<li><a href="<?= $site_url ?>money/recharge/1">购 买 算 卦 币<span></span></a></li>
                <li><a href="<?= $site_url ?>reward/public">发 布 赏 金 求 测<span></span></a></li>
                <li><a href="">百 家 争 鸣<span></span></a></li>
                <li><a href="<?= $site_url ?>order/orders">我 的 订 单<span></span></a></li>
                <!--li><a href="<?= $site_url ?>chat/teacher">试 测 验 证<span></span></a></li-->
				<li><a href="<?= $site_url ?>prophet/browse">预 测 师 随 笔<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
				    <li><a href="<?= $site_url ?>article/particle">写 随 笔<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>message/information?status=1">意 见 反 馈<span></span></a></li>
			</ul>

	<!-- JiaThis Button BEGIN -->
<div class="jiathis_style_24x24">
	
	<a class="jiathis_button_tsina"></a>
	<a class="jiathis_button_tqq"></a>
	<a class="jiathis_button_weixin"></a>
	
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
	<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->

		</section>
		<br clear="all">

	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>