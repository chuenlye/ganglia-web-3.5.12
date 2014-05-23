<?php

    if (!isset($debug)) { $debug = 0; }

    $cmodule = !empty($conf['cachemodule']) ? $conf['cachemodule'] : 'Json';

    include_once dirname(__FILE__) . "/Cache/Driver_${cmodule}.php";

    if ($conf['cachedata'] == 1 && g_cache_meta_exists()) {
        // check for the cache (file or memcache)
        // snag it and return it if it is still fresh
        $cache_age = g_cache_meta_expire();
        if( $cache_age <= $conf['cachetime']){
                if ( $debug == 1 ) {
                  echo("DEBUG: Fetching meta data from cache. Expires in " . $conf['cachetime'] . " seconds.\n");
                }
                $meta_array = g_cache_meta_deserialize();
        }
    }

    if (!isset($meta_array)) {

        if ( $debug == 1 ) {
            echo("DEBUG: Querying GMond for new data\n");
        }
        // Set up for grid summary
        include_once $conf['gweb_root'] . "/functions.php";
        include_once $conf['gweb_root'] . "/ganglia.php";
        $GLOBALS['context'] = "meta";
        //include $conf['gweb_root'] . "/get_ganglia.php";
        Gmetad($conf['ganglia_ip'], $conf['ganglia_port']);

        // only save if there are more than 1 cluster sources.
        if (count($grid) > 2) {
            $meta_array = array();
            $meta_array['self'] = $self;
            $meta_array['grid'] = $grid;
            $meta_array['metrics'] = $metrics;
            g_cache_meta_serialize($meta_array);
        }
    } else {
        $self = $meta_array['self'];
        $grid = $meta_array['grid'];
        $metrics = $meta_array['metrics'];
    }

?>
