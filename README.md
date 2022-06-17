# wp_html2pdf-wkhtmltopdf
very simple wp plugin html2pdf generator as wp_ajax request with use wkhtmltopdf

After clone repo run Run:
composer install

Use example:

``` javascript
function downloadBase64File(contentBase64, fileName) {
   const linkSource = `data:application/pdf;base64,${contentBase64}`;
   const downloadLink = document.createElement('a');
   document.body.appendChild(downloadLink);

   downloadLink.href = linkSource;
   downloadLink.target = '_self';
   downloadLink.download = fileName;
   downloadLink.click(); 
}

jQuery(document).ready(function () {

   jQuery(".myaccount table a").click(function (e) {
      e.preventDefault();
      var element = document.getElementById('idOfHTMLPartToPrint);
      var element_filename = 'myPDF';
      jQuery.ajax({
         type: "post",
         dataType: "json",
         url: html2pdfAjax.ajaxurl,
         data: { action: "html2pdf", htmlContent: element.outerHTML },
         success: function (response) {
            if (response.type == "success") {
               downloadBase64File(response.pdf, element_filename+'.pdf');
            }
            else {
            }
         }
      })

   })
})
```
