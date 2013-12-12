<?php

class Rong_Html_Paginator
{

    public $PageLink;
    public $labelFirst = "|&lt;";
    public $labelPrev = "&lt;";
    public $labelNext = "&gt;";
    public $labelLast = "&gt;|";
    public $linkCount = 15;
    public function __construct($PageLink)
    {
        $this->PageLink = $PageLink;
    }

    public function setSettingsArray( $settings )
    {
        foreach( $settings as $k => $v )
        {
            $this->$k = $v;
        }
    }
    public function fillUrlTemplate($urlTemplate, $nameValueArray)
    {
        if (!empty($nameValueArray))
        {
            foreach ($nameValueArray as $name => $value)
            {
                $urlTemplate = str_replace("{" . $name . "}", $value, $urlTemplate);
            }
        }
        return $urlTemplate;
    }

    public function fillUrlTemplateWithPage($urlTemplate, $pageNumber)
    {
        return $this->fillUrlTemplate($urlTemplate, array("Page" => $pageNumber , "PageSize" => $this->PageLink["PageSize"]));
    }

    public function getPaginatorHtml($urlTemplate)
    {
        $str = "";
        if ($this->PageLink["PageCount"] > 1)
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, 1) . "\">" .
                    $this->labelFirst . "</a>";
        }
        if (( $this->PageLink["Page"] - 1 ) > 1)
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $this->PageLink["Page"] - 1) . "\">" .
                    $this->labelPrev . "</a>";
        }

        $halfOfCount = ceil($this->linkCount / 2);
        for ($i = ( $this->PageLink["Page"] - $halfOfCount ); $i < ( $this->PageLink["Page"] + $halfOfCount ); $i++)
        {
            if ($i > 0 && $i <= $this->PageLink["PageCount"])
            {
                if ($i == $this->PageLink["Page"])
                {

                    $str .= "<span>" . $i . "</span>";
                } else
                {
                    $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $i) . "\"";
                    $str .= ">" . $i . "</a>";
                }
            }
        }
        if (( $this->PageLink["Page"] + 1 ) < $this->PageLink["PageCount"])
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $this->PageLink["Page"] + 1) . "\">" .
                    $this->labelNext  . "</a>";
        }

        if (( $this->PageLink["Page"] ) < $this->PageLink["PageCount"])
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $this->PageLink["PageCount"]) . "\">" .
                    $this->labelLast  . "</a>";
        }
        return $str;
    }

}

?>
