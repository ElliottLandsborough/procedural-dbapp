var enabletimer=false;
var filter=null;
var orderby='category_name';
var order='a';

$(document).ready(function() {

	//fivesecondreload();
	getdata();

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
		$(".tr"+item_id).css('background-color','#b5ff98');
		showform();
	});

	$(".editform").on("click", ".cancelchange", function(event){
		event.preventDefault();
		hideform();
		canceledit();
		enabletimer=true;
	});

	$(".editform").on("click", ".close", function(event){
		event.preventDefault();
		canceledit();
		enabletimer=true;
		hideform();
	});

	// editform ajax
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
				getdata();
			}
		});
	});

	// filterform ajax
	$("#datatable").on("submit", "#filterform", function(event){
		event.preventDefault();
		var values = $(this).serialize();
		filter=values;
		getdata();
	});

	$("#datatable").on("click", "#name", function(event){
		event.preventDefault();
		var id = $(this).attr('id');
		sort(id);
	});

	$("#datatable").on("click", "#date", function(event){
		event.preventDefault();
		var id = $(this).attr('id');
		sort(id);
	});

	$("#datatable").on("click", "#person", function(event){
		event.preventDefault();
		var id = $(this).attr('id');
		sort(id)
	});

	$("#datatable").on("click", "#text", function(event){
		event.preventDefault();
		var id = $(this).attr('id');
		sort(id)
	});

	setTimeout(slabTextHeadlines, 250);

	$("body").on("click", ".adddata", function(event){
		event.preventDefault();
		showform();
	});

	$(".form").click(function(e) {
  		e.stopPropagation();
	});

	$(".formcont").click(function() {
		canceledit();
  		hideform();
	});

});

function slabTextHeadlines() {
    $("h1").slabText({
        // Don't slabtext the headers if the viewport is under 380px
        "viewportBreakpoint":380
    });
};

function showform()
{
	$(".formcont").fadeIn();
}

function hideform()
{
	$(".formcont").fadeOut();
}
        
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
	$("#errormessage").html('');
	$(".textfield").val('');
	$(".personfield").val('');
	$(".datefield").val('');
	$(".categoryfield").val('');
	$(".itemfield").val('');
	$(".cancelchange").hide();
}

function getdata()
{
	var href='?p=jsondata';
	var maindata=null;
	var ordertokens='&orderby='+orderby+'&order='+order;
	if (filter!=null)
	{
		href=href+'&filter=1&'+filter;
	}
	href=href+ordertokens;
	$.getJSON(href, function(maindata) {
		var r = new Array(), j = -1;
		var key;
		var categoryid;
		var data=maindata['fields'];
		var cats=maindata['cats'];
		r[++j] ='<caption>Table 1: A great deal of information</caption>';
		r[++j] ='<thead><tr><th><a class="sort" id="name">Category name</a></th><th><a class="sort" id="date">Date</a></th><th><a class="sort" id="person">Person</a></th><th><a class="sort" id="text">Text</a></th><th></th></tr></thead><tbody>';
		for (key=0, size=data.length; key<size; key++){
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
		 r[++j] = '<tr><td colspan="3"><form id="filterform" method="post" action="?p=filter">';
		 for(var index in cats) {
  			r[++j] = '<input type="checkbox" name="'+index+'" value="1" /><span>'+cats[index]+'</span>';
		 }
		 r[++j] = '<input type="submit" value="filter" /></form></td><td>Total records :'+size+'</td><td><a class="adddata" href="#">Add</a></td></tr>';
		 r[++j] = '</tbody>';
		 var olddata=$('#datatable').html();
		 var newdata=r.join('');
		if (newdata!=olddata)
		{
			$('#datatable').html(newdata);
			console.log('reloading table');
		}
		 
	});
}

function sort(field)
{
	orderby=field;
	if(order=='a')
	{
		order='d';
	}
	else
	{
		order='a';
	}
	getdata();
}

	//$("#datatable th.sort")

/*for(var index in p) {
	$("#datatable th#sort"+p[index]).append('<a href="#" class="sortlink" id="'+p[index]+'"></a>');
}*/

	/*$("#datatable").on("click", ".sortlink", function(event){
		event.preventDefault();
		
		getdata();
	});*/
	// var p = new Array('name','date','person','text');

	/*$("#datatable").on("click", ".sort", function(event){
		event.preventDefault();
		var linkid = $(this).attr('id');
		$('#'+linkid).html(linkid);
	});*/