<header class="site-header">
<a class="brand" href="index.php?page=home"><span class="brand-mark"><i class="fa-solid fa-location-dot"></i><small>▥▥▥</small></span><strong>City<span>Up</span></strong></a>
<nav aria-label="Main navigation" class="top-nav">
<a class="<?= $currentPage === "home" ? "active" : "" ?>" href="index.php?page=home">Home</a><a href="index.php?page=home#discover">Explore <i class="fa-solid fa-chevron-down tiny"></i></a><a data-filter="Events" href="index.php?page=home#discover">Events</a><a data-filter="Urban Services" href="index.php?page=home#discover">Services</a><a data-filter="Businesses" href="index.php?page=home#discover">Business</a><a href="#about">About</a>
<a class="<?= $currentPage === "reviews" ? "active" : "" ?>" href="index.php?page=reviews">Reviews</a></nav>
<div class="header-actions"><button aria-label="Search" class="icon-button" onclick="document.querySelector('#main-search').focus()"><i class="fa-solid fa-magnifying-glass"></i></button><a class="btn btn-outline" href="index.php?page=dashboard">Sign In</a><a class="btn btn-primary" href="index.php?page=home#discover">Get Started</a></div>
<button aria-label="Toggle menu" class="mobile-menu" onclick="document.querySelector('.top-nav').classList.toggle('show')"><i class="fa-solid fa-bars"></i></button>
</header>
