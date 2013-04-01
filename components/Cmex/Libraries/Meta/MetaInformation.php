<?php

namespace Cmex\Libraries\Meta;

use Illuminate\Html\HtmlBuilder;

class MetaInformation
{
    private $elements = array();
    private $usedCharset = "utf-8";

    private $html = null;

    public function __construct(HtmlBuilder $html)
    {
        $this->html = $html;
    }

    public function link($rel, $type, $href = "", $title = "")
    {
        $link = array('rel' => $rel, 'type' => $type);
        if ($href != "") {
            $link["href"] = $href;
        }

        if ($title != "") {
            $link["title"] = $title;
        }

        if (func_num_args() > 4 && is_array(func_get_arg(3))) {
            $link = $link + func_get_arg(4);
        }

        $this->element('link', $link, '');

    }

    public function meta($name, $content, $ishttp = false)
    {
        if (!! $ishttp) {
            $meta = array('http-equiv' => $name, 'content' => $content);
        } else {
            $meta = array('name' => $name, 'content' => $content);
        }

        if (func_num_args() > 3 && is_array(func_get_arg(3))) {
            $meta = $meta + func_get_arg(3);
        }

        $this->element('meta', $meta, '');

    }

    public function charset($char)
    {
        $this->usedCharset = $char;
    }

    public function element($tag, $attributes, $content)
    {
        $this->elements[] = array(
            "tag" => $tag,
            "attributes" => $attributes,
            "content" => $content
        );
    }

    public function generate()
    {
        $tags = "";

        // Generate elements
        foreach ($this->elements as $element) {
            $tags .= $this->createTag($element['tag'], $element['attributes'], $element["content"]);
        }

        // Add charset
        $tags .= $this->createTag('meta', array('charset' => $this->usedCharset));

        return $tags;
    }

    public function head()
    {
        return "__head__";
    }

    private function createTag($tagname, $attributes, $contents = "")
    {
        $attStr = $this->html->attributes($attributes);

        if ($contents !== "") {
            return '<'.$tagname.' '.$attStr.'>'.$contents.'</'.$tagname.'>';
        }

        return '<'.$tagname. $attStr . " />\n";
    }
}
