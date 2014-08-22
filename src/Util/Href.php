<?php

namespace CollectionPlusJson\Util;

use CollectionPlusJson\Util\Href\Exception\InvalidUrl;

class Href
{

    /** @var  string */
    protected $url;

    /** RegExp to identify valid URLs */
    const URL_REGEXP = '#^(https?:\/\/)?((([a-z0-9])+\.?)+([a-z0-9]+){1,}(:\d+)?)?((\/[a-z0-9]+([.\-_a-z0-9]+)?){0,})\/?$#';

    /**
     * @param $url
     *
     * @throws InvalidUrl
     */
    public function __construct( $url )
    {
        if (!$this->isValid( $url )) {
            throw new InvalidUrl( sprintf( '"%s" is not a valid url', $url ) );
        }

        $this->url = $url;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function isValid( $url )
    {
        return preg_match( self::URL_REGEXP, $url ) != false;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $ext
     * @return Href
     *
     * @throws InvalidUrl
     */
    public function extend( $ext )
    {
        return new Href( $this->getUrl() . $ext );
    }


    /**
     * @return string
     */
    public function output()
    {
        return $this->getUrl();
    }
}