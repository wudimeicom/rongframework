<?php
interface Rong_Search_Analyzer_Interface
{
    public function analyze( $text );
    public function getProcessTime();
    public function getLoadingTime();
    public function setMaxWordCount( $newCount );
}