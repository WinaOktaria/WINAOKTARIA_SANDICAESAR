<?php
function caesarCipher($text, $shift, $action)
{
    $result = '';

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        if (ctype_alpha($char)) {
            $isUpperCase = ctype_upper($char);
            $asciiStart = $isUpperCase ? ord('A') : ord('a');
            $ascii = ord($char);
            $offset = $isUpperCase ? 26 : 26;

            if ($action === 'enkripsi') {
                $newChar = chr(($ascii - $asciiStart + $shift) % $offset + $asciiStart);
            } else {
                $newChar = chr(($ascii - $asciiStart - $shift + $offset) % $offset + $asciiStart);
            }

            $result .= $newChar;
        } else {
            $result .= $char;
        }
    }

    return $result;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$pageTitle = ($action === 'enkripsi') ? 'Enkripsi' : 'Dekripsi';

// Check for the specific action from the form
$formAction = isset($_POST['formAction']) ? $_POST['formAction'] : $action;

// Proses untuk fungsi delete
if (isset($_GET['delete']) && $_GET['delete'] == 1) {
    // Hapus teks dengan mengesetnya ke string kosong
    $inputText = '';
} else {
    // Gunakan teks yang di-post jika tidak ada permintaan delete
    $inputText = isset($_POST['inputText']) ? $_POST['inputText'] : '';
}

$shift = isset($_POST['shift']) ? (int)$_POST['shift'] : '';

// Proses enkripsi/dekripsi
$result = caesarCipher($inputText, $shift, $formAction);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Enkripsi Caesar Cipher - <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
           body {
            font-family: 'Arial', sans-serif;
            background-color: #808080; /* Grey background */
            margin: 0;
            padding: 0;
            color: black;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #EBD9B4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: black;
        }

        p {
        color: #333; 
        font-size: 16px; 
        line-height: 1.5;
        text-align: justify;
        margin-bottom: 20px; 
        border: 1px solid #8b5e83;
        padding: 10px; 
        border-radius: 8px; 
    }
        .menu {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu a {
            display: inline-block;
            margin: 0 15px;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #8b5e83;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
        }

        .menu a:hover {
            background-color: #503c3c;
            text-decoration: underline;
        }

        .cipher-form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: black;
            text-align: left; /* Align label text to the left */
        }

        textarea, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .button-container {
            text-align: center;
        }

        input[type="submit"], input[type="reset"] {
            background-color: #8b5e83;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }

        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #503c3c;
        }

        .result-container {
            margin-top: 20px;
            text-align: center;
        }

        textarea[readonly] {
            background-color: #ecf0f1;
        }

        .encrypt-result {
            color: black;
        }

        .result-container {
            margin-top: 20px;
            text-align: left;
            color: black;
        }

        .result-container .result-heading {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .encrypt-result {
            color: #2ecc71;
        }
        .delete-link {
            display: inline-block;
            margin: 0 15px;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #8b5e83;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
}

.delete-link:hover {
    background-color: #c0392b;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Sistem Dekripsi Caesar Cipher</h1>
        <br>
        <!-- Menu -->
        <div class="menu">
            <a href="home.php">HOME</a>
            <a href="enkripsi.php?action=enkripsi">ENKRIPSI</a>
            <a href="dekripsi.php?action=dekripsi">DEKRIPSI</a>
        </div>
        <br>
        <p> Dekripsi adalah proses mengembalikan informasi yang telah dienkripsi (ciphertext) menjadi bentuk aslinya (plaintext) dengan menggunakan kunci dekripsi.</p>
       
        <form action="<?php echo ($action === 'enkripsi') ? 'enkripsi.php' : 'dekripsi.php'; ?>" method="post" class="cipher-form">
            <label for="inputText">Masukkan Teks :</label>
            <textarea name="inputText" rows="4" cols="50"><?php echo isset($_POST['inputText']) ? htmlspecialchars($_POST['inputText']) : ''; ?></textarea>

            <label for="shift">Masukkan Key :</label>
            <input type="number" name="shift" min="1" max="25" value="<?php echo isset($_POST['shift']) ? $_POST['shift'] : ''; ?>">

            <div class="button-container">
                <input type="submit" value="DEKRIPSI" name="dekripsi">
                <a href="?action=<?php echo $formAction; ?>&delete=1" class="delete-link">DELETE</a>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputText = isset($_POST['inputText']) ? $_POST['inputText'] : '';
            $shift = isset($_POST['shift']) ? (int)$_POST['shift'] : '';

            $result = caesarCipher($inputText, $shift, $action);

            echo '<div class="result-container ' . $action . '-result">';
            echo '<div class="result-heading">' . ucfirst($action) . ' Hasil Dekripsi :</div>';
            echo '<textarea id="outputText" rows="4" cols="50" readonly>' . htmlspecialchars($result) . '</textarea>';
            echo '</div>';
            
            if (isset($_GET['delete']) && $_GET['delete'] == 1) {
                $inputText = '';
            } else {
                $inputText = isset($_POST['inputText']) ? $_POST['inputText'] : '';
            }
            $shift = isset($_POST['shift']) ? (int)$_POST['shift'] : '';
            $result = caesarCipher($inputText, $shift, $formAction);
        }
        ?>
        
    </div>
</body>
</html>
