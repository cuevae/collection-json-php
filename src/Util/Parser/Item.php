<?php


namespace CollectionPlusJson\Util\Parser;

use \CollectionPlusJson\Item as CollectionItem;
use CollectionPlusJson\Util\Href;

class Item
{

    const HREF_KEY = 'href';
    const DATA_KEY = 'data';

    /**
     * @var array
     */
    protected $required = array();

    public function __construct()
    {
        $this->required[] = static::HREF_KEY;
    }

    /**
     * @param array $input
     *
     * @return CollectionItem
     */
    protected function itemInit(array $input)
    {
        return new CollectionItem(new Href($input[static::HREF_KEY]));
    }

    /**
     * @param array $input
     *
     * @return CollectionItem
     *
     * @throws \Exception
     */
    public function parseOneFromArray(array $input)
    {
        if (true !== ($result = $this->hasRequiredKeys($input)))
        {
            throw new \Exception('Required elements not present: ' . print_r($result, true) . ' missing.' . PHP_EOL);
        }

        //Initialize item
        try
        {
            $item = $this->itemInit($input);
        } catch (\Exception $e)
        {
            throw new \Exception('Unable to initialize Item: ' . $e->getMessage() . PHP_EOL);
        }

        //Append data
        if (isset($input[static::DATA_KEY]))
        {
            $data = $input[static::DATA_KEY];
            if (true !== $this->isValidDataArray($data))
            {
                throw new \Exception('Item data cannot be parsed. Check it\'s format is the following
                \'data\' => array( array( \'name\', \'value\', \'prompt\') ). You can add as many inner arrays as you
                like, name is the only required field');
            }
        }

        return $item;
    }

    /**
     * Checks if the data for a given item is correct
     *
     * @param array $data
     *
     * @return bool
     */
    public function isValidDataArray(array $data)
    {
        if (count($data) === 0)
        {
            return true;
        }

        $result = true;
        foreach ($data as $object)
        {
            if (!is_array($object))
            {
                $result = false;
                break;
            }
            if (count($object) < 2)
            {
                $result = false;
                break;
            }
            $name = current($object);
            if(empty($name)){
                $result = false;
                break;
            }
            next($object);
            $value = current($object);
            if(!is_string( $value )
               && !is_int( $value )
               && !is_double( $value )
               && !is_array( $value )
               && !is_bool( $value )
               && !is_null( $value )
               && !is_object( $value )
            ){
                $result = false;
                break;
            }
        }

        return $result;
    }

    /**
     * Return TRUE when the input has the required keys, othewise it will return an arrays
     * containing the list of required keys
     *
     * @param array $input
     *
     * @return array|bool
     */
    public function hasRequiredKeys(array $input)
    {
        $control = array_intersect($this->required, array_keys($input));

        if ($this->required !== $control)
        {
            return $this->required;
        }

        return true;
    }

} 