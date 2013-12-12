 <?php /**  hello,comment
 */ ?>
  <h1>Rong_View_Wudimei template engine</h1>
  the wudime template engine is like the smarty<br />
  This countroller is locate at:<b>/application/controllers/IndexController.php , wudimeiAction();</b><br />
	   this view file 's location: <b>application/views/index/wudimei.php</b> , you can edit or replace this file<br /><br />
	   
	   
 math: <?php echo  round ( 4.23423 , 2 ) + 2.3 ?>
 age :<?php echo @$this->data["man"]->age; ?>
 phone:<?php echo @$this->data["man"]->phone->number; ?>
 name:<?php echo  str_replace ( 'rong' , 'chong' ,@$this->data["man"]->name ) ?><br />
 <?php echo  @$this->data['manArr']['0->age']; ?>
 Name:<?php echo  ucfirst ( @$this->data['name'] ) ?> <br /> 
 Age:<?php echo  @$this->data['age'] + 1; ?><br />
   
  
 <?php if(  @$this->data['age>18']): ?>
  grown up
 <?php elseif(  @$this->data['age'] == 18): ?>
  you are 18
 <?php elseif(  17== @$this->data['age']): ?>
 you are 17
 <?php else: ?>
your are a child
 <?php endif; ?>
 <br />
 <?php if(  10 % 3 == 1 || @$this->data['a'] = @$this->data['b']): ?>
  10%3==1<br />
 <?php endif; ?>
  
 <?php if(  @$this->data['name'] == 'Yang qing-rong'): ?>
 hi,yang qing rong
 
 <?php endif; ?>
 <br />
 <h3>foreach</h3>
 <table border="1">
 <tr>
 	<th>mykey_2</th>
 	<th>index</th>
 	<th>id</th>
 	<th>name</th>
 	<th>age</th>
 	<th>phone</th>
 	
 </tr>
 <?php $this->data["wudimei"]["foreach"]["students_1" ]= array("index"=>-1);
foreach(  @$this->data['students_1']  as $this->data['mykey_2'] =>  $this->data['s_2'] ){ 
$this->data["wudimei"]["foreach"]["students_1"]["index"]++;
 ?>
  <tr>
    <td> <?php echo  @$this->data['mykey_2']; ?>
    </td>
    <td>
    
    	<?php echo  @$this->data['wudimei']['foreach']['students_1']['index'] + 3; ?>
     </td>
    <td>  <?php echo  @$this->data['s_2']['id']; ?> </td>
  	<td> <?php echo  @$this->data['s_2']['name']; ?> </td>
  	<td> <?php echo  @$this->data['s_2']['age']; ?>
  			<?php if(  @$this->data['s_2']['age'] < 26): ?>less than 26<?php endif; ?>
  	 </td>
  	<td>
               <?php if( wudimei_isset (  @$this->data['s_2']['phones'] ) ): ?>
  		<?php $this->data["wudimei"]["foreach"]["s_2.phones" ]= array("index"=>-1);
foreach(  @$this->data['s_2']['phones']  as $this->data['key'] =>  $this->data['p'] ){ 
$this->data["wudimei"]["foreach"]["s_2.phones"]["index"]++;
 ?>
  			 
  		  <?php echo  @$this->data['p']; ?> <br />
  		<?php } ?>
  		
                <?php endif; ?>
                
                <?php if( wudimei_isset (  @$this->data['s_2']['nicks'] ) ): ?>
                
                    <?php $this->data["wudimei"]["foreach"]["s_2.nicks" ]= array("index"=>-1);
foreach(  @$this->data['s_2']['nicks']  as $this->data['key'] =>  $this->data['son'] ){ 
$this->data["wudimei"]["foreach"]["s_2.nicks"]["index"]++;
 ?>
                      <?php echo  @$this->data['son']['name']; ?>
                    <?php } ?>
                 <?php endif; ?>
  	</td>
 	</tr> 
 	<?php } ?> 
 </table>
 
 <?php echo  @$this->data['wudimei']['get']['ctg']; ?>
  <?php echo  @$this->data['wudimei']['now']; ?>
  
<?php echo $this->fetch("index/wudimei.inc.php", $this->data ); ?>

<script type="text/javascript"><!--
			google_ad_client = "ca-pub-4516084327322488";
			/* 软件开发列表 */
			google_ad_slot = "0143868300";
			google_ad_width = 708;
			google_ad_height = 90;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
