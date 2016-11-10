<?php

namespace CollectionPlusJson\Util;

use CollectionPlusJson\Util\Href\Exception\InvalidUrl;

class Href
{

    /** @var  string */
    protected $url;

    /** RegExp to identify valid URLs */
    const URL_REGEXP = '#^(https?:\/\/)?((([a-z0-9])+\.?)+([a-z0-9]+){1,}(:\d+)?)?((\/[a-z0-9]+([.\-_a-z0-9]+)?){0,})\/?(\?[a-z0-9]+\=(.*?)(\&[a-z0-9]+\=(.*?))?)?$#';

    /**
     * @param $url
     * @param $validate flag to validate url
     *
     * @throws InvalidUrl
     */
    public function __construct( $url, $validate = true )
    {
        $this->url = $url;
        if ($validate) {
            $this->validate();
        }
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

    /**
     * @param $key
     * @param $value
     */
    public function replace( $key, $value )
    {
        $this->url = str_replace("{" . $key . "}", $value, $this->getUrl());

        return $this;
    }

    /**
     * Validate the url
     *
     */
    public function validate()
    {
        if (!$this->isValid( $this->getUrl() )) {
            throw new InvalidUrl( sprintf( '"%s" is not a valid url', $this->url ) );
        }

        return $this;
    }
}
