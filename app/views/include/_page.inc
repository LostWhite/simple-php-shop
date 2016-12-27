	<?php
	if($end > 0){
		if($current == 1){
			echo "<div class='page'><em>上一页&nbsp;</em>";
		}else{
			$pages = $current-1;
			echo "<div class='page'><a href='$site_url/index?p=$pages' >上一页&nbsp;</a>";
		}
		
		for($p = 1;$p <= $end;$p ++){
			if($p == $current){
				echo "<strong>$p</strong>&nbsp;";
			}else{
				echo "<a href='$site_url/index?p=$p' >$p&nbsp;</a>";
			}
		}
		if($current == $end){
			echo "<em>下一页&nbsp;</em></div>";
		}else{
			$pages = $current+1;
			echo "<a href='$site_url/index?p=$pages' >下一页&nbsp;</a></div>";
		}
	}
?>