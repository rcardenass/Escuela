<table width="300" align="center">
	<tr>
		<td>
			<a class="toFirst" <?php if ($dtable->getPageNum() == 0) echo 'style="visibility: hidden"' ?> id="<?php echo $dtable->listName; ?>_nav_first" href="<?php echo str_replace('&', '&amp;', KT_escapeAttribute($dtable->getNavLink("first")));?>"><span class="noImg">&lt;&lt;</span></a>
		</td>
		<td>
			<a class="toPrev"<?php if ($dtable->getPageNum() == 0) echo 'style="visibility: hidden"' ?> id="<?php echo $dtable->listName; ?>_nav_previous" href="<?php echo str_replace('&', '&amp;', KT_escapeAttribute($dtable->getNavLink("previous")));?>"><span class="noImg">&lt;</span></a>
		</td>
		<td>
			<a class="toNext" <?php if ($dtable->getPageNum() >= $dtable->getTotalPages()) echo 'style="visibility: hidden"' ?> id="<?php echo $dtable->listName; ?>_nav_next" href="<?php echo str_replace('&', '&amp;', KT_escapeAttribute($dtable->getNavLink("next")));?>"><span class="noImg">&gt;</span></a>
		</td>
		<td>
			<a class="toLast" <?php if ($dtable->getPageNum() >= $dtable->getTotalPages()) echo 'style="visibility: hidden"' ?> id="<?php echo $dtable->listName; ?>_nav_last" href="<?php echo str_replace('&', '&amp;', KT_escapeAttribute($dtable->getNavLink("last")));?>"><span class="noImg">&gt;&gt;</span></a>
		</td>
	</tr>
</table>
