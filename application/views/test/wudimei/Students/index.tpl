{* hello,comment
 *}
  <h1>Rong_View_Wudimei template engine</h1>
  the wudime template engine is like the smarty<br />
  This countroller is locate at:<b>/application/controllers/test/wudimei/StudentsController.php , indexAction();</b><br />
	   this view file 's location: <b>application/views/test/wudimei/Students/index.tpl</b> , you can edit or replace this file<br /><br />
	   
	   
  
 <h3>students</h3>
 <table border="1">
 <tr>
 	<th>NO.</th>
 	<th>NO.+1</th>
 	<th>id</th>
 	<th>name</th>
 	<th>age</th>
 	<th>phone</th>
 	<th>nick names</th>
 </tr>
{foreach from=$students item=$student key=$studentIdx }
  <tr>
    <td>{$studentIdx}
    </td>
    <td>
    	 {$wudimei.foreach.students.index+1}
     </td>
    <td> {$student.id} </td>
  	<td>{$student.name} </td>
  	<td>{$student.age}
  	    {if $student.age<26}less than 26 {/if}
  	 </td>
  	<td>
              {if  $student.phones|isset }
  		 {foreach from=$student.phones item=$phone}
  		     {$phone} <br />
  		 {/foreach}
               {/if}
  	</td>
        <td>  
            {if  $student.nicks|isset }
                   {foreach from=$student.nicks item=$nick}
                     {$nick.nick_name}
                   {/foreach}
                {/if}  
        </td>
 	</tr> 
 	 {/foreach} 
 </table>
 
 Now:
 {$wudimei.now}
  
 {include file =  "test/wudimei/Students/bottom.tpl" }

 
