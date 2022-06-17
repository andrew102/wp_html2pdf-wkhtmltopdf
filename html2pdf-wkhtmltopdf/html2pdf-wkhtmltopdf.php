<?php
/*
  Plugin Name: html2pdf_AppDev
  Description: html do pdf
  Author: Andrzej Guziec
  Version: 1.0.0
*/
require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use mikehaertl\wkhtmlto\Pdf;

add_action("wp_ajax_html2pdf", "html2pdf");
add_action("wp_ajax_nopriv_html2pdf", "html2pdf");

function html2pdf()
{
    $htmlContent = '<style>html{height: 0;}</style>';
    $htmlContent .= stripslashes($_REQUEST['htmlContent']);
    $result['type'] = "success";
    $options = array(
        'encoding' => 'UTF-8'
    );
    $pdf = new Pdf($options);
    $pdf->addPage($htmlContent);
    try {
        $result['pdf'] = base64_encode($pdf->toString());
    } catch (Exception  $e) {
        $result['type'] = "error";
    }


    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $result = json_encode($result);
        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}

function html2pdfJS_enqueuer()
{
    wp_register_script("html2pdf_script", WP_PLUGIN_URL . '/html2pdf-wkhtmltopdf/html2pdf.js', array('jquery'));
    wp_localize_script('html2pdf_script', 'html2pdfAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

    wp_enqueue_script('html2pdf_script');
}

add_action('init', 'html2pdfJS_enqueuer');