<?
$rarities = array('cRarityCommon' => 'common',
                  'cRarityUncommon' => 'uncommon',
                  'cRarityRare' => 'rare',
                  'cRarityEpic' => 'epic');
$data['rarity'] = $rarities[$data['rarity']];
if (array_key_exists($data['output']['rarity'], $rarities))
  $data['output']['rarity'] = $rarities[$data['output']['rarity']];

$outputtypes = array('trait' => 'Item',
                      'material' => 'Material',
                      'consumable' => 'Consumable');

switch ($data['outputtype']) {
  case 'trait':
    $level = $data['outputtraitlevel'] - 3;
    $outputlink = "/traits/{$data['output']['dbid']}/$level";
    break;
  case 'material':
    $outputlink = "/materials/{$data['output']['name']}";
    break;
  case 'consumable':
    $outputlink = "/consumables/{$data['output']['name']}";
    break;
  default:
    $outputlink = '';
}

?>

<br />
<div style="float:left">

<? start_tooltip(); ?>

<div class="unit">
  <div class="traitheader">
    <div class="type"><?=$outputtypes[$data['outputtype']]?> Design</div>
    <div class="rarity"><span class="<?=$data['rarity']?>rarity"><?=$data['rarity']?></span></div>
  </div>
  <br />
  <br />
  <div class="itemnameandpic">
    <img class="pic" src="images/Art/<?=$data['icon']?>.png" width="64px"/> <span class="itemname <?=$data['rarity']?>rarity"><?=$data['output']['displayname']?></span>
  </div>
  
  <div class="iteminfo">
    <div class="description">
    <p><?=$data['rollovertext']?></p>
    <p><?=$data['displayname']?></p>
    
    <p>Creates: <a href="<?=$outputlink?>" style="text-decoration: none"><span class="<?=$data['output']['rarity']?>rarity"><?=$data['output']['displayname']?></span></a></p>
    <br>
    <? if (isset($data['materials'])) { ?>
    Required Materials:<br>
    <? foreach ($data['materials'] as $material) {
    echo "<img src='/images/Art/{$material['icon']}.png' height='32'> {$material['count']}x <a href='/materials/{$material['name']}' style='text-decoration: none'><span class='itemname {$rarities[$material['rarity']]}rarity'>{$material['displayname']}</span></a><br>";
    
    }
    } ?>

  
</div>


<pre>
<?
print_r($data);
?>
</pre>
<? end_tooltip(); ?>
</div>


