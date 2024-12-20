<?php
require '../../vendor/autoload.php'; // Ensure you have Dompdf installed via Composer

use Dompdf\Dompdf;
use Dompdf\Options;

$data = json_decode(file_get_contents('php://input'), true);

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>All Orders</h1>
    <table border="1" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #dc3545; color: white;">
            <th style="padding: 12px;">Location</th>
            <th style="padding: 12px;">Customer</th>
            <th style="padding: 12px;">Qty</th>
            <th style="padding: 12px;">Price</th>
            <th style="padding: 12px;">Total Price</th>
            <th style="padding: 12px;">Mode of Transaction</th>
            <th style="padding: 12px;">Status</th>
        </tr>
    </thead>
    <tbody>';

foreach ($data['data'] as $row) {
    $html .= '<tr>';
    foreach ($row as $index => $cell) {
        if ($index == 3 || $index == 4) { // Price and Total Price columns
            $html .= '<td style="padding: 8px;">' . htmlspecialchars($cell) . '</td>';
        } else {
            $html .= '<td style="padding: 8px;">' . htmlspecialchars($cell) . '</td>';
        }
    }
    $html .= '</tr>';
}

// Calculate totals
$totalAmount = 0;
$completedAmount = 0;

foreach ($data['data'] as $row) {
    $amount = floatval(str_replace(['₱', ','], '', $row[4])); // Total Price column
    $totalAmount += $amount;
    
    if ($row[6] === 'Complete') { // Status column
        $completedAmount += $amount;
    }
}

// Add totals section
$html .= '</tbody></table>';
$html .= '<div style="margin-top: 20px; text-align: right; padding-right: 20px;">';
$html .= '<p style="font-size: 14px; margin: 5px 0;">
            <strong>Completed Orders Total:</strong> ₱' . number_format($completedAmount, 2) . '
          </p>';
$html .= '<p style="font-size: 14px; margin: 5px 0;">
          <strong>Overall Total:</strong> ₱' . number_format($totalAmount, 2) . '
          </p>';
$html .= '</div></body></html>';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$output = $dompdf->output();
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="orders.pdf"');
echo $output;
?>