<?php
function query($data=null)
{
	global $db;
	if ($data!==null||isset($data['query']))
	{
		$result=mysqli_query($db,$data['query']);
		if ($result->num_rows>0)
		{
			$array=$result->fetch_all(MYSQLI_ASSOC);
			$data['result_array']=$array;
			return $data;
		}
		else
		{
			return false;
		}
		
	}
	else
	{
		return false;
	}
}

function forminput($data=null)
{
	$html='<input';
	foreach ($data as $key=>$value)
	{
		$html.=' '.$key.'="'.$value.'"';
	}
	$html.=' />';
	return $html;
}

function getfields($tofilter=null,$orderby=null,$order=null)
{
	$append=null;
	if(is_array($tofilter))
	{
		$append.=' AND (';
		foreach ($tofilter as $category_id)
		{
			$append.=' table1.category_id="'.$category_id.'" OR';
		}
		if (substr($append,-2)=='OR')
		{
			$append=substr($append,0,-2);
		}
		$append.=' )';
	}
	$p['name']='category_name';
	$p['date']='item_date';
	$p['person']='item_person';
	$p['text']='item_text';
	if($orderby!==null&&isset($p[$orderby]))
	{
		$column=$p[$orderby];
	}
	else
	{
		$column=' category_name ';
	}
	if($order!==null)
	{
		if ($order=='a')
		{
			$direction=' ASC ';
		}
		else
		{
			$direction=' DESC ';
		}
	}
	else
	{
		$direction=' ASC ';
	}
	$orderstring=' ORDER BY '.$column.' '.$direction.' ';
	$data['query']='
SELECT table1.item_id,table1.category_id,categories.category_name,table1.item_date,table1.item_person,table1.item_text 
FROM table1,categories 
WHERE table1.category_id=categories.category_id '.$append.' '.$orderstring.';';
	$result=query($data);
	$fields=$result['result_array'];
	return $fields;
}

function getcategories()
{
	$data['query']='SELECT * FROM categories ORDER BY category_name ASC;';
	$result=query($data);
	$categories=$result['result_array'];
	return $categories;
}

function filtergen()
{
	$fields=getfields();
	if($fields)
	{
		foreach ($fields as $item)
		{
			$availablecats[$item['category_id']]=$item['category_name'];
		}
	}
	if (isset($availablecats))
	{
		return $availablecats;
	}
	else
	{
		return false;
	}
}

function categorydropdown($selected=null)
{
	$categories=getcategories();
	if($categories)
	{
		$html=null;
		$html.='<select name="category" class="categoryfield">';
		$html.='<option value="">Please Select</option>';
		foreach ($categories as $category)
		{
			$id=intval($category['category_id']);
			$sel=null;
			if($id==intval($selected))
			{
				$sel=' selected="selected"';
			}
			$html.='<option value="'.$id.'"'.$sel.'>'.htmlspecialchars($category['category_name']).'</option>';
		}
		$html.='</select>';
	}
	else
	{
		$html='<p class="red">No categories in database.</p>';
	}
	return $html;
}

function formval($field)
{
	if (isset($_POST[$field]))
	{
		return htmlspecialchars($_POST[$field]);
	}
	else
	{
		return null;
	}
}

function inputvalidation($data)
{
	// todo inpiut validation
	// yyyy-mm-dd - ^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$
	return true;
}

function update($table=null,$fields=null,$wherefield=null)
{
	if (is_array($fields)&&$table!=null&&count($fields)>0&&$wherefield!=null&&strlen($wherefield)>0)
	{
		return insert($table,$fields,$wherefield);
	}
	else
	{
		return false;
	}
}

function insert($table=null,$fields=null,$wherefield=null)
{
	if (is_array($fields)&&$table!=null&&count($fields)>0)
	{
		$numfields=count($fields);
		$i=1;
		$fieldlist=null;
		$valuelist=null;
		$start="INSERT INTO";
		foreach ($fields as $field=>$value)
		{
			if ($wherefield!=null&&strlen($wherefield)>0&&$wherefield==$field)
			{
				$start="UPDATE ";
				$whereclause=" WHERE ".$field."='".$value."' ";
			}
			else if ($wherefield!=null)
			{
				$valuelist.=$field." = '".$value."',";
			}
			else
			{
				$fieldlist.=$field.',';
				$valuelist.="'".$value."',";
			}
		}
		if(substr($fieldlist,-1)==',')
		{
			$fieldlist=substr($fieldlist,0,-1);
		}
		if(substr($valuelist,-1)==',')
		{
			$valuelist=substr($valuelist,0,-1);
		}
		if ($wherefield!=null)
		{
			$query=$start.' '.$table.' SET '.$valuelist.$whereclause.';';
		}
		else
		{
			$fieldlist='('.$fieldlist.')';
			$valuelist='('.$valuelist.')';
			$query=$start.' '.$table.' '.$fieldlist.' VALUES '.$valuelist.';';
		}
		global $db;
		$result=mysqli_query($db,$query);
		if(mysqli_error($db))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}
?>