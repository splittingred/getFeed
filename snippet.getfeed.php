<?php
/**
 * getFeed
 *
 * A simple snippet to retrieve an RSS feed and iterate the feed items using a Chunk.
 *
 * @author Jason Coward <modx@opengeek.com>
 * @version 1.0.0-beta
 * @copyright Copyright 2010 by Jason Coward
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
$limit = isset($limit) ? (integer) $limit : 0;
$offset = isset($offset) ? (integer) $offset : 0;
$totalVar = !empty($totalVar) ? $totalVar : 'total';
$total = 0;
$output = array();
if (!empty($url) && $modx->getService('rss', 'xmlrss.modRSSParser')) {
    $rss = $modx->rss->parse($url);
    if (!empty($rss) && isset($rss->items)) {
        $total = count($rss->items);
        $modx->setPlaceholder($totalVar, $total);
        $itemIdx = 0;
        $idx = 0;
        while (list($itemKey, $item) = each($rss->items)) {
            if ($idx >= $offset) {
                if (!empty($tpl)) {
                    $output[] = $modx->getChunk($tpl, $item);
                } else {
                    $output[] = '<pre>' . print_r($item, true) . '</pre>';
                }
                $itemIdx++;
                if ($limit > 0 && $itemIdx > $limit) break;
            }
            $idx++;
        }
    } else {
        $modx->log(modX::LOG_LEVEL_ERROR, "Error parsing RSS feed at {$url}", '', 'getFeed', __FILE__, __LINE__);
    }
}
return implode("\n", $output);
?>