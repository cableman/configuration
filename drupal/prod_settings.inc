<?php
// Drupal cache
$conf['cache'] = 1;
$conf['block_cache'] = 1;
$conf['preprocess_css'] = 1;
$conf['preprocess_js'] = 1;

// Forms cache table.
$conf['cache_class_cache_form'] = 'DrupalDatabaseCache';
 
// Memcache configuration
$conf += array(
  'memcache_extension' => 'Memcache',
  'show_memcache_statistics' => 0,
  'memcache_persistent' => TRUE,
  'memcache_stampede_protection' => TRUE,
  'memcache_stampede_semaphore' => 15,
  'memcache_stampede_wait_time' => 5,
  'memcache_stampede_wait_limit' => 3,
  'memcache_key_prefix' => basename(realpath(conf_path())),
);
 
include_once('./includes/cache.inc');
include_once('./sites/all/modules/contrib/memcache/memcache.inc');
 
$conf['cache_backends'][] = 'sites/all/modules/contrib/memcache/memcache.inc';
$conf['cache_default_class'] = 'MemCacheDrupal';
$conf['memcache_servers'] = array(
  '127.0.0.1:11211' => 'default',
);
$conf['memcache_bins'] = array(
  'cache' => 'default',
);

// APC.
$conf['cache_backends'][] = 'sites/all/modules/contrib/apc/drupal_apc_cache.inc';
$conf['cache_class_cache'] = 'DrupalAPCCache';
$conf['cache_class_cache_bootstrap'] = 'DrupalAPCCache';

// Logging
$conf['syslog_identity'] = 'SITENAME';
 
// Varnish
$conf['reverse_proxy'] = TRUE;
$conf['reverse_proxy_addresses'] = array('127.0.0.1');
$conf['page_cache_invoke_hooks'] = FALSE;
$conf['varnish_flush_cron'] = 1;
$conf['varnish_version'] = 3;
$conf['varnish_control_key'] = 'FOUND IN VARNISH SECRET FILE';
 
$conf['cache_lifetime'] = 0;
$conf['page_cache_maximum_age'] = 21600;

