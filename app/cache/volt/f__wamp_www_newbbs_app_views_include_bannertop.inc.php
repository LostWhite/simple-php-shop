
<style>
    <!--
    * {margin: 0;padding:0;}
    body {background: #222;}
    ol {list-style: none;}
    img {border: 0 none;}
    #slider {
        width: 100%;
        height: 180px;
        overflow: hidden;
        position: relative;
        margin: 0em auto;
    }
    #slider .player {
        position: absolute;
        top: 0px;
        left: 0px;
    }
    #slider .player li {
        width: 975px;
        height: 180px;
    }
    #slider .btns {
        position: absolute;
        right: 10px;
        bottom: 5px;
        height: 30px;
    }
    #slider .btns li {
        font: 13px Tahoma, Arial, 宋体, sans-serif;
        float: left;
        margin: 0 3px;
        border: 1px solid #F60;
        background-color: #FFF;
        color: #CC937A;
        opacity: .8;
        cursor: pointer;
        width: 20px;
        height: 20px;
        line-height: 19px;
        text-align: center;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
    }
    #slider .btns li.active {
        background: #F60;
        color: #FFF;
        font-weight: bold;
        opacity: 1;
    }
    -->
</style>

<script>
    //<![CDATA[
    function rcd(id) {
        return document.getElementById(id);
    };
    function getByClass(className, context) {
        /*
         * 功能说明：
         * 传入类名、节点名（默认document），获取context下类名为classNa的节点
         */
        context = context || document;
        if(context.getElementsByClassName) {
            return context.getElementsByClassName(className);
        } else {
            var nodes = [];
            var tags = context.getElementsByTagName('*');
            for(var i=0, len=tags.length; i<len; i++) {
                if(hasClass(tags[i], className)) {
                    nodes.push(tags[i]);
                }
            }
            return nodes;
        }
    }
    function hasClass(node, className) {
        /*
         * 功能说明：
         * 传入节点及一个类名，检查该节点是否含有传入的类名
         */
        var names = node.className.split(/\s+/);
        for(var i=0, len=names.length; i<len; i++) {
            if(names[i] == className) {
                return true;
            }
        }
        return false;
    }
    function animate(o,start,alter,dur,fx) {
        /*
         * 功能说明：
         * 设置动画
         * o:要设置动画的对象
         * start:开始的对象
         * alter:总的对象
         * dur:动画持续多长时间
         * fx:动画类型
         */
        var curTime=0;
        var t=setInterval(function () {
            if (curTime>=dur) clearInterval(t);
            for (var i in start) {
                o.style[i]=fx(start[i],alter[i],curTime,dur)+"px";
            }
            curTime+=40;
        },40);
        return function () {
            clearInterval(t);
        };
    }
    var Tween = {
        /*
         * 功能说明：
         * 加速运动
         * curTime:当前时间,即动画已经进行了多长时间,开始时间为0
         * start:开始值
         * alter:总的变化量
         * dur:动画持续多长时间
         */
        Linear:function (start,alter,curTime,dur) {return start+curTime/dur*alter;},//最简单的线性变化,即匀速运动
        Quad:{//二次方缓动
            easeIn:function (start,alter,curTime,dur) {
                return start+Math.pow(curTime/dur,2)*alter;
            },
            easeOut:function (start,alter,curTime,dur) {
                var progress =curTime/dur;
                return start-(Math.pow(progress,2)-2*progress)*alter;
            },
            easeInOut:function (start,alter,curTime,dur) {
                var progress =curTime/dur*2;
                return (progress<1?Math.pow(progress,2):-((--progress)*(progress-2) - 1))*alter/2+start;
            }
        },
    };
    function Player(btns, scrollContent, imgHeight, timeout, hoverClass) {
        /*
         * btns:按钮，类型是数组
         * scrollContent:摇滚动的块，一个DOM对象，这里是ol
         * imgHeight:每一张图片的高度，当然，如果想改成左右滚动，这里传入每一张图片的宽，唯一需要注意的是每一张图片宽高必须相同，图片数量可调整
         * timeout:切换速度快慢，默认为1.5ms
         * hoverClass:每一个按钮激活时的类名
         */
        hoverClass = hoverClass || 'active';
        timeout = timeout || 1500;
        this.btns = btns;
        this.scrollContent = scrollContent;
        this.hoverClass = hoverClass;
        this.timeout = timeout;
        this.imgHeight = imgHeight;
        var _this = this;
        for(var i=0; i<btns.length; i++) {
            this.btns[i].index = i;
            btns[i].onmouseover = function() {
                _this.stop();
                _this.invoke(this.index);
            }
            btns[i].onmouseout = function() {
                _this.start();
            }
        }
        this.invoke(0);
    }
    Player.prototype = {
        constructor : Player,
        start : function() {
            var _this = this;
            this.stop();
            this.intervalId = setInterval(function() {
                _this.next();
            }, this.timeout);
        },
        stop: function() {
            clearInterval(this.intervalId);
        },
        invoke: function(n) {
            this.pointer = n;
            if(this.pointer >= this.btns.length) {
                this.pointer = 0;
            }
            this.clearHover();
            this.btns[this.pointer].className = this.hoverClass;
            //this.scrollContent.style.top = parseInt(-this.imgHeight * this.pointer) + 'px';
            var startVal = parseInt(this.scrollContent.style.top) || 0;
            var alterVal = (parseInt(-startVal - this.imgHeight * this.pointer));
            this.animateIterval && this.animateIterval();//修正快速切换时闪动
            this.animateIterval=animate(this.scrollContent, {top : startVal},{top : alterVal}, 2000, Tween.Quad.easeOut);
            //这里默认设置每张图滚动的总时间是1s
        },
        next: function() {
            this.invoke(this.pointer + 1);
        },
        clearHover: function() {
            for(var i=0; i<this.btns.length; i++) {
                this.btns[i].className = '';
            };
        }
    }
    window.onload = function() {
        var btns = getByClass('btns', $('slider'))[0].getElementsByTagName('li');
        var player = getByClass('player', $('slider'))[0];
        var player = new Player(btns, player, 180, 20000, undefined);
        player.start();
        //player.invoke(2);
    }
    //]]>
</script>
<div id="slider" class="main_gif">
    <ol class="player">
        <?php foreach ($img_no as $no) { ?>
            <li><a href=""><img src="<?php echo $site_url; ?>img/file/01_<?= $no ?>.jpg" title="" width="975px" height="180px"></a></li>
        <?php } ?>
        <!--li><a href="http://127.0.0.1:8080/item/519"><img src="<?php echo $site_url; ?>img/file/01_3.jpg" title="" width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/515"><img src="<?php echo $site_url; ?>img/file/01_1.jpg" title=""  width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/516"><img src="<?php echo $site_url; ?>img/file/01_0.jpg" title=""  width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/511"><img src="<?php echo $site_url; ?>img/file/01_4.jpg" title=""  width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/500"><img src="<?php echo $site_url; ?>img/file/01_2.jpg" title="Denture World" id="img"  width="975px" height="180px"></a></li-->
    </ol>
    <ol class="btns">
        <li>1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
    </ol>
</div>
						