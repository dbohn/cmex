<?php

namespace Chunks\Cmex;

class Menu extends \Chunk {

    public function show() {
        return $this->makeMenu($this->name);
    }

    public function handleInput($data) {
        
    }

    public function annotate()
    {
        return null;
    }

    /**
     * Creates the menu. It is using Nested sets for storage
     * So building the menu is done in linear time
     * @param $menu string name of the menu which should be rendered
     * @return HTML tree
     */
    private function makeMenu($menu, $startLeft=1) {
        //$items = \DB::table('menu')->select(\DB::raw('COUNT(*)-1 as level, title, ROUND((rgt-lft-1)/2) AS offspring'))->get();
        $pfx = \Config::get('database.connections.'.\Config::get('database.default').'.prefix');

        $items = \DB::select(
            'SELECT n.title as ptitle, n.path as path, COUNT(*)-1 AS level, 
            ROUND ((n.rgt - n.lft - 1) / 2) AS offspring
            FROM '.$pfx.'menu AS n,
            '.$pfx.'menu AS p
            WHERE n.lft BETWEEN p.lft AND p.rgt AND n.menu = ? AND p.menu = ?
            GROUP BY n.lft
            ORDER BY n.lft',
            array($menu, $menu)
        );

        $ret = '';
        $curLevel = 0;

        foreach($items as $item) {
            if($curLevel > $item->level) {
                $ret .= '</ul></li>';
                $curLevel--;
            }

            if($item->ptitle != 'root') {
                $class = '';
                if($item->path == \ChunkManager::getPageIdentifier()) {
                    $class = ' class="active"';
                }

                $ret .= '<li><a href="'.\URL::to($item->path).'"'. $class . '>' . $item->ptitle . '</a>';
            }

            if($item->offspring > 0) {
                $ret .= '<ul>';
                $curLevel++;
            } else {
                $ret .= '</li>';
            }
        }
        while($curLevel > 1) {
            $ret .= '</ul></li>';
            $curLevel--;
        }
        $ret .= '</ul>';

        return $ret;
    }
}