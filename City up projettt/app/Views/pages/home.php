<section class="hero">
<div class="hero-copy"><h1>Explore Your City</h1><p>Discover local businesses, events, activities,<br class="desktop-only"/> entertainment venues and urban services — all in one place.</p>
<form class="hero-search" onsubmit="event.preventDefault();document.getElementById('discover').scrollIntoView({behavior:'smooth'});filterCards(document.getElementById('main-search').value)"><i class="fa-solid fa-magnifying-glass"></i><input aria-label="Search for businesses and events" id="main-search" placeholder="Search for a business, event, activity or service..."/><button type="submit">Search</button></form>
<div class="quick-categories">
<a data-filter="Businesses" href="#discover"><i class="fa-solid fa-store" style="color:#0079ff"></i><span>Businesses</span></a>
<a data-filter="Events" href="#discover"><i class="fa-regular fa-calendar" style="color:#d12b45"></i><span>Events</span></a>
<a data-filter="Activities" href="#discover"><i class="fa-solid fa-person-running" style="color:#0b923d"></i><span>Activities</span></a>
<a data-filter="Entertainment" href="#discover"><i class="fa-solid fa-ticket" style="color:#7643c6"></i><span>Entertainment</span></a>
<a data-filter="Urban Services" href="#discover"><i class="fa-solid fa-landmark" style="color:#00839a"></i><span>Urban Services</span></a>
</div>
</div>
<div aria-label="City center of Tunis" class="hero-photo" role="img"><div class="location-pill"><i class="fa-solid fa-location-dot"></i> Tunis, Tunisia <i class="fa-solid fa-chevron-down tiny"></i></div></div>
</section>
<section class="discover" id="discover"><div class="discover-left"><h2>Discover Nearby</h2>
<div class="filter-line"><div class="filter-tabs"><button class="filter active" data-filter="Businesses"><i class="fa-solid fa-store"></i> Businesses</button><button class="filter" data-filter="Events"><i class="fa-regular fa-calendar"></i> Events</button><button class="filter" data-filter="Activities"><i class="fa-solid fa-person-running"></i> Activities</button><button class="filter" data-filter="Entertainment"><i class="fa-solid fa-ticket"></i> Entertainment</button><button class="filter" data-filter="Urban Services"><i class="fa-solid fa-landmark"></i> Urban Services</button></div><a class="view-all" href="#cards">View all <i class="fa-solid fa-arrow-right"></i></a></div>
<div class="business-cards" id="cards"></div><div class="empty-message">No businesses added yet.</div></div>
<aside class="map-box"><img alt="Map of Tunis showing nearby locations" src="public/assets/tunis-map.png"/><div class="map-zoom"><button aria-label="Zoom in">+</button><button aria-label="Zoom out">−</button></div><a class="map-link" href="https://www.openstreetmap.org/#map=13/36.8065/10.1815" rel="noopener" target="_blank"><i class="fa-regular fa-map"></i> View on Map</a><div class="map-empty">No locations added yet</div></aside>
</section>
<section class="footer-note" id="about">Explore what makes Tunis special with City Up. <a href="index.php?page=dashboard">Admin Dashboard <i class="fa-solid fa-arrow-right"></i></a></section>
