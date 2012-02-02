<?php echo $this->Html->script(array('jpdf'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock('
window.onload = function (){
        var myPDF = new PDFObject({ url: "' . $this->webroot . 'files/' . $file['name'] . '" }).embed();
};', array('inline' => false))?>
<div class="main-content">
	<div class="column x12">
		<div class="header"><h2><?php echo __('Download Error');?></h2></div>
		<div class="content">
			<div class="contenttable">
				<p>It appears you don't have Adobe Reader or PDF support in this web browser. <?php echo $this->Html->link('Click here to download the PDF', '/files/'. $file['name']);?></p>
			</div>
		</div>
	</div>
</div>