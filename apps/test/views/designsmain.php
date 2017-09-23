
<?start_tooltip();?>
<table id="tableofstuff">
<thead>
<tr>
<th>Icon</th><th>Name</th><th>Levels</th><th>Rarity</th><th>Type</th>
</tr>
</thead>

<?php foreach($data as $item):
	$levels = '';
	$ls = explode('|', $item['levels']);
	asort($ls);
	foreach($ls as $level)
	{
		$levels .= "<a href='/traits/{$item['dbid']}/{$level}'>{$level}</a> ";
		$maxlevel = $level;
	}
?>
<tr>
<td><img class="pic" src="images/Art/<?=$item['icon']?>.png" width="45px"/></td>
<td><a href="/traits/<?=$item['dbid']?>/<?=$maxlevel?>" ><?=$item['DisplayName']?></a></td>
<td><span><?=$levels?></span></td>
<td> <span class="<?=$item['rarity']?>"><?=$item['rarity'] ?></span></td>
<td> <?=$item['type'] ?></td>
</tr>
<?php //<tr><td colspan="5" style="text-align:center">test</td></tr> ?>
<?php endforeach;?>
</table>

<?end_tooltip();?>