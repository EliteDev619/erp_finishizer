(function($) {
	"use strict";
	$('.tree').treegrid();

	appValidateForm($('#filter-form'), {
			from_date: 'required',
			to_date: 'required',
    	}, filter_form_handler);

	$('#filter-form').submit();
})(jQuery);

function printDiv() 
{
	"use strict";

  	var divToPrint=document.getElementById('DivIdToPrint');

  	var newWin=window.open('','Print-Window');

  	newWin.document.open();

  	newWin.document.write('<html><body onload="window.print()"><link href="'+site_url+'modules/accounting/assets/css/report.css" rel="stylesheet" type="text/css"><link href="'+site_url+'/modules/accounting/assets/plugins/treegrid/css/jquery.treegrid.css?v=100" rel="stylesheet" type="text/css">'+divToPrint.innerHTML+'</body></html>');

  	newWin.document.close();

  	setTimeout(function(){newWin.close();},10);
}

function printExcel(){
	"use strict";

	let file = new Blob([$('#DivIdToPrint').html()], {type:"application/vnd.ms-excel"});
	let url = URL.createObjectURL(file);
	let a = $("<a />", {
	href: url,
	download: "accounting_report.xls"}).appendTo("body").get(0).click();
	e.preventDefault();
}

function filter_form_handler(form) {
	"use strict";
    var formURL = form.action;
    var formData = new FormData($(form)[0]);
    //show box loading
    var html = '';
      html += '<div class="Box">';
      html += '<span>';
      html += '<span></span>';
      html += '</span>';
      html += '</div>';
      $('#box-loading').html(html);

    $.ajax({
        type: $(form).attr('method'),
        data: formData,
        mimeType: $(form).attr('enctype'),
        contentType: false,
        cache: false,
        processData: false,
        url: formURL
    }).done(function(response) {
    	$('#DivIdToPrint').html(response);
		$('.tree').treegrid();

		//hide boxloading
	    $('#box-loading').html('');
	    $('button[id="uploadfile"]').removeAttr('disabled');
    }).fail(function(error) {
        alert_float('danger', JSON.parse(error.mesage));
    });

    return false;
}