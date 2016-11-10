<?php

namespace CollectionPlusJson;

class Template extends DataEditor
{
    /**
     * Override the default method
     */
    public function addData( $name, $prompt = '' )
    {
        return parent::addData($name, '', $prompt);
    }

    /**
     * @return array
     */
    public function output()
    {
        $objects = $this->data ? : array();
        foreach ($objects as &$val) {
            $val = $val->output();
        }
        return $objects;
    }

    /**
     * Get the query json
     * @return string
     */
    public function getQuery()
    {
        $properties = array(
            'data' => $this,
        );
        $wrapper = new \stdClass();
        $collection = new \StdClass();
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
        $wrapper->template = $collection;
        return json_encode($wrapper);
    }

    /**
     * Get a data object value by name
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if(preg_match('#^get(.+)#', $name, $match)){
            foreach ($this->data as $data) {
                if($data->getName() == lcfirst($match[0])){
                    return $data->getName();
                }
                $this->triggerNoMethodError();
            }
        } else if(preg_match('#^set(.+)#', $name, $match)) {
            foreach ($this->data as $data) {
                if($data->getName() == lcfirst($match[0])){
                    $data->setValue($arguments[0]);
                    return $this;
                }
                $this->triggerNoMethodError();
            }
        } else {
            $this->triggerNoMethodError();
        }
    }
}
