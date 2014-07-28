<?php

namespace CollectionPlusJson;


class Error
{

    /** @var  string */
    protected $title;

    /** @var  string */
    protected $code;

    /** @var  string */
    protected $message;

    /**
     * @param $title
     * @param $code
     * @param $message
     */
    public function __construct( $title, $code, $message )
    {
        $this->title = $title;
        $this->code = $code;
        $this->message = $message;
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