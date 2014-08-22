[![Build Status](https://travis-ci.org/cuevae/collectionPlusJson-php.svg?branch=master)](https://travis-ci.org/cuevae/collectionPlusJson-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cuevae/collectionPlusJson-php/?branch=master)

# collectionPlusJson-php

version: 1.0.0

## Introduction
>**Collection+JSON** is a JSON-based read/write hypermedia-type designed to support management and querying of simple collections.
>
>The **Collection+JSON** hypermedia type is designed to support full read/write capability for simple lists (contacts, >tasks, blog entries, etc.). The standard application semantics supported by this media type include Create, Read, Update, >and Delete (CRUD) along w/ support for predefined queries including query templates (similar to HTML "GET" forms). Write >operations are defined using a template object supplied by the server as part of the response representation."
>
>*From Collection+JSON [site](http://amundsen.com/media-types/collection/format/)*

## Example
```php

$colors = new Collection('http://api.colors.io/');

$colors->addLink(new Link($colors->getHref()->extend('rss'), 'feed', 'rss-feed', '', 'Subscribe to our RSS feed!'));

$color1 = new Item($colors->getHref()->extend('color1'));
$color1->addData('id', '1', 'This is the color id.')
       ->addData('hex_value', '#9932CC', 'This is the color in hex format.')
       ->addData('human_value', 'DarkOrchid', 'This is the color in human readable format.');
$color1->addLink(new Link('http://www.w3schools.com/tags/ref_colornames.asp', 'source'));
$color1->addLink(new Link('http://www.w3schools.com/tags/ref_color_tryit.asp?hex=9932CC', 'color-test'));

$color2 = new Item($colors->getHref()->extend('color2'));
$color2->addData('id', '2', 'This is the color id.')
       ->addData('hex_value', '#FFFFF0', 'This is the color in hex format.')
       ->addData('human_value', 'Ivory', 'This is the color in human readable format.');
$color2->addLink(new Link('http://www.w3schools.com/tags/ref_colornames.asp', 'source'));
$color2->addLink(new Link('http://www.w3schools.com/tags/ref_color_tryit.asp?hex=FFFFF0', 'color-test'));

$colors->addItems([$color1, $color2]);

$query = new Query($colors->getHref()->extend('search'), 'search');
$query->addData('search', '');
$colors->addQuery($query);

$template = new Template();
$template->addData('id', '', 'This is the color id.')
         ->addData('hex_value', '', 'This is the color in hex format.')
         ->addData('human_value', '', 'This is the color in human readable format.')
         ->addData('source', '', 'Link to colors source.')
         ->addData('color-test', '', 'Link to test how your color looks with other colors.');
$colors->setTemplate($template);

$error = new Error('error-test', 'ABC123', 'This is a test error. Server has encountered a problem and could not process your request, please try later.');
$colors->setError($error);

$app->response->headers->set('Content-Type', 'application/json');
echo json_encode($colors->output());

/*
Output would be:

{
    "collection": {
        "version": "0.5.2",
        "href": "http://api.colors.io/",
        "links": [
            {
                "href": "http://api.colors.io/rss",
                "rel": "feed",
                "prompt": "Subscribe to our RSS feed!",
                "name": "rss-feed",
                "render": ""
            }
        ],
        "items": [
            {
                "href": "http://api.colors.io/color1",
                "data": [
                    {
                        "name": "id",
                        "value": "1",
                        "prompt": "This is the color id."
                    },
                    {
                        "name": "hex_value",
                        "value": "#9932CC",
                        "prompt": "This is the color in hex format."
                    },
                    {
                        "name": "human_value",
                        "value": "DarkOrchid",
                        "prompt": "This is the color in human readable format."
                    }
                ],
                "links": [
                    {
                        "href": "http://www.w3schools.com/tags/ref_colornames.asp",
                        "rel": "source",
                        "prompt": "",
                        "name": "",
                        "render": ""
                    },
                    {
                        "href": "http://www.w3schools.com/tags/ref_color_tryit.asp?hex=9932CC",
                        "rel": "color-test",
                        "prompt": "",
                        "name": "",
                        "render": ""
                    }
                ]
            },
            {
                "href": "http://api.colors.io/color2",
                "data": [
                    {
                        "name": "id",
                        "value": "2",
                        "prompt": "This is the color id."
                    },
                    {
                        "name": "hex_value",
                        "value": "#FFFFF0",
                        "prompt": "This is the color in hex format."
                    },
                    {
                        "name": "human_value",
                        "value": "Ivory",
                        "prompt": "This is the color in human readable format."
                    }
                ],
                "links": [
                    {
                        "href": "http://www.w3schools.com/tags/ref_colornames.asp",
                        "rel": "source",
                        "prompt": "",
                        "name": "",
                        "render": ""
                    },
                    {
                        "href": "http://www.w3schools.com/tags/ref_color_tryit.asp?hex=FFFFF0",
                        "rel": "color-test",
                        "prompt": "",
                        "name": "",
                        "render": ""
                    }
                ]
            }
        ],
        "queries": [
            {
                "href": "http://api.colors.io/search",
                "rel": "search",
                "prompt": "",
                "data": [
                    {
                        "name": "search",
                        "value": null,
                        "prompt": ""
                    }
                ]
            }
        ],
        "template": [
            {
                "name": "id",
                "value": "",
                "prompt": "This is the color id."
            },
            {
                "name": "hex_value",
                "value": "",
                "prompt": "This is the color in hex format."
            },
            {
                "name": "human_value",
                "value": "",
                "prompt": "This is the color in human readable format."
            },
            {
                "name": "source",
                "value": "",
                "prompt": "Link to colors source."
            },
            {
                "name": "color-test",
                "value": "",
                "prompt": "Link to test how your color looks with other colors."
            }
        ],
        "error": {
            "title": "error-test",
            "code": "ABC-123",
            "message": "This is a test error. Server has encountered a problem and could not process your request, please try later."
        }
    }
}

*/

```
