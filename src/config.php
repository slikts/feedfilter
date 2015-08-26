<?
define('DSN', 'pgsql:dbname=postgres user=slikts host=localhost');
define('SCRAPE_TABLE', 'scraped');
define('FEED_TABLE', 'feeds');
define('WWW_ROOT', '/feedfilter/webroot');
define('STATIC_ROOT', WWW_ROOT . '/static');
define('TOOL_NAME', 'feedfilter');
define('TOOL_VERSION', '0.1.0');
define('TOOL_URL', 'https://github.com/slikts/feedfilter');