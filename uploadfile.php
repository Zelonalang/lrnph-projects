


<?php include 'header.php'; ?>


<!DOCTYPE html>
<html>
<head>
    <title>CSV Upload and Import</title>
    <style>

header {
        background-color: rgba(51, 51, 51, 0.8);
        color: #fff;
        padding: 10px;
        display: flex;
        align-items: center;
        backdrop-filter: blur(5px);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;

         font-size: 1.2rem; /* Responsive font size for the header */
    }


        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        form {
            text-align: center;
            margin-top: 20px;
        }
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

<br><br>
    <div class="container">
        <h2>Upload CSV File</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="file-upload" class="custom-file-upload">
                Select CSV File
            </label>
            <input id="file-upload" type="file" name="file" accept=".csv" required>
            <button type="submit" name="submit">Upload</button>
        </form>
    </div>
</body>
</html>
