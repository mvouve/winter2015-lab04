<?php

/**
 * Data access wrapper for "orders" table.
 *
 * @author jim
 */
class Orders extends MY_Model {

    // constructor
    function __construct() {
        parent::__construct('orders', 'num');
    }

    // add an item to an order
    function add_item($num, $code) {
        $CI = &get_instance();
        
        if($CI->orderitems->exists($num, $code))
        {
            $instance = $CI->orderitems->get($num, $code);
            $instance->quantity++;
            $CI->orderitems->update($instance);
        }
        else
        {
            $instance = $CI->orderitems->create();
            $instance->order = $num;
            $instance->item = $code;
            $instance->quantity = 1;
            $CI->orderitems->add($instance);
        }
    }

    // calculate the total for an order
    function total($num) {
        $this->load->model('orderitems');
        
        $result = 0.0;
        $items = $this->orderitems->some('order', $num);
        
        foreach( $items as $item )
        {
           $menuitem = $this->menu->get($item->item);
           $result = $item->quantity * $menuitem->price;
        }
        
        return $result;
    }

    // retrieve the details for an order
    function details($num) {
        
    }

    // cancel an order
    function flush($num) {
        
    }

    // validate an order
    // it must have at least one item from each category
    function validate($num) {
        return false;
    }

}
