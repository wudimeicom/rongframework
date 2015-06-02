<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib"; //指向 名字为“Rong”的文件夹的父目录。

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

header("Content-Type: text/html; charset=utf-8");

require_once 'Rong/Db.php';
 

$db = Rong_Db::factory("Mysql", array(
            "host" => "localhost", //mysql 主机
            "username" => "root", //用户名
            "password" => "123456", //密码
            "dbname" => "rong_db", //数据库名称
            "charset" => "utf8" //字符集，也可以是gbk gb2312 ansii等
        ));

$page = intval( @$_GET["page"] ); //当前页码
$pageSize = 2; //页面大小

$sql = "select * from w_article"; //要分页的sql,后面不要带limit 0,2

//方式一：
$rs = $db->limit( $sql , $page, $pageSize  ); //执行分页


/*方式二：这种可以加一条查询记录数的sql语句，比较快速。
  $sql参数为字符串时，是个查询的sql语句,不要带 limit语句。
 * $sql当它是个数组时，第一个元素是sql语句，同样不要limit子句；第二个元素是总记录数的查询语句。
 * 
 */
 /*
$sqlCount = "select count(id) from w_article"; //结果集总记录数的sql语句
$rs = $db->limit( array($sql , $sqlCount), $page, $pageSize  ); //执行分页
 */
 


//输出分页的数据
echo "<table border=1>";
echo "<tr> <th>编号</th> <th>标题</th> <th>内容</th> <th>添加时间</th> </tr>";

for( $i=0; $i< count($rs["Data"]); $i++ )
{
	$row = $rs["Data"][$i];
	echo "<tr>";
	 echo "<td>" . $row["id"] . "</td>";
	 echo "<td>" . $row["title"] . "</td>";
	 echo "<td>" . $row["content"] . "</td>";
	 echo "<td>" . $row["add_time"] . "</td>";
	echo "</tr>";
}
echo "</table>";

//输出分类的链接
?>

    
共有<?php echo $rs["PaginationData"]["RecordCount"]; ?>条记录，
分为<?php echo $rs["PaginationData"]["PageCount"]; ?>页，
每页<?php echo $rs["PaginationData"]["PageCount"]; ?>条数据,
当前第<?php echo $rs["PaginationData"]["Page"]; ?>页。
<br />
<a href="db_paginator2.php?page=1">第一页</a>
<a href="db_paginator2.php?page=<?php echo $rs["PaginationData"]["Prev"]; ?>">上一页</a>
<a href="db_paginator2.php?page=<?php echo $rs["PaginationData"]["Next"]; ?>">下一页</a>
<a href="db_paginator2.php?page=<?php echo $rs["PaginationData"]["PageCount"]; ?>">最后一页</a>
<?php
echo "<h3>分页时返回的数据</h3>";
echo "<pre>";
print_r( $rs );
echo "</pre>";

?>

