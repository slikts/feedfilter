#feedfilter

Companion project to [scraper](https://github.com/slikts/scraper).

##nginx

```location /www_root {
    try_files $uri /www_root/index.php$is_args$args;
}```