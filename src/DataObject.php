<?php

namespace CollectionPlusJson;


class DataObject
{

    /** @var  string */
    protected $name;

    /** @var  string|int|float|bool|null|array|object */
    protected $value;

    /** @var  string */
    protected $prompt;

    /**
     * @param $name
     * @param null $value
     * @param string $prompt
     *
     * @throws \Exception
     */
    public function __construct( $name, $value = null, $prompt = '' )
    {
        if (is_string( $value )
            || is_int( $value )
            || is_double( $value )
            || is_array( $value )
            || is_bool( $value )
            || is_null( $value )
            || is_array( $value )
            || is_object( $value )
        ) {
            $this->name = $name;
            $this->value = $value;
            $this->prompt = $prompt;
        } else {
            throw new \Exception(
                'Type of value is not accepted. Accepted values are: string|int|float|bool|null|array|object' );
        }
    }

    /**
     * @param string $name
     * @return DataObject
     */
    public function setName( $name )
    {
        $this->name = $name;
        return $this;
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
     * @return DataObject
     */
    public function setPrompt( $prompt )
    {
        $this->prompt = $prompt;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param array|bool|float|int|null|object|string $value
     * @return DataObject
     */
    public function setValue( $value )
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return array|bool|float|int|null|object|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \StdClass
     */
    public function output()
    {
        $properties = get_object_vars( $this );
        $object = new \StdClass();
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }
        return $object;
    }
}
