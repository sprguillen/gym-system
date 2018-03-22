<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');


class Breadcrumbs {

    public function __construct() {
        $this->crumbs = [];
    }

    /**
     * Set values for breadcrumbs
     * @param [string] $crumb
     */
    public function set($crumb) {

        array_push($this->crumbs, $crumb);
    }   

    /**
     * Get all breadcrumbs stored in the array
     * @return [array] breadcrumbs 
     */
    public function get() {
        return $this->crumbs;
    }

}