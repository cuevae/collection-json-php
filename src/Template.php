<?php

namespace CollectionPlusJson;

class Template extends DataEditor
{
    /**
     * Override the default method
     *
     * @param string $name The name of the data
     * @param string $prompt The prompt name
     * @param string $value The value. Note: this is ignored 
     */
    public function addData( $name, $prompt = '', $value = '' )
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
                if($data->getName() == lcfirst($match[1])){
                    return $data->getValue();
                }
            }
            $this->triggerNoMethodError($name);
        } else if(preg_match('#^set(.+)#', $name, $match)) {
            foreach ($this->data as $data) {
                if($data->getName() == lcfirst($match[1])){
                    $data->setValue($arguments[0]);
                    return $this;
                }
            }
            $this->triggerNoMethodError($name);
        } else {
            $this->triggerNoMethodError($name);
        }
    }

    /**
     * Import Item object into template
     *
     * @return Template
     */
    public function importItem(Item $item)
    {
        foreach ($this->data as $templateData) {
            foreach ($item->getData() as $itemData) {
                if ($itemData->getName() === $templateData->getName()) {
                    $templateData->setName($itemData->getName());
                    $templateData->setValue($itemData->getValue());
                    $templateData->setPrompt($itemData->getPrompt());
                }
            }
        }

        return $this;
    }
}
