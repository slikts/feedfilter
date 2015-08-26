<?
namespace feedfilter;

ob_start('ob_gzhandler');

require(__DIR__ . '/../src/feedfilter.php');

header("Content-Type: text/plain; charset=ISO-8859-1");

session_start();

$request_uri = $_SERVER['REQUEST_URI'];

if (substr($request_uri, 0, strlen(WWW_ROOT)) === WWW_ROOT) {
	$request_uri = substr($request_uri, strlen(WWW_ROOT));
}

if ($request_uri === '/') {
	template('home', array('title' => random_emoji()));

	return;
}

$request_parts = array_values(array_filter(explode('/', $request_uri)));

if (count($request_parts) > 1 && $request_parts[0] === 'module') {
	$module = $request_parts[1];

	if (!validate_module_name($module)) {
		http_response_code(404);

		return;
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (empty($_POST)) {
			message('nothing to do');
			header('Location: ' . $_SERVER['REQUEST_URI']);

			return;
		}

		if (empty($_POST['feed'])) {
			$feed = new_feed_id();
			$message = 'feed created, bookmark this page';
		} else {
			$feed = $_POST['feed'];
			$message = 'feed updated';
		}

		update_feed($feed, $module, array_keys($_POST['cat']));

		header('Location: ' . implode('/', array(WWW_ROOT, 'module', $module, feed_id_encode($feed))));
		message($message);

		return;
	}
	$feed = !empty($request_parts[2]) ? feed_id_decode($request_parts[2]) : NULL;
	$args = array(
		'module' => $module, 
		'title' => 'feed',
		'filters' => get_filters($module),
		'feed' => $feed,
		'feed_cats' => get_feed_cats($feed)
	);

	if ($feed) {
		$args['title'] = feed_id_encode($feed);
		$args['feed_items'] = get_feed_items($module, $feed);
		template('module', $args);
	} else {
		$args['title'] = 'new feed';
		template('module', $args);
	}
}

http_response_code(404);