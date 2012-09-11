var enabletimer=true;

$(document).ready(function() {

	fivesecondreload();

	$("#datatable").on("click", ".editdata", function(event){
		$("#errormessage").html('');
		enabletimer=false;
		var item_id = $(this).attr('id');
		var categoryid = $(".tr"+item_id+" .name").attr('id');
		var date = $(".tr"+item_id+" .date").html()
		var person = $(".tr"+item_id+" .person").html()
		var text = $(".tr"+item_id+" .text").html()
		$(".textfield").val(text);
		$(".personfield").val(person);
		$(".datefield").val(date);
		$(".categoryfield").val(categoryid);
		$(".itemfield").val(item_id);
		$(".cancelchange").show();
		//$(".tr"+item_id).css('background-color','#b5ff98');
	});

	$(".editform").on("click", ".cancelchange", function(event){
		event.preventDefault();
		canceledit();
		enabletimer=true;
	});

	// loginform ajax
	$("form.editform").submit(function(event){
		event.preventDefault();
		var values = $(this).serialize();
		var action = $(this).attr("action");
		console.log(values);
		$.post(action,values,function(data){
			var obj=$.parseJSON(data);
			if(obj['status']==0)
			{
				$("#errormessage").html(obj['error']);
			}
			else
			{
				canceledit();
				enabletimer=true;
				$("#errormessage").html('<p class="green">Record successfully saved.</p>');
			}
		});
	});
});

function fivesecondreload()
{
	if (enabletimer==true)
	{
		getdata();
	}
	setTimeout("fivesecondreload()",5000);
}

function canceledit()
{
	var item_id=$(".itemfield").val();
	$(".tr"+item_id).css('background-color','white');
	$(".textfield").val('');
	$(".personfield").val('');
	$(".datefield").val('');
	$(".categoryfield").val('');
	$(".itemfield").val('');
	$(".cancelchange").hide();
}

function getdata()
{
	var data=null;
	$.getJSON('?p=jsondata', function(data) {
		var r = new Array(), j = -1;
		r[++j] ='<thead><tr><th>Category name</th><th>Date</th><th>Person</th><th>Text</th><th></th></tr></thead><tbody>';
		for (var key=0, size=data.length; key<size; key++){
		    r[++j] ='<tr class="tr'+data[key]['item_id']+'""><td id="'+data[key]['category_id']+'" class="name">';
		    r[++j] = data[key]['category_name'];
		    r[++j] = '</td><td class="date">';
		    r[++j] = data[key]['item_date'];
		    r[++j] = '</td><td class="person">';
		    r[++j] = data[key]['item_person'];
		    r[++j] = '</td><td class="text">';
		    r[++j] = data[key]['item_text'];
		    r[++j] = '</td><td>';
		    r[++j] = '<a class="editdata" id="'+data[key]['item_id']+'" href="#">edit</a>';
		    r[++j] = '</td></tr>';
		 }
		 r[++j] = '</tbody>';
		 var olddata=$('#datatable').html();
		 var newdata=r.join('');
		if (newdata!=olddata)
		{
			$('#datatable').html(newdata);
			console.log('data has changed - reloading table');
		}
		 
	});
}
