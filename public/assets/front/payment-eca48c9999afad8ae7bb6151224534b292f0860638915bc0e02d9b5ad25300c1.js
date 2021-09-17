var downloadFile = function(blob){
  // It is necessary to create a new blob object with mime-type explicitly set
  // otherwise only Chrome works like it should
  var newBlob = new Blob([blob], {type: "application/pdf"})
 
  // IE doesn't allow using a blob object directly as link href
  // instead it is necessary to use msSaveOrOpenBlob
  if (window.navigator && window.navigator.msSaveOrOpenBlob) {
    window.navigator.msSaveOrOpenBlob(newBlob);
    return;
  } 
 
  // For other browsers: 
  // Create a link pointing to the ObjectURL containing the blob.
  const data = window.URL.createObjectURL(newBlob);
  var link = document.createElement('a');
  link.href = data;
  link.download="payment.pdf";
  document.body.appendChild(link);
  link.click();
  setTimeout(function(){
    // For Firefox it is necessary to delay revoking the ObjectURL
    document.body.removeChild(link);

    window.URL.revokeObjectURL(data);

    // stop loading
    $('body').loading('stop');
  }, 100);
};

$(document).ready(function(){

    var document_ids = "";

    $('#payment-table').DataTable( {
        responsive: true,
        paging:  false,
        info: false,
        filter: false,
    } );

    // 下載並列印
    $(".print-payment").on('click',function() {
        document_ids = $(this).attr("data");
        fetch('/front/payment.pdf', {
            body : JSON.stringify({ document_ids : document_ids }),
            method: 'POST',
            headers: {
                'content-type': 'application/json'
            },
            'credentials': 'same-origin'
        })
        .then(res => res.blob())
        .then(downloadFile)

    });

    // 標單明細 show - hide 功能 
    $(".first-layer").click(function(){
        dateQuery = "#T" + $(this).attr("id");
        $(".sub-table").addClass("hide");
        $(dateQuery).removeClass("hide");
    })

    $('#menu').on('change', function() {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.open(url, '_top'); // open in a new tab
        }
        return false;
    });

    $('body').on('mousedown', 'tr[url]', function(e) {
        var click = e.which;
        var url = $(this).attr('url');
        if (url) {
            if (click == 2 || (click == 1 && (e.ctrlKey || e.metaKey))) {
                window.open(url, '_blank');
                window.focus();
            } else if (click == 1) {
                window.location.href = url;
            }
            return true;
        }
    });

});
