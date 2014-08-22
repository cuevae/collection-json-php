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

    /** @var  DataObject[] */
    protected $data;

    /**
     * @param string|Href $href
     * @param string $rel
     * @param string $prompt
     */
    public function __construct( $href, $rel, $prompt = '' )
    {
        if(!$href instanceof Href){
            $href = new Href($href);
        }
        $this->href = $href;
        $this->rel = $rel;
        $this->prompt = $prompt;
        $this->data = array();
    }

    /**
     * @param string|Href $href
     * @return Query
     */
    public function setHref( $href )
    {
        if(!$href instanceof Href){
            $href = new Href($href);
        }
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
     * @param $name
     * @throws \Exception
     * @return Query
     */
    public function addData( $name )
    {
        try {
            $dataObject = new DataObject( $name );
            $this->data[] = $dataObject;
        } catch ( \Exception $e ) {
            throw new \Exception( 'Object could not be added: ' . $e->getMessage() );
        }
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