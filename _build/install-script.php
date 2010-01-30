  <?php
  /**
 * Component Template Example Script Resolver
 *
 * @package component-template
 * @version 1.0.2
 * @release beta
 * @author Test <test@test.com>
 */

 /* This file is an example or a script resolver that runs at
  * the end of the install.
  *
  * If the user selects the installation of the demo resource
  * during the package install, this script will create
  * two sample pages, one the parent of the other, each with
  * the site's default template */


 /* Get the site's default template so we can assign it to the resource.
  *
  * The $modx object is not available here so we have to use
  * $object->xpdo in it's place */

$default_template = $object->xpdo->config['default_template'];

$success = false;
switch($options[XPDO_TRANSPORT_PACKAGE_ACTION]) {


    case XPDO_TRANSPORT_ACTION_INSTALL:
        if (isset($options['install_sample']) && $options['install_sample'] == 'Yes' ) {
            /* user wants the demo */
            $object->xpdo->log(XPDO_LOG_LEVEL_INFO,"Creating resource: Sample Page<br />");
            $r = $object->xpdo->newObject('modResource');
            $r->set('class_key','modDocument');
            $r->set('context_key','web');
            $r->set('type','document');
            $r->set('contentType','text/html');
            $r->set('pagetitle','SamplePage');
            $r->set('longtitle','SamplePage');
            $r->set('description','SamplePage');
            $r->set('alias','sample');
            $r->set('published','1');
            $r->set('parent','0');
            $r->set('isfolder','1');
            /* Could get content from a file with file_getcontenets() */
            /* $r->setContent(file_get_contents($sources['docs'] . 'sample-content')); */
            $r->setContent('This is the sample component template content');
            $r->set('richtext','0');
            $r->set('menuindex','99');
            $r->set('searchable','1');
            $r->set('cacheable','1');
            $r->set('menutitle','Component Sample');
            $r->set('donthit','0');
            $r->set('hidemenu','0');
            $r->set('template',$default_template);

            $r->save();
            /* need this to set the next page's parent */
            $sampleId = $r->get('id');

            /* now create the second page */

            $object->xpdo->log(XPDO_LOG_LEVEL_INFO,"<br>Creating resource: Sample Page Two<br />");
            $r = $object->xpdo->newObject('modResource');

            $r->set('class_key','modDocument');
            $r->set('context_key','web');
            $r->set('type','document');
            $r->set('contentType','text/html');
            $r->set('pagetitle','Sample Page Two');
            $r->set('longtitle','Son of Sample Page');
            $r->set('description','Sample Page content number two');
            $r->set('alias','sample2');
            $r->set('published','0');
            $r->set('parent',$sampleId);
            $r->set('isfolder','0');
            $r->setContent('This is the child of the original sample page');
            $r->set('richtext','0');
            $r->set('searchable','0');
            $r->set('cacheable','1');
            $r->set('template',$default_template);
            $r->set('donthit','1');
            $r->set('hidemenu','1');

            $r->save();

            /* the code below assumes that you want to call the snippet
             * in the first sample page and set the second page's
             * resourceID as a parameter in the snippet call */

            $pageTwoId = $r->get('id');  /* need this to set docID in the snippet */
            /* get the first page from the DB and set its content */
            $resource = $object->xpdo->getObject('modDocument', array('pagetitle' => 'SamplePage') );
            $resource->setContent("[[component-template? &docID=`" . $pageTwoId . "`]]" );
            $resource->save();

            }

            $success = true;
            break;

        case XPDO_TRANSPORT_ACTION_UPGRADE:
            /* do nothing for now - upgrade code could go here later */
            $success = true;
            break;
        case XPDO_TRANSPORT_ACTION_UNINSTALL:
            /* we don't know the resource IDs at this point and the user may have changed the pagetitle
             * so we have to tell the user to remove the resources manually */
            $object->xpdo->log(XPDO_LOG_LEVEL_INFO,"<br /><b>NOTE: You will have to remove the two Resources manually</b><br />");

            $success = true;
            break;

}
return $success;
?>
