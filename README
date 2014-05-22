
This is an attempt to make the Ganglia UI more usable.  Installation instructions
can be found here

http://sourceforge.net/apps/trac/ganglia/wiki/ganglia-web-2#Installation

## configure for ganglia web
add your customized configure setting in $gweb_root/conf.php(don't edit conf_default.php), my worked version like this:
```
<?php
$conf['auth_system'] = 'disabled';
$conf['ganglia_ip'] = "10.32.99.3";
$conf['cachemodule'] = 'Memcache';
?>
```

* $conf['ganglia_ip']: gmetad's ip for XML meta data query. Because I use two gmetad in prod, 
one for normal use(write rrds), the other one for XML meta daemon only(no rrd write, I call it gmetad-norrd) which runs for gweb.
here 10.32.99.3 is the gmetad-norrd's ip.
* $conf['cachemodule']: in this version, you can choose Json or Memcache. 
But they are both used in mere case: e. g. cluster's aggregated graph(stacked.graph).
Where I want to use memcache is gweb's front page: grid summary. Grid summary is the slowest place in my environment.
This enhanced version will be used to solve this problem by using memcached.
   
