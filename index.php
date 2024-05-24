<form method="post" action="/index.php" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit">Upload</button>
</form>

<?php
require_once 'push.php';
function processWords($words)
{
    $lettersCount = [];

    foreach ($words as $word) {
        $word = mb_strtolower(trim($word));
        $firstLetter = mb_substr($word, 0, 1);
        $letterCountInWord = count_chars($word, 1);
        foreach ($letterCountInWord as $letter => $count) {

            if (!isset($lettersCount[$firstLetter][$letter])) {
                $lettersCount[$firstLetter][$letter] = 0;
            }

            $lettersCount[$firstLetter][$letter] += $count;
        }

        $folder = __DIR__ . "/library/$firstLetter";

        if ($firstLetter === ''){
            continue;
        }

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        file_put_contents("$folder/words.txt", $word . "\n", FILE_APPEND);
    }

    foreach ($lettersCount as $letter => $counts) {
        $totalCount = array_sum($counts);
        file_put_contents(__DIR__ . "/library/$letter/count.txt", $totalCount);
    }
}

if (php_sapi_name() === 'cli') {
    if (isset($argv[1])) {
        $contents = mb_convert_encoding(file_get_contents($argv[1]), "utf-8", "windows-1251");
        $words = explode("\n", $contents);
        processWords($words);
        echo "successfully.\n";
    } else {
        echo "Usage: php index.php <filename>\n";
    }
} else {
    $file = $_FILES["file"];
    $contents = mb_convert_encoding(file_get_contents($_FILES["file"]["tmp_name"]), "utf-8", "windows-1251");
    $words = explode("\n", $contents);
    processWords($words);
    echo "successfully.\n";
}
?>



