<h1 class="slabtextdone">
	<span class="slabtext">The awesome</span>
	<span class="slabtext">data explorer</span>
</h1>

<p class="by">By Elliott Landsborough</p>

<table id="datatable" class="tablesorter" summary="The awesome data"></table>

<div class="formcont">
<form method="post" class="editform form">
	<h2>Add some data</h2>
	<div id="errormessage">
	<?php
	if (isset($formerror)&&$formerror!==null)
	{
		echo $formerror;
	}
	?>
	</div>
	<div style="display:none">
		<?php echo forminput(array('name'=>'item','class'=>'itemfield','type'=>'hidden','value'=>'null','style'=>'display:none')); ?>
		<?php echo forminput(array('name'=>'savething','type'=>'hidden','value'=>'1','style'=>'display:none')); ?>
	</div>

	<p class="category">
		<?php echo categorydropdown(formval('category')); ?>
		<label for="category">Category</label>
	</p>

	<p class="date">
		<?php echo forminput(
							array(	'name'		=>	'date',
									'type'		=>	'text',
									'id'		=>	'datepick',
									'value'		=>	formval('date'),
									'class'		=>	'auto-kal datefield',
									'data-kal'	=>	'format:\'YYYY-MM-DD\''
								)
							);
		?>
		<label for="date">Date</label>
	</p>

	<p class="person">
		<?php echo forminput(array('name'=>'person','type'=>'text','value'=>formval('person'),'class'=>'personfield')); ?>
		<label for"person">Person</label>
	</p>

	<p class="text">
		<?php echo forminput(array('name'=>'text','type'=>'text','value'=>formval('text'),'class'=>'textfield')); ?>
		<label for"text">Text</label>
	</p>

	<p class="submit">
		<?php echo forminput(array('type'=>'submit','value'=>'save','name'=>'setrecord')); ?>
		<?php echo forminput(array('style'=>'display:none','type'=>'submit','value'=>'cancel','name'=>'cancelchange','class'=>'cancelchange')); ?>
	</p>
	<a class="close" href="#"><img src="img/close.png" /></a>
</form>
</div>