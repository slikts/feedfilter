<?
namespace feedfilter;

require(__DIR__ . '/config.php');

$dbh = new \PDO(DSN);
$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
global $dbh;

function get_modules() {
	global $dbh;

	$query = $dbh->prepare('SELECT module, count(*) FROM ' . DB_TABLE . ' GROUP BY module');
    $query->execute();
    $result = $query->fetchAll();

    return $result;
}


function get_filters($module, $feed = NULL) {
	global $dbh;



	$feed_query = '';

}


function get_items($limit, $module) {
	global $dbh;

}


function template($part, $args = array()) {
	static $default_args = array(
		'title' => ''
	);

	$args = array_merge($default_args, $args);
	$template_part = __DIR__ . '/parts/' . $part . '.php';

	require __DIR__ . '/parts/base.php';
}


function get_url($part = '') {
	if ($part === 'home') {
		$part = '';
	}
	return WWW_ROOT . '/' . $part;
}


function module_link($module_name) {
	return WWW_ROOT . '/module/' . $module_name;
}


function random_emoji() {
	$emojis = json_decode(file_get_contents(__DIR__ . '/emojis.json'));
	return $emojis[array_rand($emojis)];
}