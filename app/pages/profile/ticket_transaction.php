<style>
		.ticket {
			border: 3px solid #000;
			padding: 20px;
			background-color: #FDF5E6;
			font-size: 18px;
			font-weight: bold;
			text-align: center;
		}
		.logo {
			width: 100%;
			margin-bottom: 20px;
		}
		.movie-info {
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 20px;
		}
		.movie-info img {
			max-width: 100%;
			max-height: 200px;
		}
		.movie-info h2 {
			margin: 0;
			font-size: 28px;
			font-weight: bold;
		}
		.movie-info p {
			margin: 0;
			font-size: 18px;
			font-weight: bold;
			color: #666;
		}
		.ticket-details {
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 20px;
			font-size: 18px;
			font-weight: bold;
		}
            	</style>
            <div class="col-lg-12 ">
				<div class="card">
					<div class="card-header">
						<h3 class="text-center">Event Ticket</h3>
					</div>
					<div class="card-body">
						<?php
							$event_details = array(
								"event_name" => "Rhyme Symphony 2023",
								"genre" => "Orchestra",
								"language" => "English",
								"experience" => "Live",
								"location" => "DTAR",
								"date" => date('Y-m-d', strtotime('+1 week')),
								"time" => "3:30pm",
								"seat_number" => "A32"
							);
						?>
				<div class="ticket">
					<div class="movie-info">
						<div class="movie-details">
							<h2><?php echo $event_details["event_name"]; ?></h2>
							<p><?php echo $event_details["genre"]; ?></p>
						</div>
						<img src="<?=ROOT?>/assets/images/rhyme.jpg" alt="Concert Poster">
					</div>
					<div class="ticket-details">
						<p>Location: <?php echo $event_details["location"]; ?></p>
						<p>Date: <?php echo $event_details["date"]; ?></p>
						<p>Time: <?php echo $event_details["time"]; ?></p>
						<p>Seat: <?php echo $event_details["seat_number"]; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>

