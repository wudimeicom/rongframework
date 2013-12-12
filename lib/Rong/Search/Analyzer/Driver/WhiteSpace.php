<?php
require_once 'Rong/Search/Analyzer/Interface.php';
class Rong_Search_Analyzer_Driver_WhiteSpace implements Rong_Search_Analyzer_Interface
{
     public $max_word_count = 409600;
    public function __construct( $config )
    {
        
    }

    /**
     *
     * @param string $text
     * @return array $keywords
     */
    public function analyze( $text )
    {
        $keywords = preg_split("/[\s,\.\?;\-!\/\:\"\'\*]+/", $text );
        $keywords= array_filter( $keywords);
        return $keywords;
    }

    public function getProcessTime()
    {
        return 0;
    }

    public function getLoadingTime()
    {
        return 0;
    }


    public function setMaxWordCount( $newCount )
    {
        $this->max_word_count = $newCount;
    }
}