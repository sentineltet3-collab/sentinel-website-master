<?php
include('includes/events-data.php');

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$event = null;
foreach ($events as $e) {
    if ($e['slug'] === $slug) { $event = $e; break; }
}
if (!$event) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><body><h1>Event not found</h1></body></html>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo htmlspecialchars($event['title']); ?> - Events</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
	<style>
		.event-detail { padding: 2.5rem 5%; max-width: 1100px; margin: 0 auto; }
		.event-detail h1 { font-size: 1.8rem; color: #2E7D32; margin-bottom: .5rem; text-align: center; }
		.event-meta { text-align: center; color: #666; margin-bottom: 1.5rem; }
		.event-body { color: #333; line-height: 1.8; }
		.event-body p { margin-bottom: 1rem; }
		.event-hero { margin: 1.5rem 0 2rem; }
		.event-hero img { width: 100%; height: auto; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,.08); }
		.event-gallery { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-top: 1rem; }
		.event-gallery img { width: 100%; height: 180px; object-fit: cover; border-radius: 6px; box-shadow: 0 6px 18px rgba(0,0,0,.06); }
	</style>
</head>
<body>
	<?php include('includes/header.php'); ?>

	<section class="event-detail">
		<h1><?php echo htmlspecialchars($event['title']); ?></h1>
		<div class="event-meta">
			<span><?php echo htmlspecialchars($event['date']); ?></span> &middot;
			<span><?php echo htmlspecialchars($event['location']); ?></span>
		</div>
		<div class="event-hero">
			<img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
		</div>
		<div class="event-body">
			<?php foreach ($event['content'] as $para): ?>
				<p><?php echo htmlspecialchars($para); ?></p>
			<?php endforeach; ?>
		</div>
	</section>
	<section class="latest-events page" style="margin-top: 3rem;">
		<div class="container">
			<h2 style="text-align:center;">Other Events</h2>
			<div class="events-grid">
				<?php foreach ($events as $e): if ($e['slug'] === $event['slug']) continue; ?>
					<a href="event-detail.php?slug=<?php echo urlencode($e['slug']); ?>" class="event-item">
						<div class="event-image">
							<img src="<?php echo htmlspecialchars($e['image']); ?>" alt="<?php echo htmlspecialchars($e['title']); ?>">
						</div>
						<div class="event-info">
							<h3><?php echo htmlspecialchars($e['title']); ?></h3>
							<p class="event-date"><?php echo htmlspecialchars($e['date']); ?></p>
							<p class="event-location"><?php echo htmlspecialchars($e['location']); ?></p>
							<p class="event-description"><?php echo htmlspecialchars($e['description']); ?></p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php include('includes/footer.php'); ?>
</body>
</html>
