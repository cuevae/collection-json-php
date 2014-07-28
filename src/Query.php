<?php

namespace CollectionPlusJson;

use \CollectionPlusJson\Util\Href;

class Query
{

    /** @var  Href */
    protected $href;

    /** @var  string */
    protected $rel;

    /** @var  string */
    protected $prompt;

    /** @var  string */
    protected $name;

    /** @var  DataObject[] */
    protected $data;

    /**
     * @param Href $href
     * @param $rel
     * @param string $name
     * @param string $prompt
     * @param array $data
     */
    public function __construct( Href $href, $rel, $name = '', $prompt = '', $data = array() )
    {
        $this->href = $href;
        $this->rel = $rel;
        $this->name = $name;
        $this->prompt = $prompt;
        $this->data = $data;
    }

    /**
     * @param Href $href
     * @return Query
     */
    public function setHref( Href $href )
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @param string $rel
     * @return Query
     */
    public function setRel( $rel )
    {
        $this->rel = $rel;
        return $this;
    }

    /**
     * @param string $name
     * @return Query
     */
    public function setName( $name )
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $prompt
     * @return Query
     */
    public function setPrompt( $prompt )
    {
        $this->prompt = $prompt;
        return $this;
    }

    /**
     * @param DataObject $object
     * @return Query
     */
    public function addData( DataObject $object )
    {
        $this->data[] = $object;
        return $this;
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
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @return DataObject[]
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