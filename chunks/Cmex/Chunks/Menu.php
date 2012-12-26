<?php

namespace Cmex\Chunks;

class Menu extends \Chunk {
    public function config() {
        return "";
    }

    public function show($properties=array()) {
        /*$menu = array(
            array(
                'title' => 'Startseite', 
                'page' => 'home', 
                'children' => array()
            ), 
            array(
                'title' => 'Über uns', 
                'page' => 'aboutus', 
                'children' => array(
                    array(
                        'title' => 'Kontakt', 
                        'page' => 'contact', 
                        'children' => array()
                    ),
                    array(
                        'title' => 'cancrisoft.net',
                        'extern' => 'http://cancrisoft.net',
                        'children' => array()
                    )
                )
            )
        );*/

        //\Asset::add("jquery", "http://code.jquery.com/jquery.min.js");
        return $this->makeMenu(json_decode($this->content));
    }

    /**
     * This function creates recursively the menu from the JSON-Data
     * Please note, that it can get quite slow, the deeper
     * your menu structure is!
     * @param $menu array deserialized JSON-data
     * @return HTML tree
     */
    private function makeMenu($menu) {
        $ret = "<ul>";
        foreach($menu as $item) {
            $href = "";
            if(property_exists($item, 'page')) {
                $href = \URL::to($item->page);
            } else if(property_exists($item, 'extern')) {
                $href = $item->extern;
            }

            $class = '';
            if(property_exists($item, 'page') && $item->page == $this->properties[0]) {
                $class = ' class="active"';
            }

            $ret .= '<li><a'.$class.' href="'.$href.'">' . $item->title . "</a>";
            if(!empty($item->children)) {
                $ret .= $this->makeMenu($item->children);
            }
            $ret .= "</li>";
        }
        $ret .= "</ul>";
        return $ret;
    }

    public function handleInput($data) {
        
    }
}