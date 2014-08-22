<?php

namespace CollectionPlusJson;

use CollectionPlusJson\Util\Href;

class Collection
{

    const VERSION = '0.5.0';

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
     * @param string $href|Href
     */
    public function __construct( $href )
    {
        if(!$href instanceof Href){
            $href = new Href($href);
        }
        $this->href = $href;
    }

    /**
     * @return Href
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
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
     * @param Item[] $items
     */
    public function addItems(array $items)
    {
        foreach ($items as $item)
        {
            $this->addItem($item);
        }
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
    public function output()
    {
        $properties = get_object_vars( $this );
        $wrapper = new \stdClass();
        $collection = new \StdClass();
        $collection->version = $this->getVersion();
        foreach ($properties as $name => $value) {
            if (is_array( $value )) {
                foreach ($value as &$val) {
                    if (is_object( $val )) {
                        $val = $val->output();
                    }
                }
            }
            if (is_object( $value ) && !$value instanceof \StdClass) {
                $value = $value->output();
            }
            $collection->$name = $value;
        }
        $wrapper->collection = $collection;
        return $wrapper;
    }
}