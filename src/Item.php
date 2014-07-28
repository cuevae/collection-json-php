<?php

namespace CollectionPlusJson;

use \CollectionPlusJson\Util\Href;

class Item
{

    /** @var Href */
    protected $href;

    /** @var  DataObject[] */
    protected $data = array();

    /** @var  Link[] */
    protected $links = array();

    public function __construct( Href $href )
    {
        $this->href = $href;
    }

    /**
     * @param \CollectionPlusJson\Util\Href $href
     * @return Item
     */
    public function setHref( Href $href )
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @return \CollectionPlusJson\Util\Href
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param Link $link
     * @return Item
     */
    public function addLink( Link $link )
    {
        $this->links[] = $link;
        return $this;
    }


    /**
     * @return \CollectionPlusJson\Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param $name
     * @param $value
     * @param string $prompt
     *
     * @throws \Exception
     *
     * @return Item
     */
    public function addData( $name, $value, $prompt = '' )
    {
        try {
            $dataObject = new DataObject( $name, $value, $prompt );
            $this->data[] = $dataObject;
        } catch ( \Exception $e ) {
            throw new \Exception( 'Object could not be added: ' . $e->getMessage() );
        }
        return $this;
    }

    /**
     * @return \CollectionPlusJson\DataObject[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return \StdClass
     */
    public function output()
    {
        $properties = get_object_vars( $this );
        $object = new \StdClass();
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
            $object->$name = $value;
        }
        return $object;
    }
}