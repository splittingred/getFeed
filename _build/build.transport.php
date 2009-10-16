<?php
/**
 * Component Template
 *
 * @package component-template
 * @version 1.0.1
 * @release ga
 * @author Test <test@test.com>
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
    'assets' => $root . 'assets/',
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
$name = 'component-template';
$version = '1.0.1';
$release = 'beta';

/* Load the Package Builder and create the package */
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage($name, $version, $release);
$builder->registerNamespace('component-template',false,true);


/* get the source from the actual snippet in your database
 * with $modx->getObject('modsnippet',array('name'=>'SnippetName'));
 * OR
 * manually create the object, grabbing the source from a file
 * as we do here: */

$c= $modx->newObject('modSnippet');
$c->set('name', 'component-template');
$c->set('description', '<strong>1.0</strong> This is a component for MODx Revolution');
$c->set('category', 0);
$c->set('snippet', file_get_contents($sources['assets'] . 'snippet.component-source.php'));

/* Create a transport vehicle for the data object */
$attributes= array(XPDO_TRANSPORT_UNIQUE_KEY => 'name');
$vehicle = $builder->createVehicle($c, $attributes);


/* The sections marked optional should be commented out or removed if you don't need them */

/* (optional) Add a validator that will transfer files at the beginning of the install.
 * If the files are not transferred successfully, the install will abort */
$vehicle->validate('file',array(
    'source' => $sources['docs'],
    'target' => "return MODX_ASSETS_PATH . 'components/component-template/';",
));

/* (optional) Add a php script that will execute at the beginning of the install.
 *  Must return true or the install will abort */
$vehicle->validate('php',array(
            'type' => 'php',
            'source' => 'preinstall-script.php'
        ));

/* (optional) Add a resolver to transfer files at the end of the install.
 * This example will transfer the assets/component-template directory
 *  and all its files to core/components/
 */
$vehicle->resolve('file',array(
    'source' => $sources['assets'] . 'component-template',
    'target' => "return MODX_CORE_PATH . 'components/';",
));

/* (optional) Add a php script that will execute at the end of the install
 *  Should return true on success.
 *
 *  It can use all HTML input variables defined in the user_input.html file
 *  added in setPackageAttributes() below.
 */
$vehicle->resolve('php',array(
            'type' => 'php',
            'source' => 'install-script.php'
        ));

/* (required) Add Vehicle to Package */

$builder->putVehicle($vehicle);

/*  (optional) Load lexicon strings */
$builder->buildLexicon($sources['lexicon']);

/* (optional) Include readme, license, and/or an html file that interacts with the user during the install.
 * Each array member is optional but you should always include a readme.txt file.
 */
$builder->setPackageAttributes(array(
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'setup-options' => file_get_contents($sources['build'] . 'user-input.html')
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
