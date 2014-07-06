<?php

namespace CollectionPlusJson;

use CollectionPlusJson\Util\Href;


class Collection
{

    /** @var string */
    protected $version;

    /** @var  Href */
    protected $href;

    /** @var  Link[] */
    protected $links = array();

    /** @var  Item[] */
    protected $items = array();

    /** @var  Query[] */
    protected $queries = array();

    /** @var  Template */
    protected $template;

    /** @var  Error */
    protected $error;

    /**
     * @param string $version
     * @param Href $href
     */
    public function __construct( $version, Href $href )
    {
        $this->version = $version;
        $this->href = $href;
    }

    /**
     * @param Link $link
     * @return Collection
     */
    public function addLink( Link $link )
    {
        $this->links[] = $link;
        return $this;
    }

    /**
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param Item $item
     * @return Collection
     */
    public function addItem( Item $item )
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Query $query
     * @return Collection
     */
    public function addQuery( Query $query )
    {
        $this->queries[] = $query;
        return $this;
    }

    /**
     * @return Query[]
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * @param Template $template
     * @return Collection
     */
    public function setTemplate( Template $template )
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @param Error $error
     * @return Collection
     */
    public function setError( Error $error )
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return \StdClass
     */
    public function _output()
    {
        $properties = get_object_vars( $this );
        $object = new \StdClass();
        foreach ( $properties as $name => $value ) {
            if ( is_array( $value ) ) {
                foreach ( $value as &$val ) {
                    if ( is_object( $val ) ) {
                        $val = $val->_output();
                    }
                }
            }
            if ( is_object( $value ) && !$value instanceof \StdClass ) {
                $value = $value->_output();
            }
            $object->$name = $value;
        }
        return $object;
    }

} 