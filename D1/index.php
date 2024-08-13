<?php
session_start();

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$selectedLang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

function loadTranslations($lang) {
    $filePath = __DIR__ . "/translations/{$lang}.json";
    if (file_exists($filePath)) {
        return json_decode(file_get_contents($filePath), true);
    } else {
        return json_decode(file_get_contents(__DIR__ . '/translations/en.json'), true);
    }
}
$translations = loadTranslations($selectedLang);
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($selectedLang); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($translations['welcome_message']); ?></title>
</head>
<body>
    <form method="GET" >
        <select name="lang" onchange="this.form.submit()">
            <option value="en" <?php if ($selectedLang == 'en') echo 'selected'; ?>>English</option>
            <option value="fr" <?php if ($selectedLang == 'fr') echo 'selected'; ?>>French</option>
        </select>
    </form>
    <h1><?php echo htmlspecialchars($translations['welcome_message']); ?></h1>
    <p><?php echo htmlspecialchars($translations['contact_us']); ?></p>
</body>
</html>
