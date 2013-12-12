<?php
require_once 'Rong/Search/Analyzer.php';
class AnalyzerController extends Rong_Controller {

    public function __construct() {
        parent::__construct();
    }

    //url: http://127.0.0.9/index.php/test/search/Analyzer/index
    public function indexAction() {

        ini_set("memory_limit", "250M");
        

        $analyzer = Rong_Search_Analyzer::factory("Chinese", array('dictionary_path' => "/www/wudimei/wudimei.com/data/chinese_dict-1.0.dat"));
        $ks = $analyzer->analyze('Hello,world!Rong Framework是杨庆荣开发的一款基于php5的开源框架,它是免费的软件框架。它简化了sql开发。
                它内置的wudimei模板引擎是模防smarty的，但更多的是自己的元素。');
        echo "loading time:" . $analyzer->getLoadingTime() . " seconds<br />"; //加载时间,如果想缩短，请写一个socket server，启动时只加载一次就可以了
        echo "process Time;" . $analyzer->getProcessTime() . " seconds<br />";
        print_r($ks);
    }

    //url: http://127.0.0.9/index.php/test/search/Analyzer/whitespace
    public function whitespaceAction() {
        $analyzer = Rong_Search_Analyzer::factory("WhiteSpace", array());
        $ks = $analyzer->analyze('Rong Framework which is a php5-based framework,is developed by yangqingrong.it simplify the sql development.wudimei template engine is similar to smarty,but it has lots of itself\'s style');
        print_r($ks);
    }

}

?>
