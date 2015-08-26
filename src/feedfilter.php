<?
namespace feedfilter;

require(__DIR__ . '/config.php');

$dbh = new \PDO(DSN);
$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
global $dbh;

function get_modules() {
	global $dbh;

	$query = $dbh->prepare('SELECT module, count(*) FROM ' . SCRAPE_TABLE . ' GROUP BY module');
    $query->execute();

    return $query->fetchAll();
}


function get_filters($module, $feed = NULL) {
	global $dbh;

	$query = $dbh->prepare('SELECT count(*), cat FROM ' . SCRAPE_TABLE . ' WHERE module = ? GROUP BY cat ORDER BY cat');
	$query->execute(array($module));

	return $query->fetchAll();
}


function get_feed_items($module, $feed, $limit = 200) {
	global $dbh;

	$query = $dbh->prepare('SELECT * FROM ' . SCRAPE_TABLE . ' a WHERE a.module = ? 
		AND a.cat IN (SELECT DISTINCT filter FROM ' . FEED_TABLE . ' b WHERE b.id = ?)
		ORDER BY a.created DESC');

	$query->execute(array($module, $feed));

	return $query->fetchAll();
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

function module_name($name) {
	return trim($name, '_');
}


function escape($string) {
	return preg_replace('/[^\da-z_-]/i', '', $string);
}


function message($text) {
	if (!isset($_SESSION['messages'])) {
		$_SESSION['messages'] = array();
	}
	array_push($_SESSION['messages'], $text);
}


function new_feed_id() {
	global $dbh;

	$rand = mt_rand(10e7, mt_getrandmax());

	$query = $dbh->prepare('SELECT COUNT(*) AS total FROM ' . FEED_TABLE . ' WHERE id = ?');
	$query->execute(array($rand));
	$result = $query->fetchObject();

	if ($result->total > 0) {
		$rand = new_feed_id();
	}

	return $rand;
}


function update_feed($id, $module, $cats) {
	global $dbh;

	$dbh->beginTransaction();

	_clear_feed($id);
	_save_feed($id, $module, $cats);

	$dbh->commit();
}


function _save_feed($id, $module, $cats) {
	global $dbh;

	foreach ($cats as $cat) {
		$query = $dbh->prepare('INSERT INTO ' . FEED_TABLE . ' (id, module, filter) VALUES (?, ?, ?)');
		$query->execute(array($id, $module, $cat));
	}
}


function _clear_feed($id) {
	global $dbh;

	$query = $dbh->prepare('DELETE FROM ' . FEED_TABLE . ' WHERE id = ?');
	$query->execute(array($id));
}


function validate_module_name($name) {
	foreach (get_modules() as $module) {
		if ($module['module'] === $name) {
			return TRUE;
		}
	}

	return FALSE;
}


function get_feed_cats($id) {
	global $dbh;

	$query = $dbh->prepare('SELECT * FROM ' . FEED_TABLE . ' WHERE id = ?');
	$query->execute(array($id));

	$cats = array();

	foreach ($query->fetchAll() as $item) {
		array_push($cats, $item['filter']);
	}

	return $cats;
}


function feed_id_decode($id) {
	return base_convert($id, 32, 10);
}


function feed_id_encode($id) {
	return base_convert((int) $id, 10, 32);
}