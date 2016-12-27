	<?php
	
	$pageurl=$page['url'];
	if( $page['end'] > 0){
		
		if( $page['current'] == 1){
			//echo "<div class='page'><em>上一页&nbsp;</em>";
			echo "<div class='page'>";
		}else{
			$pages =  $page['current']-1;
			echo "<div class='page'><a href='$pageurl ?p=$pages' >上一页&nbsp;</a>";
		}
	

		foreach ($page['paging'] as $value) { 
			if($value == $page['current']){
				echo "<strong>$value</strong>&nbsp;";
			}else{
				echo "<a href='$pageurl ?p=$value' >$value&nbsp;</a>";
			}
		} 
			
		
		if($page['current']  ==  $page['end']){
			//echo "<em>下一页&nbsp;</em></div>";
			echo "</div>";
		}else{
			$pages = $page['current'] + 1;
			echo "<a href='$pageurl ?p=$pages' >下一页&nbsp;</a></div>";
		}
		
		
	}

?>