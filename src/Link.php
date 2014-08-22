<?php

namespace CollectionPlusJson;

use \CollectionPlusJson\Util\Href;

class Link
{

    /** @var  Href */
    protected $href;

    /** @var  string */
    protected $rel;

    /** @var  string */
    protected $prompt;

    /** @var  string */
    protected $name;

    /** @var  string */
    protected $render;

    /**
     * @param string|Href $href
     * @param string $rel
     * @param string $name
     * @param string $render
     * @param string $prompt
     */
    public function __construct( $href, $rel, $name = '', $render = '', $prompt = '' )
    {
        if(!$href instanceof Href){
            $href = new Href($href);
        }
        $this->href = $href;
        $this->rel = $rel;
        $this->name = $name;
        $this->render = $render;
        $this->prompt = $prompt;
    }

    /**
     * @param string|Href $href
     */
    public function setHref( $href )
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
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $prompt
     */
    public function setPrompt( $prompt )
    {
        $this->prompt = $prompt;
    }

    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param string $rel
     */
    public function setRel( $rel )
    {
        $this->rel = $rel;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @param string $render
     */
    public function setRender( $render )
    {
        $this->render = $render;
    }

    /**
     * @return string
     */
    public function getRender()
    {
        return $this->render;
    }

    /**
     * @return \StdClass
     */
    public function output()
    {
        $properties = get_object_vars( $this );
        $object = new \StdClass();
        foreach ($properties as $name => $value) {
            if (is_object( $value ) && !$value instanceof \StdClass) {
                $value = $value->output();
            }
            $object->$name = $value;
        }
        return $object;
    }
}