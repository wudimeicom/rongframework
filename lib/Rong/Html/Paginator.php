<?php

class Rong_Html_Paginator
{

    public $PaginationData;
    public $labelFirst = "|&lt;";
    public $labelPrev = "&lt;";
    public $labelNext = "&gt;";
    public $labelLast = "&gt;|";
    public $linkCount = 15;
    public function __construct($PaginationData)
    {
        $this->PaginationData = $PaginationData;
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
        return $this->fillUrlTemplate($urlTemplate, array("Page" => $pageNumber , "PageSize" => $this->PaginationData["PageSize"]));
    }

    public function getPaginatorHtml($urlTemplate)
    {
        $str = "";
        if ($this->PaginationData["PageCount"] > 1)
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, 1) . "\">" .
                    $this->labelFirst . "</a>";
        }
        if (( $this->PaginationData["Page"] - 1 ) > 1)
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $this->PaginationData["Page"] - 1) . "\">" .
                    $this->labelPrev . "</a>";
        }

        $halfOfCount = ceil($this->linkCount / 2);
        for ($i = ( $this->PaginationData["Page"] - $halfOfCount ); $i < ( $this->PaginationData["Page"] + $halfOfCount ); $i++)
        {
            if ($i > 0 && $i <= $this->PaginationData["PageCount"])
            {
                if ($i == $this->PaginationData["Page"])
                {

                    $str .= "<span>" . $i . "</span>";
                } else
                {
                    $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $i) . "\"";
                    $str .= ">" . $i . "</a>";
                }
            }
        }
        if (( $this->PaginationData["Page"] + 1 ) < $this->PaginationData["PageCount"])
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $this->PaginationData["Page"] + 1) . "\">" .
                    $this->labelNext  . "</a>";
        }

        if (( $this->PaginationData["Page"] ) < $this->PaginationData["PageCount"])
        {
            $str .= "<a href=\"" . $this->fillUrlTemplateWithPage($urlTemplate, $this->PaginationData["PageCount"]) . "\">" .
                    $this->labelLast  . "</a>";
        }
        return $str;
    }

}

?>
