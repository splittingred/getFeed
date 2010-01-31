<?php
/**
 * Default properties for getFeed snippet
 *
 * @package getfeed
 * @subpackage build
 */
$properties = array (
    'url' => array (
        'name' => 'url',
        'desc' => 'URL of the feed to retrieve',
        'type' => 'textfield',
        'options' => array (),
        'value' => '',

    ),
    'tpl' => array (
        'name' => 'tpl',
        'desc' => 'Name of a chunk to serve as an item tpl',
        'type' => 'textfield',
        'options' => array (),
        'value' => '',

    ),
    'limit' => array (
        'name' => 'limit',
        'desc' => 'Limit the number of items to return; 0 is no limit.',
        'type' => 'numberfield',
        'options' => array (),
        'value' => '0',

    ),
    'offset' => array (
        'name' => 'offset',
        'desc' => 'The zero-based index of the item to start at in the feed results.',
        'type' => 'numberfield',
        'options' => array (),
        'value' => '0',

    ),
    'totalVar' => array (
        'name' => 'totalVar',
        'desc' => 'The name of a placeholder where the total number of items in the feed is stored. For getPage compatibility.',
        'type' => 'textfield',
        'options' => array (),
        'value' => 'total',

    ),
);

return $properties;