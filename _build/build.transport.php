<?php
/**
 * getFeed
 *
 * @package getFeed
 * @version 1.0.0
 * @release ga
 * @author Jason Coward <modx@opengeek.com>
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

/* set package info */
define('PKG_NAME','getFeed');
define('PKG_NAME_LOWER','getfeed');
define('PKG_VERSION','1.0.0');
define('PKG_RELEASE','rc1');

/* define sources */
$root = dirname(dirname(__FILE__)) . '/';
$sources= array (
    'root' => $root,
    'build' => $root . '_build/',
    'lexicon' => $root . '_build/lexicon/',
    'properties' => $root . '_build/properties/',
    'docs' => $root . 'core/components/'.PKG_NAME_LOWER.'/docs/',
    'source_core' => $root . 'core/components/'.PKG_NAME_LOWER,
);
unset($root);

/* instantiate MODx */
require_once $sources['build'].'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(xPDO::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');


/* load builder */
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

/* create snippet object */
$modx->log(xPDO::LOG_LEVEL_INFO,'Adding in snippet.'); flush();
$snippet= $modx->newObject('modSnippet');
$snippet->set('name', 'getFeed');
$snippet->set('description', '<b>'.PKG_VERSION.'-'.PKG_RELEASE.'</b> A simple RSS feed client component for MODx Revolution');
$snippet->set('category', 0);
$snippet->set('snippet', file_get_contents($sources['source_core'] . '/snippet.getfeed.php'));
$properties = include $sources['properties'].'properties.inc.php';
$snippet->setProperties($properties);
unset($properties);


/* create a transport vehicle for the data object */
$vehicle = $builder->createVehicle($snippet,array(
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'name',
));
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));
$builder->putVehicle($vehicle);

/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
));

/* zip up the package */
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(xPDO::LOG_LEVEL_INFO, "Package Built.");
$modx->log(xPDO::LOG_LEVEL_INFO, "Execution time: {$totalTime}");
exit();
