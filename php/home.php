<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Real Estate</title>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
</head>

<body>

  <!-- Property Details Modal -->
  <div class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="propertyTitle">Property Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img id="propertyImage" class="img-fluid mb-3" alt="Property Image">
          <p><strong>Price:</strong> <span id="propertyPrice"></span></p>
          <p><strong>Location:</strong> <span id="propertyLocation"></span></p>
          <p><strong>Description:</strong> <span id="propertyDescription"></span></p>
        </div>
      </div>
    </div>
  </div>

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
      <form id="search-form">
        <input type="text" id="location" placeholder="Enter location" class="form-control">
        <select id="property-type" class="form-control">
          <option value="">Property Type</option>
          <option value="apartment">Apartment</option>
          <option value="house">House</option>
          <option value="villa">Villa</option>
        </select>
        <select id="price-range" class="form-control">
          <option value="">Price Range</option>
          <option value="0-100000">$0 - $100,000</option>
          <option value="100000-300000">$100,000 - $300,000</option>
          <option value="300000-500000">$300,000 - $500,000</option>
          <option value="500000+">$500,000+</option>
        </select>
        <button type="submit" class="btn btn-primary">Search</button>
        <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
      </form>
    </div>
  </div>

  <!-- SECTION 2 -->
  <div class="section section2" id="section2">
    <h2 class="text-center">Available Listings</h2>
    <div class="container">
      <div class="row" id="property-list"></div>
      <div class="text-center mt-3">
        <button id="showMoreBtn" class="btn btn-primary">Show More</button>
        <button id="showLessBtn" class="btn btn-secondary" style="display: none;">Show Less</button>
      </div>
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
  document.addEventListener("DOMContentLoaded", function () {
    fetch("get_properties.php")
      .then(response => response.json())
      .then(data => {
        let propertiesList = document.getElementById("property-list");
        let propertiesToShow = 3;

        function displayProperties(properties) {
  propertiesList.innerHTML = properties.length
    ? properties.map(property => `
      <div class="col-md-4 mb-4">
        <div class="card" data-id="${property.PropertyID}">
          <img src="${property.ImageURL}" class="card-img-top" alt="${property.Address}">
          <div class="card-body">
            <h5 class="card-title">${property.Address}</h5>
            <p class="card-text">$${property.Price} | ${property.Address}</p>
            <div>
              <a href="transaction.php?property_id=${property.PropertyID}&action=Rent" class="btn btn-success">Rent</a>
              <a href="transaction.php?property_id=${property.PropertyID}&action=Sale" class="btn btn-danger">Buy</a>
            </div>
          </div>
        </div>
      </div>
    `).join('')
    : "<p>No properties found.</p>";
}


        displayProperties(data.slice(0, propertiesToShow));

        const showMoreBtn = document.getElementById("showMoreBtn");
        const showLessBtn = document.getElementById("showLessBtn");
        const section2 = document.getElementById("section2");

        showMoreBtn.addEventListener("click", function () {
          propertiesToShow = data.length;
          displayProperties(data);
          section2.classList.add("expanded");
          showMoreBtn.style.display = "none";
          showLessBtn.style.display = "inline-block";
        });

        showLessBtn.addEventListener("click", function () {
          propertiesToShow = 3;
          displayProperties(data.slice(0, propertiesToShow));
          section2.classList.remove("expanded");
          showMoreBtn.style.display = "inline-block";
          showLessBtn.style.display = "none";
        });

        document.addEventListener("click", function (event) {
          if (event.target.closest('.card') && !event.target.classList.contains('btn')) {
            const propertyId = event.target.closest('.card').getAttribute("data-id");
            displayPropertyDetails(propertyId);
            $('#propertyModal').modal('show');
          }
        });
      });

    function displayPropertyDetails(propertyId) {
      fetch(`get_property_details.php?id=${propertyId}`)
        .then(response => response.json())
        .then(property => {
          document.getElementById("propertyTitle").textContent = property.Address;
          document.getElementById("propertyImage").src = 'default.jpg';
          document.getElementById("propertyPrice").textContent = `$${property.Price}`;
          document.getElementById("propertyLocation").textContent = property.Address;
          document.getElementById("propertyDescription").textContent = property.Description;
        });
    }

    document.getElementById("resetBtn").addEventListener("click", function () {
      document.getElementById("search-form").reset();
      location.reload();
    });
  });
</script>


</body>
</html>
