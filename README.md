[![Build Status](https://travis-ci.org/cuevaec/collectionPlusJson-php.svg?branch=master)](https://travis-ci.org/cuevaec/collectionPlusJson-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cuevaec/collectionPlusJson-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cuevaec/collectionPlusJson-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/cuevaec/collectionPlusJson-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cuevaec/collectionPlusJson-php/?branch=master)

# collectionPlusJson-php

## Introduction
>**Collection+JSON** is a JSON-based read/write hypermedia-type designed to support management and querying of simple collections.
>
>The **Collection+JSON** hypermedia type is designed to support full read/write capability for simple lists (contacts, >tasks, blog entries, etc.). The standard application semantics supported by this media type include Create, Read, Update, >and Delete (CRUD) along w/ support for predefined queries including query templates (similar to HTML "GET" forms). Write >operations are defined using a template object supplied by the server as part of the response representation."
>
>*From Collection+JSON [site](http://amundsen.com/media-types/collection/format/)*

## Example
```php

$baseUrl = 'http://api.colors.com/';

$colors = new Collection('0.0.1', new Href($baseUrl));

$color1 = new Item(new Href($baseUrl.'color1'));
$color1->addData(new DataObject('id', '1', 'This is the color id'))
       ->addData(new DataObject('hex_value', '#9932CC', 'This is the color in hex format'))
       ->addData(new DataObject('human_value', 'DarkOrchid', 'This is the color in human readable format'));

$color2 = new Item(new Href($baseUrl.'color2'));
$color2->addData(new DataObject('id', '2', 'This is the color id'))
       ->addData(new DataObject('hex_value', '#FFFFF0', 'This is the color in hex format'))
       ->addData(new DataObject('human_value', 'Ivory', 'This is the color in human readable format'));

$colors->addItem($color1)->addItem($color2);
        
echo json_encode($colors->_output());

/*

Output would be:

{
    "collection": {
        "version": "0.0.1",
        "href": "http://api.colors.com/",
        "links": [],
        "items": [
            {
                "href": "http://api.colors.com/color1",
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
                "href": "http://api.colors.com/color2",
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
