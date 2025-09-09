<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Events - Sentinel Integrated Security Services</title>
	<link rel="icon" href="assets/images/logo.png" type="image/png">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
	<?php include('includes/header.php'); ?>

	<section class="latest-events page">
		<div class="container">
			<h2>LATEST EVENTS</h2>
			<div class="events-grid">
				<?php include('includes/events-data.php'); ?>
				<?php foreach ($events as $event): ?>
					<a href="event-detail.php?slug=<?php echo urlencode($event['slug']); ?>" class="event-item">
						<div class="event-image">
							<img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
						</div>
						<div class="event-info">
							<h3><?php echo htmlspecialchars($event['title']); ?></h3>
							<p class="event-date"><?php echo htmlspecialchars($event['date']); ?></p>
							<p class="event-location"><?php echo htmlspecialchars($event['location']); ?></p>
							<p class="event-description"><?php echo htmlspecialchars($event['description']); ?></p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php include('includes/footer.php'); ?>
</body>
</html>
