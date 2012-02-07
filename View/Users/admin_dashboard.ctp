<?php $this->pageClass = 'dashboard';?>
<div class="portlet x12">
	<div class="portlet-header">
		<h4>Quick Links</h4>
	</div> 
	<div class="portlet-content">
		<ul class="gallery">
			<li><?php echo $this->Html->link($this->Html->image('icons/gr_products.png', array('alt' => 'Products')), '/admin/products', array('escape' => false));?><p class="link">Products</p></li>
			<li><?php echo $this->Html->link($this->Html->image('icons/gr_slideshow.png', array('alt' => 'Slideshow')), '/admin/slideshows', array('escape' => false));?><p class="link">Slideshow</p></li>
			<li><?php echo $this->Html->link($this->Html->image('icons/gr_content.png', array('alt' => 'Content')), '/admin/pages', array('escape' => false));?><p class="link">Content</p></li>
			<li><?php echo $this->Html->link($this->Html->image('icons/gr_menu.png', array('alt' => 'Menu')), '/admin/menus', array('escape' => false));?><p class="link">Menu</p></li>
			<li><?php echo $this->Html->link($this->Html->image('icons/gr_addusers.png', array('alt' => 'Users')), '/admin/users', array('escape' => false));?><p class="link">Users</p></li>
		</ul>
		<br class="clear"/>
	</div>
</div>
<div class="portlet x3" style="min-height: 300px;">
	
	<div class="portlet-header">
		<h4>Quick Info</h4>
	</div> <!-- .portlet-header -->
	
	<div class="portlet-content">
		<table cellspacing="0" class="info_table">
			<tbody>
				<tr>
					<td class="value"><?php echo $info['Visit']['tcnt'];?></td>
					<td class="full">Page Views Today</td>
				</tr>
				<tr>
					<td class="value"><?php echo $info['Visit']['tunt'];?></td>
					<td class="full">Unique Visits</td>
				</tr>
				<tr>
					<td class="value"><?php echo $info['Visit']['ucnt'];?></td>
					<td class="full">Total Vists</td>
				</tr>
				<tr>
					<td class="value"><?php echo $info['Category']['ccnt'];?></td>
					<td class="full">Categories</td>
				</tr>
				<tr>
					<td class="value"><?php echo $info['Product']['pcnt'];?></td>
					<td class="full">Products</td>
				</tr>
			</tbody>
		</table>
	</div> <!-- .portlet-content -->			
</div> <!-- .portlet -->

<div id="dash_chart" class="portlet x9">
	
	<div class="portlet-header">
		<h4>Site Views</h4>
	</div> <!-- .portlet-header -->
	
	<div class="portlet-content">				
		
			<table class="stats" title="area" width="100%" cellpadding="0" cellspacing="0">
				<caption>Unique visits / 14 days</caption>
				<?php if($graph){
					$header = '<td>&nbsp;</td>';
					$salerow = '';
					$rentrow = '';
					$_startdate = date('Y-m-d', strtotime('-16 days'));
					$_enddate = date('Y-m-d', strtotime('now'));
					$i = 0; 
					while ($_startdate != $_enddate) {
					    $_startdate = date ("Y-m-d", strtotime ("+1 day", strtotime($_startdate)));
					    $_datearray[$_startdate] = array('date' => $_startdate, 'PropCnt' => 0, 'RentCnt' => 0);
						$i++;
						if ($i > 32) { break; }
					}
					foreach($graph as $g){
						if(array_key_exists($g[0]['date'], $_datearray)){
							$_datearray[$g[0]['date']] = $g[0];
						}
					}
					foreach($_datearray as $_g){
						$header .= '<th style="text-align:center;">' . date("d\nM", strtotime($_g['date'])) . '</th>';
						$salerow .= '<td>' . $_g['PropCnt'] . '</td>';
					}
				?>
				<thead>
					<tr>
						<td>&nbsp;</td>
						<?php echo $header;?>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<th>Unique Views</th>
						<?php echo $salerow;?>
					</tr>							
				</tbody>
				<?php } ?>
			</table>

	</div> <!-- .portlet-content -->			
</div> <!-- .portlet -->

<div class="xbreak"></div> <!-- .xbreak -->
