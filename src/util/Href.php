<?php

namespace CollectionPlusJson\Util;

class Href {

    /** @var  string */
    protected $uri;

    const URI_REGEXP = '#^(https?:\/\/)?(([a-z]+\.)+([a-z]+){1,})?((\/[a-z0-9]+){0,})\/?$#';

    /**
     * @param $uri
     * @throws \Exception
     */
    public function __construct( $uri )
    {
        if ( !empty($uri)
            && preg_match( self::URI_REGEXP, $uri ) == false ) {
            throw new \Exception( 'Invalid URI' );
        }
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function _output()
    {
        return $this->getUri();
    }

} 