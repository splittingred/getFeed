  <?php
  /**
 * Component Template Example Script Validator
 *
 * @package component-template
 * @version 1.0.2
 * @release beta
 * @author Test <test@test.com>
 */

 /* This file is an example or a script validator that runs at
  * the beginning of the install. */


$success = false;
switch($options[XPDO_TRANSPORT_PACKAGE_ACTION]) {


    case XPDO_TRANSPORT_ACTION_INSTALL:
    case XPDO_TRANSPORT_ACTION_UPGRADE:
            /* abort install/upgrade if it's not a weekday */
            $day = date( "w" );
            if ($day > 0 && $day < 6) {
                $success = false;
                $object->xpdo->log(XPDO_LOG_LEVEL_INFO,"<br />Sorry, this package can only be installed on a weekday<br />");
            }
            break;
        case XPDO_TRANSPORT_ACTION_UNINSTALL:
            /* do nothing */

            $success = true;
            break;

}
return $success;
?>
