<?php
/**
 * getFeed
 *
 * A simple snippet to retrieve an RSS feed and iterate the feed items using a Chunk.
 *
 * @author opengeek <modx@opengeek.com>
 * @version 1.0.0-beta
 * @copyright Copyright &copy; 2010, opengeek
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
$output = array();
if (!empty($url) && $modx->getService('rss', 'xmlrss.modRSSParser')) {
    $rss = $modx->rss->parse($url);
    if (!empty($rss)) {
        foreach ($rss->items as $itemKey => $item) {
            if (!empty($itemTpl)) {
                $output[] = $modx->getChunk($itemTpl, $item);
            } else {
                $output[] = '<pre>' . print_r($item, true) . '</pre>';
            }
        }
    }
}
return implode("\n", $output);
?>