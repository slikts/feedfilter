<?
namespace feedfilter;

?>

<div id="feed-form" class="form-wrap<? if ($args['feed']) : ?> feed-hide<? endif; ?>">
	<? if ($args['feed']) : ?>
		<p class="feed-edit">
			<button id="feed-edit">edit feed</button>
		</p>
		<script>
		(function() {
			var button = document.getElementById('feed-edit');
			button.addEventListener('click', function() {
				document.getElementById('feed-form').classList.remove('feed-hide');
			}, false);
		})();
		</script>
	<? endif ?>
	<form method="post">
		<p class="save"><input type="submit" value="save"></p>
		<table class="cat-list">
			<thead>
				<tr>
					<th></th>
					<th>cat</th>
					<th>count</th>
				</tr>
			</thead>
			<tbody>
			<? foreach ($args['filters'] as $item) :
			$cat = escape(htmlspecialchars($item['cat']));
			?>
				<tr>
					<td class="checkboxes">
						<label for="cat-<?=$cat?>">
							<input type="checkbox" name="cat[<?=$cat?>]" id="cat-<?=$cat?>"<?
							if (in_array($cat, $args['feed_cats'])) : ?>
							checked="checked"
							<? endif; ?>></td>
						</label>
					<td>
						<label for="cat-<?=$cat?>">
							<?=$cat?>
						</label>
					</td>
					<td>
						<label for="cat-<?=$cat?>">
							<?=$item['count']?>
						</label>
					</td>
				</tr>
			<? endforeach; ?>
			</tbody>
		</table>
		<p class="save"><input type="submit" value="save"></p>
		<? if ($args['feed']) : ?>
		<input type="hidden" name="feed" value="<?=$args['feed']?>">
		<? endif; ?>
	</form>
</div>

<? if ($args['feed']) : ?>
<div class="feed-items">
	<table>
	<? foreach ($args['feed_items'] as $item) :
		$data = json_decode($item['data']);
	 ?>
		<tr>
			<td>
				<a href="<?=$data->url?>" rel="noreferrer">
					<?=$data->title?>
				</a>
			</td>
			<td>
				<?=$item['created']?>
			</td>
		</tr>
	<? endforeach; ?>
	</table>
</div>

<? endif; ?>