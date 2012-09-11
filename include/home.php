<h1>The awesome data explorer</h1>

<p>By Elliott Landsborough</p>

<h2>View the data</h2>

<table id="datatable"></table>

<h2>Add some data</h2>

<form method="post" class="editform">
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
	<label for="category">Category</label>
	<?php echo categorydropdown(formval('category')); ?>
	<label for="date">Date</label>
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
	<label for"person">Person</label>
	<?php echo forminput(array('name'=>'person','type'=>'text','value'=>formval('person'),'class'=>'personfield')); ?>
	<label for"text">Text</label>
	<?php echo forminput(array('name'=>'text','type'=>'text','value'=>formval('text'),'class'=>'textfield')); ?>
	<?php echo forminput(array('type'=>'submit','value'=>'save','name'=>'setrecord')); ?>

	<?php echo forminput(array('style'=>'display:none','type'=>'submit','value'=>'cancel','name'=>'cancelchange','class'=>'cancelchange')); ?>
</form>