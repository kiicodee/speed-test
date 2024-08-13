<?php 
$file = file_get_contents('result.json');
$data = json_decode($file, true);

$messageSentCount = 0;
$messageReceiveCount = 0;
$messageReceive = [];
$messageSend = [];
$messageJohn = [];

// Process messages
foreach ($data['messages'] as $message) {
    if ($message['from'] == 'John') {
        $messageSentCount++;
        array_push($messageSend, strlen($message['text']));
        array_push($messageJohn, $message['text']);
    } else if ($message['from'] == 'Bot') {
        $messageReceiveCount++;
        array_push($messageReceive, strlen($message['text']));
    }
}

// Calculate average message lengths
$avgSend = $messageSend ? floor(array_sum($messageSend) / count($messageSend)) : 0;
$avgReceive = $messageReceive ? floor(array_sum($messageReceive) / count($messageReceive)) : 0;

// Clean up messages
$messageJohn = array_map(function($msg) {
    return preg_replace('/[,.?]/', '', $msg);
}, $messageJohn);

// Tokenize messages and count word frequencies
$words = [];
foreach ($messageJohn as $message) {
    $words = array_merge($words, explode(' ', $message));
}

$wordCounts = array_count_values($words);
arsort($wordCounts);

// Extract top 5 words
$top = array_slice($wordCounts, 0, 5, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D2 - Chat Analytics</title>
</head>
<body>
    <ul>
        <li>
            Top 5 Sent Words:
            <ul>
                <?php foreach ($top as $word => $count): ?>
                    <li><?php echo htmlspecialchars($word) . ' (' . intval($count) . ')'; ?></li>
                <?php endforeach; ?>
            </ul>
        </li>

        <li>Total messages sent: <?php echo intval($messageSentCount); ?></li>
        <li>Total messages received: <?php echo intval($messageReceiveCount); ?></li>
        <li>Total message length sent: <?php echo intval($avgSend); ?></li>
        <li>Total message length received: <?php echo intval($avgReceive); ?></li>
    </ul>
</body>
</html>
