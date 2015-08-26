<?
namespace feedfilter;

require(__DIR__ . '/../src/feedfilter.php');

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

if (count($request_parts) == 2 && $request_parts[0] === 'module') {
	template('module', array('module' => $request_parts[1], 'title' => 'new feed'));

	return;
}

http_response_code(404);