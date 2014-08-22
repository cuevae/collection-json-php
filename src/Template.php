<?php

namespace CollectionPlusJson;

class Template
{

    /** @var  DataObject[] */
    protected $data = array();

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
        foreach ($objects as &$val) {
            $val = $val->output();
        }
        return $objects;
    }
}