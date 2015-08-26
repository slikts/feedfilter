<?
namespace feedfilter;

$modules = get_modules();

random_emoji();

?>

<table>
<tr>
	<th>module</th>
	<th>items</th>
</tr>
<? foreach ($modules as $item) : ?>
<tr>
	<td>
		<strong>
			<a href="<?=module_link($item['module'])?>"><?=module_name($item['module'])?>
		</strong>
	</td>
	<td><?=$item['count']?></td>
</tr>
<? endforeach; ?>
</table>