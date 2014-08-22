[![Build Status](https://travis-ci.org/cuevae/collectionPlusJson-php.svg?branch=master)](https://travis-ci.org/cuevae/collectionPlusJson-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/?branch=master)

# collectionPlusJson-php

version: 0.5.2

## Introduction
>**Collection+JSON** is a JSON-based read/write hypermedia-type designed to support management and querying of simple collections.
>
>The **Collection+JSON** hypermedia type is designed to support full read/write capability for simple lists (contacts, >tasks, blog entries, etc.). The standard application semantics supported by this media type include Create, Read, Update, >and Delete (CRUD) along w/ support for predefined queries including query templates (similar to HTML "GET" forms). Write >operations are defined using a template object supplied by the server as part of the response representation."
>
>*From Collection+JSON [site](http://amundsen.com/media-types/collection/format/)*

## Example
```php

$colors = new Collection('http://api.colors.io/');

$color1 = new Item($colors->getHref()->extend('color1'));
$color1->addData('id', '1', 'This is the color id')
       ->addData('hex_value', '#9932CC', 'This is the color in hex format')
       ->addData('human_value', 'DarkOrchid', 'This is the color in human readable format');

$color2 = new Item($colors->getHref()->extend('color2'));
$color2->addData('id', '2', 'This is the color id')
       ->addData('hex_value', '#FFFFF0', 'This is the color in hex format')
       ->addData('human_value', 'Ivory', 'This is the color in human readable format');

$colors->addItems([$color1, $color2]);

echo json_encode($colors->output());

/*
Output would be:

{
    "collection": {
        "version": "0.4.0",
        "href": "http://api.colors.io/",
        "links": [],
        "items": [
            {
                "href": "http://api.colors.io/color1",
                "data": [
                    {
                        "name": "id",
                        "value": "1",
                        "prompt": "This is the color id"
                    },
                    {
                        "name": "hex_value",
                        "value": "#9932CC",
                        "prompt": "This is the color in hex format"
                    },
                    {
                        "name": "human_value",
                        "value": "DarkOrchid",
                        "prompt": "This is the color in human readable format"
                    }
                ],
                "links": []
            },
            {
                "href": "http://api.colors.io/color2",
                "data": [
                    {
                        "name": "id",
                        "value": "2",
                        "prompt": "This is the color id"
                    },
                    {
                        "name": "hex_value",
                        "value": "#FFFFF0",
                        "prompt": "This is the color in hex format"
                    },
                    {
                        "name": "human_value",
                        "value": "Ivory",
                        "prompt": "This is the color in human readable format"
                    }
                ],
                "links": []
            }
        ],
        "queries": [],
        "template": null,
        "error": null
    }
}

*/

```
