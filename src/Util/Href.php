<?php

namespace CollectionPlusJson\Util;

use CollectionPlusJson\Util\Href\Exception\InvalidUrl;

class Href
{
    /** @var  string */
    protected $url;

    /** RegExp to identify valid URLs */
    const URL_REGEXP = '#^(https?:\/\/)?((([a-z0-9])+\.?)+([a-z0-9]+){1,}(:\d+)?)?((\/[a-z0-9]+([.\-_a-z0-9]+)?){0,})\/?(\?[a-z0-9]+\=(.*?)(\&[a-z0-9]+\=(.*?))?)?$#i';

    /**
     * @param $url
     * @param $validate flag to validate url
     *
     * @throws InvalidUrl
     */
    public function __construct( $url, $validate = false )
    {
        if ($validate && !$this->isValid( $url )) {
            throw new InvalidUrl( sprintf( '"%s" is not a valid url', $url ) );
        }

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
     * Concat an extension to the url
     * 
     * @param $ext
     * @param $validate flag to validate url
     * @return Href
     *
     * @throws InvalidUrl
     */
    public function extend( $ext, $validate = false )
    {
        return new Href( $this->getUrl() . $ext, $validate );
    }

    /**
     * @return string
     */
    public function output()
    {
        return $this->getUrl();
    }

    /**
     * Replace a substring for making URL templates
     * 
     * @param $key
     * @param $value
     *
     * @return Href
     */
    public function replace( $key, $value )
    {
        if($value === "" || is_null($value) || $value === false) {
            $this->url = preg_replace("#/{" . $key . "}.*$#", "", $this->getUrl());
        } else {
            $this->url = str_replace("{" . $key . "}", $value, $this->getUrl());
        }

        return $this;
    }

    /**
     * Validate the url
     *
     * @return Href
     */
    public function validate()
    {
        if (!$this->isValid( $this->getUrl() )) {
            throw new InvalidUrl( sprintf( '"%s" is not a valid url', $this->url ) );
        }

        return $this;
    }
}
