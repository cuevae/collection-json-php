<?php

namespace CollectionPlusJson;

use \CollectionPlusJson\Util\Href;

class Item extends DataEditor
{

    /** @var Href */
    protected $href;

    /** @var  Link[] */
    protected $links = array();

    /**
     * @param string|Href $href
     */
    public function __construct( $href )
    {
        if(!$href instanceof Href){
            $href = new Href($href);
        }
        $this->href = $href;
    }

    /**
     * @param string|Href $href
     * @return Item
     */
    public function setHref( Href $href )
    {
        if(!$href instanceof Href){
            $href = new Href($href);
        }
        $this->href = $href;
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
     * @param Link $link
     * @return Item
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
    /**
     * Get a data object value by name
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if(preg_match('#^get(.+)#', $name, $match)){
            foreach ($this->data as $data) {
                if($data->getName() == lcfirst($match[1])){
                    return $data->getValue();
                }
            }
            $this->triggerNoMethodError($name);
        } else if(preg_match('#^set(.+)#', $name, $match)) {
            foreach ($this->data as $data) {
                if($data->getName() == lcfirst($match[1])){
                    $data->setValue($arguments[0]);
                    if (isset($arguments[1])) {
                        $data->setPrompt($arguments[1]);
                    }
                    return $this;
                }
            }
            $this->triggerNoMethodError($name);
        } else {
            $this->triggerNoMethodError($name);
        }
    }
}
