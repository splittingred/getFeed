<?php
/**
 * getFeed
 *
 * @package getfeed
 * @version 1.0.0-beta
 * @author opengeek <modx@opengeek.com>
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
/* Get rid of time limit. */
set_time_limit(0);

/* Set directories for source files. */
$root = dirname(dirname(__FILE__)) . '/';
$sources= array (
    'root' => $root,
    'build' => $root . '_build/',
    'lexicon' => $root . '_build/lexicon/',
    'docs' => $root . '_build/docs/'
);
unset($root);

/* Override with your own defines here (see build.config.sample.php). */
require_once $sources['build'].'build.config.php';

/* The following four lines aren't necessary if you run this as a snippet inside MODx. */
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(MODX_LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

/* Set Package Name  */
$name = 'getfeed';
$version = '1.0.0';
$release = 'beta';

/* Load the Package Builder and create the package */
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage($name, $version, $release);


$c= $modx->newObject('modSnippet');
$c->set('name', 'getFeed');
$c->set('description', "<strong>{$version}-{$release}</strong> getFeed for MODx Revolution");
$c->set('category', 0);
$c->set('snippet', file_get_contents($sources['root'] . 'snippet.component-source.php'));

/* Create a transport vehicle for the data object */
$attributes= array(XPDO_TRANSPORT_UNIQUE_KEY => 'name');
$vehicle = $builder->createVehicle($c, $attributes);

$builder->putVehicle($vehicle);

/* (optional) Include readme, license, and/or an html file that interacts with the user during the install.
 * Each array member is optional but you should always include a readme.txt file.
 */
$builder->setPackageAttributes(array(
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'license' => file_get_contents($sources['docs'] . 'license.txt')
));

/*  zip up the package */
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(MODX_LOG_LEVEL_INFO, "Package Built Successfully.");
$modx->log(MODX_LOG_LEVEL_INFO, "Execution time: {$totalTime}");
exit();
