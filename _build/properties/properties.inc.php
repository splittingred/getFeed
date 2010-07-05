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
        'options' => '',
        'value' => '',

    ),
    'tpl' => array (
        'name' => 'tpl',
        'desc' => 'Name of a chunk to serve as an item tpl',
        'type' => 'textfield',
        'options' => '',
        'value' => '',

    ),
    'limit' => array (
        'name' => 'limit',
        'desc' => 'Limit the number of items to return; 0 is no limit.',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',

    ),
    'offset' => array (
        'name' => 'offset',
        'desc' => 'The zero-based index of the item to start at in the feed results.',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',

    ),
    'totalVar' => array (
        'name' => 'totalVar',
        'desc' => 'The name of a placeholder where the total number of items in the feed is stored. For getPage compatibility.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'total',

    ),
    'toPlaceholder' => array (
        'name' => 'toPlaceholder',
        'desc' => 'If set, will set the output to this placeholder name. If not set, will output directly the results.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',

    ),
    'outputEncoding' => array (
        'name' => 'outputEncoding',
        'desc' => 'Sets the encoding for the Magpie RSS loader.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'UTF-8',

    ),
);

return $properties;