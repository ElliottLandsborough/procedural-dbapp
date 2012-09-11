<?php
error_reporting(E_ALL);
// connect to db
require 'include/db.php';
// load functions
require 'include/functions.php';

if (isset($_POST['savething']))
{
	$fields=array('category','date','person','text');
	$sql=array('category_id','item_date','item_person','item_text');
	if (isset($_POST['item'])&&$_POST['item']!=null&&$_POST['item']!='null')
	{
		$fields[]='item';
		$sql[]='item_id';
	}
	$formerror=null;
	foreach ($fields as $key=>$field)
	{
		if(!isset($_POST[$field])||strlen($_POST[$field])==0||$_POST[$field]=='')
		{
			$formerror.='<p class="red">The '.$field.' field is required.</p>';
		}
		else
		{
			$cleanfields[$sql[$key]]=mysql_real_escape_string($_POST[$field]);
		}
	}
	if ($formerror===null&&isset($fields))
	{
		if(inputvalidation($cleanfields))
		{
			if (isset($cleanfields['item_id']))
			{
				if(update('table1',$cleanfields,'item_id'))
				{
					$data['status']=1;
				}
				else
				{
					$data['status']=0;
					$data['error']='<p class="red">There was an error. Please try again.</p>';
				}
			}
			else
			{
				if(insert('table1',$cleanfields))
				{
					$data['status']=1;
				}
				else
				{
					$data['status']=0;
					$data['error']='<p class="red">There was an error. Please try again.</p>';
				}
			}
		}
	}
	else
	{
		$data['status']=0;
		$data['error']=$formerror;
	}
	echo json_encode($data);
	die;
}

if (isset($_GET['p']))
{
	$page=$_GET['p'];
	if ($page=='jsondata')
	{
		$tofilter=null;
		$cats=filtergen();
		if (isset($_GET['filter'])&&$_GET['filter']=='1')
		{
			foreach ($cats as $category_id=>$category_name)
			{
				if(isset($_GET[$category_id])&&$_GET[$category_id]=='1')
				{
					$tofilter[]=$category_id;
				}
			}
		}
		$order=null;
		$orderby=null;
		if (isset($_GET['orderby'])&&isset($_GET['order']))
		{
			$orderby=$_GET['orderby'];
			$order=$_GET['order'];
		}
		$json['fields']=getfields($tofilter,$orderby,$order);
		$json['cats']=$cats;
		echo json_encode($json);
	}
}
else
{
	// header
	require 'include/header.php';
	// home page
	require 'include/home.php';
	// footer
	require 'include/footer.php';
}
?>