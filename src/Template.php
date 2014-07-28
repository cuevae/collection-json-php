<?php

namespace CollectionPlusJson;

class Template
{

    /** @var  DataObject[] */
    protected $data = array();

    public function addData( DataObject $object )
    {
        $this->data[] = $object;
        return $this;
    }

    /**
     * @return DataObject[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function output()
    {
        $objects = $this->data ? : array();
        foreach ( $objects as &$val ) {
            $val = $val->output();
        }
        return $objects;
    }

} 