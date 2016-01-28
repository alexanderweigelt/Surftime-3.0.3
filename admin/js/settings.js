// JavaScript Document

tinymce.init({
	language : 'de',
	selector: "#content",
	height : 500,
	plugins: "link image media table code paste",
    element_format : "html",
    verify_html : false ,
    cleanup : false,
	image_list: "ajax.php?load=json&data=image_list",
	image_advtab: true,
	link_list: "ajax.php?load=json&data=link_list",
	body_class: 'responsiv',
	content_css : 'admin/css/tinymce.css'
});

$(document).foundation({
	tab: {
		callback : function (tab) {
		console.log(tab);
		}
	}
});

if(document.getElementById("uploadBtn") !== null){
	document.getElementById("uploadBtn").onchange = function () {
		document.getElementById("uploadFile").value = this.value;
	};
}

jQuery(document).ready(function($) {
	// Wrap Elements for responsiv Table
	$("table").wrap('<div class="table-scrollable"></div>');
});