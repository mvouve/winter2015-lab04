<?php

/**
 * Order handler
 * 
 * Implement the different order handling usecases.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Order extends Application {

    function __construct() {
        parent::__construct();
    }

    // start a new order
    function neworder() {
        
        $order_num = $this->orders->highest() + 1;
        
        $record = $this->orders->create();
        $record->num = $order_num;
        $record->date = time();
        $record->status = 'o';
        $this->orders->add($record );
        

        redirect('/order/display_menu/' . $order_num);
    }

    // add to an order
    function display_menu($order_num = null) {
        if ($order_num == null)
            redirect('/order/neworder');

        $this->data['pagebody'] = 'show_menu';
        $this->data['order_num'] = $order_num;
        
        //get menu info
        $order = $this->orders->get($order_num);
        

        // Make the columns
        $this->data['meals'] = $this->make_column('m');
        $this->data['drinks'] = $this->make_column('d');
        $this->data['sweets'] = $this->make_column('s');
        $this->data['title'] = $order_num;
        foreach( $this->data['meals'] as &$item )
        {
            $item->order_num = $order_num;
        }
        foreach( $this->data['drinks'] as &$item )
        {
            $item->order_num = $order_num;
        }
        foreach( $this->data['sweets'] as &$item )
        {
            $item->order_num = $order_num;
        }

        $this->render();
    }

    // make a menu ordering column
    function make_column($category) {
        $items = $this->menu->some('category', $category );
        
        return $items;
    }

    // add an item to an order
    function add($order_num, $item) {
        //FIXME
        redirect('/order/display_menu/' . $order_num);
    }

    // checkout
    function checkout($order_num) {
        $this->data['title'] = 'Checking Out';
        $this->data['pagebody'] = 'show_order';
        $this->data['order_num'] = $order_num;
        $this->data['total'] = $this->orders->total($order_num);
        //FIXME

        $this->render();
    }

    // proceed with checkout
    function proceed($order_num) {
        //FIXME
        redirect('/');
    }

    // cancel the order
    function cancel($order_num) {
        //FIXME
        redirect('/');
    }

}
