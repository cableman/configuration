<?php
// Print sizes in a pretty format.
function bsize($size) {
  foreach (array('', 'K', 'M', 'G') as $k) {
    if ($size < 1024) {
      break;
    }
    $size /= 1024;
  }
  return sprintf("%5.1f %sBytes", $size, $k);
}
 
// Connect to memcache.
$memcache = new Memcache();
$memcache->addServer('localhost', 11211, false);
 
// Get stats.
$stats = $memcache->getExtendedStats();
$stats = $stats['localhost:11211'];
 
// Print information about memcache usage.
echo 'Size: ', bsize((real)$stats['limit_maxbytes']), "\n";
echo 'Used: ', bsize((real)$stats['bytes']), "\n";
echo 'Free: ', bsize($stats['limit_maxbytes'] - $stats['bytes']), "\n";
echo 'Read: ', bsize((real)$stats['bytes_read']), "\n";
echo 'Written: ', bsize((real)$stats['bytes_written']), "\n";
 
echo "\n",'Used percent',"\n";
$used = ((real)$stats['bytes']/(real)$stats['limit_maxbytes']) * 100;
echo 'Used: ', sprintf('%01.2f', $used), "%\n";
echo 'Free: ', sprintf('%01.2f', 100-$used), "%\n";
