<?php
session_start();

// echo '<pre>';
// var_dump($_SESSION); // Check the session variables
// echo '</pre>';

// echo $_SESSION['user_id'];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>claudia-Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    




    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <!-- Claudia Logo -->
            <a class="navbar-brand" href="#">claudia</a>
    
            <!-- Toggler for smaller screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <!-- Collapsible Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#hero-section">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view/catalog.php">Shop Now</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#featured">Featured</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                                 
                </ul>
                <!-- Login and Account Links -->
                <ul class="navbar-nav">
                <?php if(!isset($_SESSION['username']) && $_SESSION['email'] == false): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="view/admin/admin-login.php">Admin Login</a>
                    </li>
                    <?php endif; ?>

                <?php if(isset($_SESSION['username']) && $_SESSION['email'] == true): ?>
                    <!-- Show logout button -->
                    <li class="nav-item">
                        <a class="nav-link" href="actions/user-logout.php?logout=true">Logout</a>
                    </li>
                <?php endif; ?>


                </ul>
            </div>
        </div>
        <!-- Kente Fabric Strip -->
        <div class="kente-strip"></div>
    </nav>
    
    

    <!-- Hero Section -->
    <header id="hero-section" class="position-relative">

        <div class="hero-gallery">
            <div class="hero-gallery-column">
                <img src="images/wine_silk.jpg" alt="Dress 1">
                <img src="images/green_silk.jpg" alt="Dress 2">
                <img src="images/yellow_silk.jpg" alt="Dress 3">
                <img src="images/lightgreen_silk.jpg" alt="Dress 4">
            </div>
            
        </div>
        
        <div class="hero-overlay">
            <h1 class="hero-overlay-text">claudia</h1>
            <p class="tagline">African Elegance, Tailored to You</p>

        <?php if(!isset($_SESSION['username']) && $_SESSION['email'] == false): ?>
              <!-- Add Buttons for Login and Create Account -->
            <div class="hero-buttons">
            <a href="view/Userlogin.php" class="btn btn-lg hero-button-1">Login</a>
            <a href="view/signup.php" class="btn btn-outline btn-lg hero-button-2" >Sign Up</a>
       
        </div>
        <?php endif; ?>
            
        </div>
    </header>
       
    <section id="about" class="about-section">
        <div class="container">
            <h2 class="section-title">About Claudia</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>At Claudia’s studio, every stitch tells a story. Claudia believes in adding a personal touch to every creation, ensuring that each garment resonates with its wearer’s individuality. With a passion for design and a keen eye for detail, she strives to create pieces that not only fit perfectly but also bring confidence and elegance to those who wear them.</p>
                    <p>From bespoke gowns to everyday wear, Claudia’s work is a celebration of craftsmanship and creativity. Her journey is deeply rooted in her love for connecting with clients, understanding their needs, and transforming their ideas into stunning pieces of art. It’s not just about sewing; it’s about weaving dreams into reality.</p>
                    <p>Visit Claudia’s studio and experience the magic of personalized design!</p>
                </div>
                <div class="about-gallery">
                    <div class="about-gallery-item large">
                        <img src="images/about1.jpg" alt="Claudia working on a design">
                    </div>
                    <div class="about-gallery-item medium">
                        <img src="images/about2.jpg" alt="Close-up of fabrics">
                    </div>
                    <div class="about-gallery-item small">
                        <img src="images/about3.jpg" alt="Sketches of dresses">
                    </div>
                    <div class="about-gallery-item medium">
                        <img src="images/about4.jpeg" alt="Finished design on display">
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <section id="catalog" class="catalog-section">
        <div class="container">
            <h2 class="section-title">Our Collection</h2>
          
            <div class="catalog-gallery">
                <div class="catalog-item">
                    <img src="images/dress1.jpg" alt="Dark Knight Dress">
                    <p>Dark Knight Dress</p>
                </div>
                <div class="catalog-item">
                    <img src="images/dress3.jpg" alt="Orange is the new Black">
                    <p>Orange is the new Black</p>
                </div>
                <div class="catalog-item">
                    <img src="images/dress6.jpg" alt="Deep Forest Dress">
                    <p>Deep Forest Dress</p>
                </div>
                <div class="catalog-item">
                    <img src="images/dress7.jpg" alt="BLUE BOSS Dress">
                    <p>BLUE BOSS Dress</p>
                </div>
            </div>
            <h5><a href="view/catalog.php">See More</a></h5>
        </div>
    </section>

    <section id="featured" class="featuredcollection">
        <div class="container">
            <h2 class="section-title">Featured Collection</h2>
            <div class="catalog-gallery">
                <!-- Catalog Item with Video -->
                <div class="catalog-item">
                    <video loop width="100%" poster="images/summer_collection_thumbnail.jpg" loading="lazy" muted autoplay>
                        <source src="images/summer_collection.mov" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p>Just a Damsel</p>
                </div>
                <!-- Catalog Item with Video -->
                <div class="catalog-item">
                    <video loop width="100%" poster="images/purplevid_thumbnail.jpg" loading="lazy" muted autoplay>
                        <source src="images/purplevid.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p>Purple Parade</p>
                </div>
                
                <!-- Catalog Item with Video -->
                <div class="catalog-item">
                    <video loop width="100%" poster="images/greenvid_thumbnail.jpg" loading="lazy" muted autoplay>
                        <source src="images/greenvid.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p>the corset cage</p>
                </div>
                <div class="catalog-item">
                    <video loop width="100%" poster="images/walkingvid_thumbnail.jpg" loading="lazy" muted autoplay>
                        <source src="images/walkingvid.mov" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p>Blosoming Springs </p>
                </div>
                <!-- Add more items here -->
            </div>
        </div>
    </section>
    
    
    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="section-title">Get in Touch</h2>
            <form class="contact-form" method="POST" action="actions/contact-form-submit.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-info-section bg-light py-4">
        <div class="container text-center">
            <h3>Contact Information</h3>
            <p>If you have any questions, feel free to reach out to us:</p>
            <p><strong>Phone:</strong> +233302813248</p>
            <p><strong>Email:</strong> <a href="mailto:claudia@gmail.com">claudia@gmail.com</a></p>
        </div>
    </section>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2024 Claudia Designs. All rights reserved.</p>
        </div>
    </footer>
    
    

    



    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>