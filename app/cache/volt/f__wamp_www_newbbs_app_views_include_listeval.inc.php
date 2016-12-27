<style type="text/css"> 
#eval_index{width:100%;height:40px;overflow:hidden;line-height:40px;font-size:13px;font-family:'宋体';background:#DDE5ED;color:#0C77CF;font-weight:bold;} 
#eval_index #scroll_begin, #eval_index #scroll_end{display:inline} 
</style> 
<script type="text/javascript"> 
function ScrollImgLeft(){ 
var speed=50; 
var scroll_begin = document.getElementById("scroll_begin"); 
var scroll_end = document.getElementById("scroll_end"); 
var scroll_div = document.getElementById("scroll_div"); 
scroll_end.innerHTML=scroll_begin.innerHTML; 
function Marquee(){ 
if(scroll_end.offsetWidth-scroll_div.scrollLeft<=0) 
scroll_div.scrollLeft-=scroll_begin.offsetWidth; 
else 
scroll_div.scrollLeft++; 
} 
var MyMar=setInterval(Marquee,speed); 
scroll_div.onmouseover=function() {clearInterval(MyMar);} 
scroll_div.onmouseout=function() {MyMar=setInterval(Marquee,speed);} 
} 
</script> 
<div id="eval_index"> 
<div style="width:950px;height:40px;margin:0 auto;white-space: nowrap;overflow:hidden;" id="scroll_div" class="scroll_div"> 
<div id="scroll_begin"> 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
</div> 
<div id="scroll_end"></div> 
</div> 
<script type="text/javascript">ScrollImgLeft();</script> 
</div>