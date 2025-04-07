<?php session_start(); ?>
<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Real Estate</title>
 
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
</head>
 
<body>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
<a class="navbar-brand" href="#">Real Estate</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
<span class="navbar-toggler-icon"></span>
</button>
 
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mx-auto">
<li class="nav-item active"><a class="nav-link" href="#section1">Home</a></li>
<li class="nav-item active"><a class="nav-link" href="#section2">Listings</a></li>
<li class="nav-item active"><a class="nav-link" href="#section3">About Us</a></li>
</ul>
 
      <?php if (isset($_SESSION['username'])): ?>
<span class="navbar-text text-white mr-3">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</span>
<?php if ($_SESSION['role'] === 'client'): ?>
<a href="my_transactions.php" class="btn btn-outline-light mr-2">My Transactions</a>
<?php elseif ($_SESSION['role'] === 'agent'): ?>
<a href="all_transactions.php" class="btn btn-outline-light mr-2">Transactions</a>
<a href="add_property.php" class="btn btn-outline-light mr-2">Add Property</a>
<?php endif; ?>
<a href="logout.php" class="btn btn-outline-light">Logout</a>
<?php else: ?>
<a href="register.php" class="btn btn-outline-light mr-2">Register</a>
<a href="login.php" class="btn btn-outline-light">Login</a>
<?php endif; ?>
</div>
</nav>
 
  <!-- SECTION 1 -->
<div class="section section1" id="section1">
<h1 class="search-title">Find Your Dream Home</h1>
<div class="search-container">
<form id="search-form" class="search-form">
<input type="text" name="address" placeholder="Enter location">
<select name="type">
<option value="">Property Type</option>
<option value="Apartment">Apartment</option>
<option value="Villa">Villa</option>
<option value="Studio">Studio</option>
</select>
<select name="price">
<option value="">Price Range</option>
<option value="0-50000">Under $50,000</option>
<option value="50000-100000">\$50,000 - \$100,000</option>
<option value="100000-200000">\$100,000 - \$200,000</option>
<option value="200000">Over \$200,000</option>
</select>
<button type="submit">Search</button>
<button type="reset">Reset</button>
</form>
</div>
</div>
 
  <!-- SECTION 2 -->
<div class="section section2" id="section2">
<h2 class="text-center">Available Listings</h2>
<div class="container">
<div class="row" id="property-list"></div>
</div>
</div>
 
  <!-- SECTION 3 -->
<div class="section section3" id="section3">
<div class="container py-5">
<h2 class="text-center mb-5">About Us</h2>
<div class="row align-items-center">
<div class="col-md-6">
<h4>Our Mission</h4>
<p>We strive to make the process of finding your dream home seamless with our extensive database.</p>
</div>
<div class="col-md-6">
<img src="img/realEstateLogo.jpg" alt="Real Estate" class="img-fluid rounded shadow-lg">
</div>
</div>
</div>
</div>
 
  <!-- JS Script -->
<script>
    const sessionRole = "<?= $_SESSION['role'] ?? '' ?>";
    function displayProperties(properties) {
      const list = document.getElementById("property-list");
      list.innerHTML = properties.length ? properties.map(property => `
<div class="col-md-4 mb-4">
<div class="card" data-id="${property.PropertyID}">
<img src="${property.ImageURL}" class="card-img-top" alt="${property.Address}">
<div class="card-body">
<h5 class="card-title">${property.Address}</h5>
<p class="card-text">\$${property.Price} | ${property.Type}</p>
<div>
<a href="transaction.php?property_id=${property.PropertyID}&action=Rent" class="btn btn-success">Rent</a>
<a href="transaction.php?property_id=${property.PropertyID}&action=Sale" class="btn btn-danger">Buy</a>
              ${sessionRole === 'agent' ? `
<form action="delete_property.php" method="POST" style="display:inline;">
<input type="hidden" name="property_id" value="${property.PropertyID}">
<button type="submit" class="btn btn-outline-danger btn-sm ml-1">Delete</button>
</form>` : ''}
</div>
</div>
</div>
</div>
      `).join('') : "<p>No properties found.</p>";
    }
 
    document.addEventListener("DOMContentLoaded", function () {
      fetch("get_properties.php")
        .then(res => res.json())
        .then(displayProperties);
 
      document.getElementById("search-form").addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);
 
        fetch("search_handler.php", {
          method: "POST",
          body: formData
        })
          .then(res => res.json())
          .then(displayProperties)
          .catch(console.error);
      });
    });
</script>
</body>
</html>