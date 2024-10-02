<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indore Navigation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional: FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Custom styling for enhanced visuals */
        .hero {
            background: url('Assets/indore_background.jpg') no-repeat center center;
            background-size: cover;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6); /* Dark overlay for readability */
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .icon-box i {
            font-size: 2.5rem;
            color: #007bff;
        }

        .icon-box {
            text-align: center;
            margin-bottom: 30px;
        }

        .icon-box h4 {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php require('navbar.php'); ?>
</head>

<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="display-4">Explore the Heart of Indore</h1>
            <p class="lead">Discover historical landmarks, top restaurants, and much more.</p>
            <a href="#" class="btn btn-primary btn-lg mt-3">Learn More</a>
        </div>
    </section>

    <!-- Main Content Section -->
    <div class="container my-5">
        <!-- Introduction Row -->
        <div class="row text-center">
            <div class="col">
                <h2 class="display-5">Why Choose Us?</h2>
                <p class="lead">Indore Navigator helps you explore the best the city has to offer!</p>
            </div>
        </div>

        <!-- Feature Icons Row -->
        <div class="row text-center mt-5">
            <div class="col-md-4 icon-box">
                <i class="fas fa-map-marker-alt"></i>
                <h4>Navigate Easily</h4>
                <p>Our accurate navigation helps you find the best routes in real time.</p>
            </div>
            <div class="col-md-4 icon-box">
                <i class="fas fa-utensils"></i>
                <h4>Top Restaurants</h4>
                <p>Discover local and international cuisines at top-rated eateries.</p>
            </div>
            <div class="col-md-4 icon-box">
                <i class="fas fa-hotel"></i>
                <h4>Best Hotels</h4>
                <p>Find affordable and luxury hotels for your stay in Indore.</p>
            </div>
        </div>

        <!-- Cards Section for Featured Content -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card">
                    <img src="Assets/landmark.jpg" class="card-img-top" alt="Landmark">
                    <div class="card-body">
                        <h5 class="card-title">Explore Historical Landmarks</h5>
                        <p class="card-text">Indore is home to many significant landmarks. Visit them today!</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Assets/restaurant.jpg" class="card-img-top" alt="Restaurant">
                    <div class="card-body">
                        <h5 class="card-title">Dine at the Best Restaurants</h5>
                        <p class="card-text">From street food to fine dining, experience the best flavors of Indore.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Assets/hotel.jpg" class="card-img-top" alt="Hotel">
                    <div class="card-body">
                        <h5 class="card-title">Stay at Luxurious Hotels</h5>
                        <p class="card-text">Enjoy top-notch amenities and comfortable stays at Indore's best hotels.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php require('footer.php'); ?>

</body>

</html>

