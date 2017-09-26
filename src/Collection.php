<?php

namespace CollectionPlusJson;

use CollectionPlusJson\Util\Href;

class Collection
{

    const VERSION = '1.0';

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

    /** @var  string */
    private $json = array();

    /** @var  string */
    private $version;

    /**
     * @param string $href|Href
     */
    public function __construct( $data )
    {
        if($data instanceof Href){
            $this->href = $data;
        } else if(is_array($data)){

            //assign the json data array
            $this->json = $data['collection'];
            $this->assignVersion();
            $this->assignHref();
            $this->assignError();
            $this->assignLinks();
            $this->assignItems();
            $this->assignTemplate();
            $this->assignQueries();
        } else {
            $this->href = new Href($data);
        }
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
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        if(!is_null($this->version)) {
            $version = $this->version;
        } else {
            $version = self::VERSION;
        }

        return $version;
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
     * getFirstItem
     *
     * @return 
     */
    public function getFirstItem()
    {
        $items = $this->getItems();
        if (isset($items[0])) {
            return $items[0];
        }

        return null;
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
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
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
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return \StdClass
     */
    public function output()
    {
        //$properties = get_object_vars( $this );
        $properties = array(
            'version' => $this->getVersion(),
            'href' => $this->href,
            'links' => $this->links,
            'items' => $this->items,
            'queries' => $this->queries,
            'template' => $this->template,
            'error' => $this->error,
        );
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

    private function assignVersion()
    {
        if (isset($this->json['version'])) {
            $this->version = $this->json['version'];
        }
    }

    private function assignHref()
    {
        if (isset($this->json['href'])) {
            $this->href = new Href($this->json['href']);
        }
    }

    private function assignItems()
    {
        if (isset($this->json['items'])) {
            foreach ($this->json['items'] as $item) {
                $itemObject = new Item($item['href']);
                foreach ($item['data'] as $data) {
                    $itemObject->addData($data['name'], $data['value'], $data['prompt']);
                }
                foreach ($item['links'] as $link) {
                    $itemObject->addLink(new Link($link['href'], $link['rel'], $link['name'], $link['render'], $link['prompt']));
                }
                $this->items[] = $itemObject;
            }
        }
    }

    private function assignTemplate()
    {
        if (isset($this->json['template'])) {
            $this->template = new Template();
            foreach ($this->json['template'] as $template) {
                $this->template->addData($template['name'], $template['prompt']);
            }
        }
    }

    private function assignLinks()
    {
        if (isset($this->json['links'])) {
            foreach ($this->json['links'] as $link) {
                $this->links[] = new Link($link['href'], $link['rel'], $link['name'], $link['render'], $link['prompt']);
            }
        }
    }

    private function assignQueries()
    {
        if (isset($this->json['queries'])) {
            foreach ($this->json['queries'] as $query) {
                $queryObject = new Query($query['href'], $query['rel'], $query['prompt']);
                foreach ($query['data'] as $data) {
                    $queryObject->addData($data['name'], $data['value'], $data['prompt']);
                }
                $this->queries[] = $queryObject;
            }
        }
    }

    private function assignError()
    {
        if (isset($this->json['error'])) {
            $error = $this->json['error'];
            $this->error = new Error($error['title'], $error['code'], $error['message']);
        }
    }
}
