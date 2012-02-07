<?php
echo $this->Html->css('/acl/css/acl.css');
?>
<div class="portlet x12">
	<div class="portlet-header">
		<h4><?php echo __d('acl', 'ACL plugin'); ?></h4>
	</div>
	<div class="portlet-content">
	<?php
	echo $this->Session->flash('plugin_acl');
	?>
	
	<div id="plugin_acl">
	<?php

	if(!isset($no_acl_links))
	{
	    $selected = isset($selected) ? $selected : $this->params['controller'];
    
        $links = array();
        $links[] = $this->Html->link(__d('acl', 'Permissions'), '/admin/acl/aros/index', array('class' => ($selected == 'aros' )? 'selected' : null));
        $links[] = $this->Html->link(__d('acl', 'Actions'), '/admin/acl/acos/index', array('class' => ($selected == 'acos' )? 'selected' : null));
        
        echo $this->Html->nestedList($links, array('class' => 'acl_links'));
	}
	?>

