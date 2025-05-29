<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/Conversation.php';

$imageUrl = $_POST['image_url'] ?? '';
$description = '- Limit the description to **2 concise sentences**
- Only describe what is **clearly visible** 
- in the image (e.g., room, bathroom, bed, furniture, lighting, table, food, decor, window, view, cleanliness)
- **Do not infer amenities** or services not shown
- Feel free to use words like ‘spacious’ or ‘elegant’ to highlight comfort and style. 
- Mention colors of walls, bedding, or furniture to help paint a clear picture
- If the image shows something inappropriate, return: "Unsuitable image."';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Room Analyzer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
	<div class="container">
		<h1>Hotel Image Description</h1>

		<form method="post">
			
			<label>System instruction for accessibility analysis:</label>
			<textarea disabled name="user_description" rows="8"><?= $description ?></textarea>


			<label>Image URL:</label>
			<input type="text"  name="image_url" required value="<?= htmlspecialchars($imageUrl)?>">

			<input type="submit" value="Analyze Image">
		</form>
		<hr> 
		<?php if ($imageUrl): ?>
			<img src="<?= htmlspecialchars($imageUrl) ?>" alt="Hotel Room"><br>
			<?php
				$apiKey = AZURE_API_KEY;
				$endpoint = AZURE_ENDPOINT;

				$conversation = Conversation::new($endpoint, $apiKey)
					->add_message('system', 'You are helping a hotel booking platform.');

				$msg = [
					new TextContent('Analyze the image and generate a description suitable for hotel listings.'),
					new TextContent($description),
					new ImageUrlContent($imageUrl),
				];

				echo "<strong>Description:</strong><br>";
				echo "<p>" . htmlspecialchars($conversation->prompt($msg)) . "</p>";
			?>
			
		<?php endif; ?>
	</div>
</body>
</html>
