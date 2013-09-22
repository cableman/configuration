

<?php
 
register_shutdown_function('status_shutdown');
function status_shutdown() {
  exit();
}
 
// Drupal bootstrap.
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE);
 
// Build up our list of errors.
$errors = array();
 
// Check that the main database is active.
$uid = db_query('SELECT uid FROM {users} WHERE uid = 1')->fetchField();
if (!$uid) {
  $errors[] = 'Master database not responding.';
}
 
// Check that all memcache instances are running on this server.
if (isset($conf['cache_default_class']) && $conf['cache_default_class'] == 'MemCacheDrupal') {
  foreach ($conf['memcache_servers'] as $address => $bin) {
    list($ip, $port) = explode(':', $address);
    $memcache = new Memcache();
    if (!$memcache->addServer($ip, $port, false)) {
      $errors[] = 'Memcache bin <em>' . $bin . '</em> at address ' . $address . ' is not available.'; 
    }
    else {
      if (!$memcache->set('status_string', 'A simple test string')) {
        $errors[] = 'Memcache bin <em>' . $bin . '</em> at address ' . $address . ' is not available.';
      }
    }
  }
}
 
// Check that the files directory is operating properly.
if ($test = tempnam(variable_get('file_directory_path', conf_path() .'/files'), 'status_check_')) {
  if (!unlink($test)) {
    $errors[] = 'Could not delete newly create files in the files directory.';
  }
}
else {
  $errors[] = 'Could not create temporary file in the files directory.';
}
 
// Print all errors.
if ($errors) {
  $errors[] = 'Errors on this server will cause it to be removed from the load balancer.';
  header('HTTP/1.1 500 Internal Server Error');
  print implode("<br />\n", $errors);
}
else {
  // Split up this message, to prevent the remote chance of monitoring software
  // reading the source code if mod_php fails and then matching the string.
  print 'CONGRATULATIONS' . ' 200';
}
 
// Exit immediately, note the shutdown function registered at the top of the file.
exit();
