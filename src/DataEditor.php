<?php

namespace CollectionPlusJson;

/**
 * Implements magic methods to get and set by method name
 *
 * @abstract
 */
abstract class DataEditor
{
    /** @var  DataObject[] */
    protected $data = array();

    /**
     * @param $name
     * @throws \Exception
     * @return mixed
     */
    public function addData( $name, $value = '', $prompt = '')
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
     * Method not found error
     */
    protected function triggerNoMethodError()
    {
        trigger_error("Call to undefined method " . __CLASS__ . '::' . $name . '()', E_USER_ERROR);;
    }
}

