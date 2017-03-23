
/* 
CLEARIN the drawingboard
*/
	var cleartemp, cleartemp1;
	var down_time,curr_time;
	var user,client;
	var curr_no;
	var d_extra;
	var up=0;
	var pressed = 0 ;

function username(x)
{	
  user =x;		
}	
	
function beginner()
{
	$.ajax({
			  type: 'GET',
			  url: 'beginner.php',
			  async: true,
			  cache: false,
			  timeout:10000000,
			  dataType: "json",
			  
			  
			  success: function(data){	
			  			
						if(data.content != '')
						{
							var parser3 = new DOMParser();
							xmldoc3 = parser3.parseFromString("<svg>"+data.content+"</svg>","text/xml");
							y=xmldoc3.documentElement.childNodes;
							var old_xml3 = doc1.getElementsByTagName("svg")[0];
							
							for(k=0;k<y.length;)
							{
								old_xml3.appendChild(y[k]);
								
							}
						}						
						
			  }
			});

}
	

function auto_update()
{
	
var new_time = new Date().getTime();
if(pressed == 1)
{
	if( new_time - down_time >= 1000 )
	{	
		current_tool_temp = (current_tool=="whitener") ? "path" : current_tool;
		ajax_updtr(doc1.getElementById(user+"_"+current_tool_temp+"_"+curr_no),"modify",current_tool_temp,curr_no);
		down_time=new_time;
		
	}
}
/*
if(pressed == 0)
{
	if(up == 1)
	{
		if( new_time - down_time >= 1000 )
		{
		current_tool_temp = (current_tool=="whitener") ? "path" : current_tool;
		ajax_updtr(doc1.getElementById(user+"_"+current_tool_temp+"_"+curr_no),"modify",current_tool_temp,curr_no);
		down_time=new_time;
		up=0;
		}
	}
	
}*/


}


var interval = setInterval(auto_update, 1000);
	
function clearit()
{
	$("#clearer").click(function(){
		
		cleartemp = doc1.getElementsByTagName("svg")[0].lastChild;
		while (cleartemp != null)
		{	
			cleartemp.parentNode.removeChild(cleartemp);
			cleartemp = doc1.getElementsByTagName("svg")[0].lastChild;
		}
		//coz this is the default element
		current_tool = "path";
		
		
        
        	$.ajax({
			  type: 'POST',
			  data:{},
			  url: 'resetserver.php',
			  async: true,
			  cache: false,
			  timeout:10000000});
                 
                 
        //updating the server
	});
	
}

/*
UNDO 
*/
	var undid;
	var undid_list = new Array();
	var poped;
function undoit()
{
	$("#undoer").click(function(){
		undid = doc1.getElementsByTagName("svg")[0].lastChild;
		if (!undid) return;
		var unid = undid.getAttribute('id');
		undid.parentNode.removeChild(undid);
		
 	$.ajax({
			  type: 'POST',
			  data:{var1:unid},
			  url: 'undoserver.php',
			  async: true,
			  cache: false,
			  timeout:10000000,
			  success: function(){}
              });

	});
	
}

	var doc1 = null;
	//var parser1 = new DOMParser();
	//var doc1 = parser1.parseFromString('<svg xml:space="preserve"  id="svg_ajaj" onload="Load_svg(evt)" onmousedown="OnMouseDownFn(evt)"  onmousemove="OnMouseMoveFn(evt)" onmouseup="OnMouseUpFn(evt)" width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <script xlink:href="fnctns.js" type="text/ecmascript"/></svg>','text/xml');
	var namespace1 = "http://www.w3.org/2000/svg";

/*
REDO*/

function redoit()
{
	$("#redoer").click(function(){
		
		
			$.ajax({
			  type: 'POST',
			  url: 'redoserver.php',
			  async: true,
			  cache: false,
			  timeout:10000000,
			  success: function(data){
						if(data != 1)
						{
						var parser = new DOMParser();
						xmldoc = parser.parseFromString("<svg>"+data+"</svg>","text/xml");
						x=xmldoc.documentElement.lastChild;
						
						var old_xml = doc1.getElementsByTagName("svg")[0];
						old_xml.appendChild(x);
						
						}
						
			  
			  }
              });

	});
}

	
	var current_tool = "path" ;
	var current_element_fill = "none" ;
	var current_element_stroke_width = "1px" ;
	var current_element_stroke = "black" ;
	

function toolselector()
{
	$(".select_tool").click(function(){
		current_tool = this.id;
		//2 show curr tool
		var currtemp = current_tool;
		switch (current_tool)
		{
			case "path":
				currtemp = "Pencil";
			break;
			case "rect":
				currtemp = "Rectangle";
			break;
			case "ellipse":
				currtemp = "Circle";
			break;
		}
		$("span#curr_tool").text("Current tool: "+currtemp);
	});
}

//stroke width initializer
function width_stroke_init()
{
	current_element_stroke_width = $("#strokewidth").val();
}

//to change stroke width
function width_stroke(val1)
{
	current_element_stroke_width = val1;
}

//change stroke color
function colorer()
{
	$(".boxed").click(function(){
		//alert(this.title);
		current_element_stroke = this.title;
	});
}

function hovering()
{
	$("#main-td").hover(function(){
	$(this).attr('style','border-top:thin solid black; border-bottom: thin solid black; border-left: thin solid black; border-right: thin solid black;');
	},
		function(){
		$(this).attr('style','');
		}
	);
}

	var path_no = 1 ;
	var rect_no = 1 ;
	var line_no = 1 ;
	var ellipse_no = 1 ;
	var rect_init_x = null ;
	var rect_init_y = null ;
	

function Load_svg(evt)
{
	doc1 = evt.target.ownerDocument;
	top.doc1 = doc1;
}


	var fhc_minx = null ;	
	var fhc_maxx = null ;
	var fhc_miny = null ;
	var fhc_maxy = null ;

	
	

function OnMouseDownFn(evt)
{
	//coz this fn calld by svg file where as earlier the var was set by html file 
	current_tool = top.current_tool;
	current_element_stroke = top.current_element_stroke;
	current_element_stroke_width = top.current_element_stroke_width;
	
	down_time=new Date().getTime();
	
	user = top.user;
	
	//pageX and pageY tell you where the mouse is (in pixels) just at the moment the event takes place. guess same as jquery
	var x = evt.pageX;
	var y = evt.pageY;
	var newx=x+1;
	var newy=y+1;

	switch (current_tool)
	{
	case "freehandcircle":
		d_extra = "M" + x + " " + y + " ";
		pressed = 1 ;
		curr_no=path_no;
		 
		
		make_xml_elmnt({
			"element": "path",
			"d": d_extra,
			"id": user +"_path_" + path_no,
			"fill": "none",
			"stroke": current_element_stroke,
			"strokeWidth": current_element_stroke_width
		
		});
		
		fhc_minx = x ;	
		fhc_maxx = x ;
		fhc_miny = y ;
		fhc_maxy = y ;	
		break
	case "path":
		d_extra = "M" + x + " " + y + " ";
		pressed = 1 ;
		curr_no=path_no;
		
		make_xml_elmnt({
			"element": "path",
			"d": d_extra,
			"id": user +"_path_" + path_no,
			"fill": "none",
			"stroke": current_element_stroke,
			"strokeWidth": current_element_stroke_width
		
		});
		break
	case "whitener":
		d_extra = "M" + x + " " + y + " ";
		pressed = 1 ;
		curr_no=path_no;
		 
		make_xml_elmnt({
			"element": "path",
			"d": d_extra,
			"id": user +"_path_" + path_no,
			"fill": "none",
			"stroke": "white",
			"strokeWidth": current_element_stroke_width
		
		});
		break
	case "rect":
		pressed = 1 ;
		rect_init_x = x ;
		rect_init_y = y ;
		curr_no=rect_no;
		
		make_xml_elmnt({
			"element": "rect",
			"x": x,
			"y": y,
			"width": "1px",
			"height": "1px",
			"id": user +"_rect_" + rect_no,
			"fill": current_element_fill,
			"stroke": current_element_stroke,
			"strokeWidth": current_element_stroke_width
		
		});
		break
	case "line":
		pressed = 1 ;
		curr_no=line_no;

		make_xml_elmnt({
			"element": "line",
			"x1": x,
			"y1": y,
			"x2": x + 1, //addin 1 just to get d feel of a line
			"y2": y + 1,
			"id": user +"_line_" + line_no,
			"stroke": current_element_stroke,
			"strokeWidth": current_element_stroke_width
		
		});
		break
	case "ellipse":
		pressed = 1 ;
		curr_no=ellipse_no;
		
		make_xml_elmnt({
			"element": "ellipse",
			"cx": x,
			"cy": y,
			"rx": 1,
			"ry": 1,
			"id": user +"_ellipse_" + ellipse_no,
			"fill": current_element_fill,
			"stroke": current_element_stroke,
			"strokeWidth": current_element_stroke_width
		});
		break
	}
 current_tool_temp = (current_tool=="freehandcircle") ? "path" : current_tool;
 current_tool_temp = (current_tool=="whitener") ? "path" : current_tool_temp;
 ajax_updtr(doc1.getElementById(user+"_"+current_tool_temp+"_"+curr_no),"create",current_tool_temp,curr_no);

}



function OnMouseMoveFn(evt)
{
	current_tool = top.current_tool;
	user=top.user;
		
	if (pressed == 1 )
	{
		var x = evt.pageX;
		var y = evt.pageY;
		
		switch (current_tool)
		{
		case "path":

			d_extra = d_extra + "L" + x + " " + y + " ";
			var shape = doc1.getElementById(user+"_path_"+path_no);
			shape.setAttributeNS(null, "d", d_extra);
			break
		case "whitener":

			d_extra = d_extra + "L" + x + " " + y + " ";
			var shape = doc1.getElementById(user+"_path_"+path_no);
			shape.setAttributeNS(null, "d", d_extra);
			break		

		case "rect":

			var shape = doc1.getElementById(user+"_rect_"+rect_no);
			
			if(rect_init_x < x ){
				shape.setAttributeNS(null, "x", rect_init_x);
				shape.setAttributeNS(null, "width", x - rect_init_x);
			}else{
				shape.setAttributeNS(null, "x", x);
				shape.setAttributeNS(null, "width", rect_init_x - x);
			}
			if(rect_init_y < y ){
				shape.setAttributeNS(null, "y", rect_init_y);
				shape.setAttributeNS(null, "height", y - rect_init_y);
			}else{
				shape.setAttributeNS(null, "y", y);
				shape.setAttributeNS(null, "height", rect_init_y - y);
			}
						
		break
		case "line":
			var shape = doc1.getElementById(user+"_line_"+line_no);
			shape.setAttributeNS(null, "x2", x);
			shape.setAttributeNS(null, "y2", y);
		break
		case "ellipse":
			var shape = doc1.getElementById(user+"_ellipse_"+ellipse_no);
			var cx = shape.getAttributeNS(null, "cx");
			var cy = shape.getAttributeNS(null, "cy");
			var rad = Math.sqrt( (x-cx)*(x-cx) + (y-cy)*(y-cy) );
			
			shape.setAttributeNS(null, "rx", rad);
			shape.setAttributeNS(null, "ry", rad);
		break;

		case "freehandcircle":
			d_extra = d_extra + "L" + x + " " + y + " ";
			var shape = doc1.getElementById(user+"_path_"+path_no);
			shape.setAttributeNS(null, "d", d_extra);

			fhc_minx = min_of(x , fhc_minx ) ;	
			fhc_maxx = max_of(x , fhc_maxx ) ;	
			fhc_miny = min_of(y , fhc_miny ) ;	
			fhc_maxy = max_of(y , fhc_maxy ) ;	
		break;
			
		}
		
	curr_time=(new Date()).getTime();
	if(curr_time-down_time >= 400)
	{
	current_tool_temp = (current_tool=="freehandcircle") ? "path" : current_tool;
	current_tool_temp = (current_tool=="whitener") ? "path" : current_tool_temp;
	ajax_updtr(doc1.getElementById(user+"_"+current_tool_temp+"_"+curr_no),"modify",current_tool_temp,curr_no);
	down_time=curr_time;
	}
	}
	
	
}


								 

function OnMouseUpFn(evt)
{
	current_tool = top.current_tool;
	up=1;
	pressed = 0 ;

	switch (current_tool)
	{
	case "path":
		d_extra = 0 ;
		path_no = path_no + 1 ;
		break
	case "whitener":
		d_extra = 0 ;
		path_no = path_no + 1 ;
		break
	case "rect":
		rect_no = rect_no + 1 ;
		break
	case "line":
		line_no = line_no + 1 ;
		break
	case "ellipse":
		ellipse_no = ellipse_no + 1 ;
		break
	case "freehandcircle":			//to be corrected
		d_extra = 0 ;
		path_no = path_no + 1 ;
		ellipse_no = ellipse_no + 1 ;
		
		make_xml_elmnt({
			"element": "ellipse",
			"cx": (fhc_minx + fhc_maxx ) / 2,
			"cy": (fhc_miny + fhc_maxy ) / 2,
			"rx": (fhc_maxx - fhc_minx ) / 2 ,
			"ry": (fhc_maxy - fhc_miny ) / 2 ,
			"id": user + "_ellipse_" + ellipse_no,
			"fill": current_element_fill,
			"stroke": current_element_stroke,
			"strokeWidth": current_element_stroke_width
		});
		
		//vrithi
		var tempfh;
		tempfh = doc1.getElementById(user+"_path_"+(path_no-1));
		tempfh.parentNode.removeChild(tempfh);
			var xhr=XMLHttpRequest();
			//xhr.onreadystatechange=function(){}
			xhr.open("POST","undoserver.php",true);
			xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xhr.send("var1="+user+"_path_"+(path_no-1));
	}
	
	
		current_tool_temp = (current_tool=="freehandcircle") ? "ellipse" : current_tool;
		curr_no = (current_tool=="freehandcircle") ? ellipse_no : curr_no;
		current_tool_temp = (current_tool=="whitener") ? "path" : current_tool_temp;
		ajax_updtr(doc1.getElementById(user+"_"+current_tool_temp+"_"+curr_no),"modify",current_tool_temp,curr_no);
		down_time=new Date().getTime();//updating the server
}

	function min_of(a ,b){
		if (a < b ) { return a ;}
		else {return b ;}
	}
	function max_of(a ,b){
		if (a > b ) { return a ;}
		else {return b ;}
	}
	

	function make_xml_elmnt(info)
	{
		var shape = doc1.createElementNS(namespace1, info.element);
		//endin tag problm solve cheyyan create an extra elmnt with a closin tag ?
		switch (info.element)
		{
		case "freehandcircle":
		case "path":
			shape.setAttributeNS(null, "d", d_extra);
			shape.setAttributeNS(null, "id", info.id);
			shape.setAttributeNS(null, "fill", info.fill);
			shape.setAttributeNS(null, "stroke", info.stroke);
			shape.setAttributeNS(null, "stroke-width", info.strokeWidth);
			doc1.documentElement.appendChild(shape);
			break
		case "rect":
			shape.setAttributeNS(null, "x", info.x);
			shape.setAttributeNS(null, "y", info.y);
			shape.setAttributeNS(null, "width", info.width);
			shape.setAttributeNS(null, "height", info.height);
			shape.setAttributeNS(null, "id", info.id);
			shape.setAttributeNS(null, "fill", info.fill);
			shape.setAttributeNS(null, "stroke", info.stroke);
			shape.setAttributeNS(null, "stroke-width", info.strokeWidth);
			doc1.documentElement.appendChild(shape);
			break
		case "line":
			shape.setAttributeNS(null, "x1", info.x1);
			shape.setAttributeNS(null, "x2", info.x2);
			shape.setAttributeNS(null, "y1", info.y1);
			shape.setAttributeNS(null, "y2", info.y2);
			shape.setAttributeNS(null, "id", info.id);
			shape.setAttributeNS(null, "stroke", info.stroke);
			shape.setAttributeNS(null, "stroke-width", info.strokeWidth);
			doc1.documentElement.appendChild(shape);
			break
		case "ellipse":
			shape.setAttributeNS(null, "cx", info.cx);
			shape.setAttributeNS(null, "cy", info.cy);
			shape.setAttributeNS(null, "rx", info.rx);
			shape.setAttributeNS(null, "ry", info.ry);
			shape.setAttributeNS(null, "id", info.id);
			shape.setAttributeNS(null, "fill", info.fill);
			shape.setAttributeNS(null, "stroke", info.stroke);
			shape.setAttributeNS(null, "stroke-width", info.strokeWidth);
			doc1.documentElement.appendChild(shape);
			break
		}
		//hist_aux();
	
	}
	   
/*
	function fun_mouseOUT(evt)
	{
		current_tool = top.current_tool
	
		if (current_tool == "whitener")
		{
			var tempwn;
			tempwn = doc1.getElementsByTagName("svg")[0].lastChild.previousSibling;
			tempwn.parentNode.removeChild(tempwn);			
		}
	}
*/	
	
	function downloader()
	{
		$("#dler").click(function(){
			var tempdlr;
			tempdlr = doc1.getElementsByTagName("svg")[0];
			var string11 = (new XMLSerializer()).serializeToString(tempdlr);
			var b64_code = Base64.encode(string11);
			$("#toolpanel").append($("<a id='saverlink' href-lang='image/svg+xml' href='data:image/svg+xml;base64,\n" + b64_code + "'>Right click and Save..</a>"));
		});	
	}
	
	function hist_aux()
	{
			top.document.getElementById("tool_track").innerHTML = "";

			var temphist = doc1.getElementsByTagName("svg")[0];
			for (j =3; temphist.childNodes[j]!=null; j++) //0 is #text, 1 is script, 2 is #text
			{
				top.document.getElementById("tool_track").innerHTML += "<span title='Color: "+temphist.childNodes[j].getAttribute("stroke")+", Stoke width: "+temphist.childNodes[j].getAttribute("stroke-width")+"' style='color:"+temphist.childNodes[j].getAttribute("stroke")+"'>"+(j-2)+". "+temphist.childNodes[j].getAttribute("id").split('_')[0]+" created "+temphist.childNodes[j].nodeName+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
			}
	}


	function hist()
	{
		$("#histbtn").click(hist_aux);
	}

	
/***************************************************
code for data transfer 
***************************************************/

/*
to update rcvr_query
*/	
	
	function ajax_updtr(node1,callerfunc,shape,number)
	{
		var string1 = (new XMLSerializer()).serializeToString(node1);
		
			
			var xhr=XMLHttpRequest();
			//xhr.onreadystatechange=function(){}
			xhr.open("POST","rcvr_server.php",true);
			xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xhr.send("var1="+string1 + "&var2="+callerfunc + "&var3=" +shape  + "&var4="+ number);
   }





/*
server_query
*/

	function php_time()
	{
	    return Math.floor(new Date().getTime() / 1000);
	}
	
	var resptime=php_time();
	var pid=0;

	function ajax_func()
	{
		$.ajax({
			  type: 'POST',
			  url: 'query_server.php',
			  data: 'var1='+pid,
			  async: true,
			  cache: false,
			  timeout:10000000,
			  dataType: "json",
			  
			  
			  success: function(data){	
			  			
			  		
					if(data.content != '')
					{
						var parser = new DOMParser();
						xmldoc = parser.parseFromString("<svg>"+data.content+"</svg>","text/xml");
						x=xmldoc.documentElement.childNodes;
						
						var old_xml = doc1.getElementsByTagName("svg")[0];
						
						 
						for(i=0;i<x.length;)
						
						{
						
							
         	                if((new XMLSerializer()).serializeToString(x[i])== '<reset/>')
    			  			{
                                            
                               cleartemp = doc1.getElementsByTagName("svg")[0].lastChild;
           	                   while (cleartemp != null)
    		                                {	
    			                            cleartemp.parentNode.removeChild(cleartemp);
    		                            	cleartemp = doc1.getElementsByTagName("svg")[0].lastChild;
    	                                 	}              
                            $('#chatLineHolder').append("<table><tr ><td><i>Session reset by&nbsp;</i>" + data.name + " </td></tr></table>");
							i++;
                            continue;
                            }
                            
                            if(x[i].nodeName.toLowerCase() == 'undo')
                            {
							
                                                          var tid =  x[i].getAttribute("id1");
                                                          var tnode=doc1.getElementById(tid);
																if(tnode){
	                                                        	tnode.parentNode.removeChild(tnode);
																}
																i++;
	                                                        	continue;
                                                          
                            }                           
                            
			  			
							var id = x[i].getAttribute("id");
							var temp = doc1.getElementById(id);
							if(temp)
							{

								temp.parentNode.replaceChild(x[i],temp);
							}
							else
							{

								old_xml.appendChild(x[i]);
								//hist_aux();
							}
							
							
							
							
						}
					}						
						
						
						pid=data.id;
						//window.setTimeout(ajax_func, 10000 );
						ajax_func(); 
                        //recursion
			  }
			  
		//	 error: function(xhr, ajaxOptions,thrownError){
				
			//	ajax_func();
				//}
		
			  
			  
						
	   });
		
	}

	function server_query()
	{
		
		$.ajaxSetup ({
		cache: false
		});
		setTimeout("ajax_func()",1000);
		
	}
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
