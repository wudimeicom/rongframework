
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
<?php $this->data["wudimei"]["foreach"]["students" ]= array("index"=>-1); foreach(  @$this->data['students']  as $this->data['studentIdx'] =>  $this->data['student'] ){  $this->data["wudimei"]["foreach"]["students"]["index"]++;  ?>
  <tr>
    <td><?php echo wudimei_toString( @$this->data['studentIdx']); ?>
    </td>
    <td>
    	 <?php echo wudimei_toString( @$this->data['wudimei']['foreach']['students']['index'] + 1); ?>
     </td>
    <td> <?php echo wudimei_toString( @$this->data['student']['id']); ?> </td>
  	<td><?php echo wudimei_toString( @$this->data['student']['name']); ?> </td>
  	<td><?php echo wudimei_toString( @$this->data['student']['age']); ?>
  	    <?php if(  @$this->data['student']['age'] < 26): ?>less than 26 <?php endif; ?>
  	 </td>
  	<td>
              <?php if( wudimei_isset (  @$this->data['student']['phones'] ) ): ?>
  		 <?php $this->data["wudimei"]["foreach"]["student.phones" ]= array("index"=>-1); foreach(  @$this->data['student']['phones']  as $this->data['key'] =>  $this->data['phone'] ){  $this->data["wudimei"]["foreach"]["student.phones"]["index"]++;  ?>
  		     <?php echo wudimei_toString( @$this->data['phone']); ?> <br />
  		 <?php } ?>
               <?php endif; ?>
  	</td>
        <td>  
            <?php if( wudimei_isset (  @$this->data['student']['nicks'] ) ): ?>
                   <?php $this->data["wudimei"]["foreach"]["student.nicks" ]= array("index"=>-1); foreach(  @$this->data['student']['nicks']  as $this->data['key'] =>  $this->data['nick'] ){  $this->data["wudimei"]["foreach"]["student.nicks"]["index"]++;  ?>
                     <?php echo wudimei_toString( @$this->data['nick']['nick_name']); ?>
                   <?php } ?>
                <?php endif; ?>  
        </td>
 	</tr> 
 	 <?php } ?> 
 </table>
 
 Now:
 <?php echo wudimei_toString( @$this->data['wudimei']['now']); ?>
  
 <?php echo $this->fetch("test/wudimei/Students/bottom.tpl", $this->data ); ?>

 
