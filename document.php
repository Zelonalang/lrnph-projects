<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data and display as a document
    $formData = $_POST;

    // You can customize this based on your form structure
    $document = "<h2>Document View</h2>";

    // Display PO Number
    if (!empty($formData['ponumber'])) {
       $document .= "<p><strong>PO Number:</strong> " . implode(', ', $formData['ponumber']) . "</p>";
    }

    // Display table header
    $document .= "<table border='1'>
                    <thead>
                        <tr>
                            <th>LRN Code</th>
                            <th>Description</th>
                            <th>pcs/box</th>
                            <th>Box Order</th>
                            <th>40ft 17.5 lp</th>
                            <th>20ft 8 lp</th>
                            <th>40ft Used Pallet</th>
                            <th>20ft Used Pallet</th>
                        </tr>
                    </thead>
                    <tbody>";

    // Display table rows
    for ($i = 0; $i < count($formData['lrncode']); $i++) {
        $document .= "<tr>
                        <td>{$formData['lrncode'][$i]}</td>
                        <td>{$formData['description'][$i]}</td>
                        <td>{$formData['pcsbox'][$i]}</td>
                        <td>{$formData['boxorder'][$i]}</td>
                        <td>{$formData['c40ft175lp'][$i]}</td>
                        <td>{$formData['c20ft8lp'][$i]}</td>
                        <td>{$formData['c40ftusedpallet'][$i]}</td>
                        <td>{$formData['c20ftusedpallet'][$i]}</td>
                    </tr>";
    }

    // Display table footer and total used pallets
    $document .= "</tbody></table>";

    $document .= "<h3>Total Used Pallets</h3>";

    // Check if keys exist before accessing them
    $total40ftUsedPallet = isset($formData['total40ftUsedPallet']) ? $formData['total40ftUsedPallet'] : 0;
    $total20ftUsedPallet = isset($formData['total20ftUsedPallet']) ? $formData['total20ftUsedPallet'] : 0;

    $document .= "<p><strong>Remaining Pallets of 40ft:</strong> {$total40ftUsedPallet}</p>";
    $document .= "<p><strong>Remaining Pallets of 20ft:</strong> {$total20ftUsedPallet}</p>";

    echo $document;
} else {
    // If the form is not submitted, redirect to the form page
    header('Location: scm.php');
    exit();
}
?>
