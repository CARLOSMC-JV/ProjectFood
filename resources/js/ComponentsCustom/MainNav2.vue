
<script>
    export default {
        
    }
</script>
<template>
    <header class="cs-header">
  
  <!-- Topbar -->
  <div class="topbar topbar-dark bg-dark">
    <div class="container d-flex align-items-center px-0 px-xl-3">
      <div class="mr-3">
        <a href="tel:4055550128" class="topbar-link d-md-inline-block d-none">
          Available 24/7 at
          <span class='font-weight-bold'>(405) 555-0128</span>
        </a>
        <a href="tel:4055550128" class="topbar-link d-md-none d-inline-block text-nowrap">
          <i class="cxi-iphone align-middle"></i>
          (405) 555-0128
        </a>
      </div>
      <a href="order-tracking.html" class="topbar-link ml-auto mr-4 pr-sm-2 text-nowrap">
        <i class="cxi-map-pin-outline mr-1 font-size-base align-middle"></i>
        Track <span class="d-none d-sm-inline">order</span>
      </a>

      <div class="dropdown">
        <a href="#" class="topbar-link dropdown-toggle d-lg-inline-block d-none ml-4 pl-1 text-decoration-none text-nowrap" data-toggle="dropdown">
          <i class="cxi-profile mr-1 font-size-base align-middle"></i>
          Annette Black
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="account-profile.html" class="dropdown-item d-flex align-items-center">
            <i class="cxi-profile font-size-base mr-2"></i>
            <span>My profile</span>
          </a>
          <a href="account-orders.html" class="dropdown-item d-flex align-items-center">
            <i class="cxi-bag font-size-base mr-2"></i>
            <span>My orders</span>
          </a>
          <a href="account-wishlist.html" class="dropdown-item d-flex align-items-center">
            <i class="cxi-heart font-size-base mr-2"></i>
            <span>Wishlist</span>
            <span class="badge badge-warning ml-auto">2</span>
          </a>
          <a href="account-recently-viewed.html" class="dropdown-item d-flex align-items-center">
            <i class="cxi-eye font-size-base mr-2"></i>
            <span>Recently viewed</span>
          </a>
          <a href="account-reviews.html" class="dropdown-item d-flex align-items-center">
            <i class="cxi-star font-size-base mr-2"></i>
            <span>My reviews</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item d-flex align-items-center">
            <i class="cxi-logout font-size-base mr-2"></i>
            <span>Sign out</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page -->
  <div class="navbar navbar-expand-lg navbar-light bg-light navbar-sticky" data-fixed-element>
    <div class="container px-0 px-xl-3">
      <a href="index.html" class="navbar-brand order-lg-1 mr-0 pr-lg-3 mr-lg-4">
        <!-- <img src="../../assets/img/ecommerce/logo.svg" alt="Createx Logo" width="130"> -->
      </a>
      <!-- Search desktop -->
      <div class="input-group-overlay ml-4 d-lg-block d-none order-lg-3" style="max-width: 21rem;">
        <input class="form-control appended-form-control" type="text" placeholder="Search for products...">
        <div class="input-group-append-overlay">
          <span class="input-group-text"><i class="cxi-search lead align-middle"></i></span>
        </div>
      </div>
      <!-- Toolbar -->
      <div class="d-flex align-items-center order-lg-3">
        <ul class="nav nav-tools flex-nowrap">
          <li class="nav-item d-lg-block d-none mb-0">
            <a href="account-wishlist.html" class="nav-tool">
              <i class="cxi-heart nav-tool-icon"></i>
              <span class="nav-tool-label">2</span>
            </a>
          </li>
          <li class="divider-vertical mb-0 d-lg-block d-none"></li>
          <li class="nav-item align-self-center mb-0">
            <a href="#" class="nav-tool pr-lg-0" data-toggle="offcanvas" data-target="cart">
              <i class="cxi-cart nav-tool-icon"></i>
              <span class="badge badge-success align-middle mt-n1 ml-2 px-2 py-1 font-size-xs">4</span>
            </a>
          </li>
          <li class="divider-vertical mb-0 d-lg-none d-block"></li>
          <li class="nav-item mb-0">
            <button class="navbar-toggler mt-n1 mr-n3" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
              <span class="navbar-toggler-icon"></span>
            </button>
          </li>
        </ul>
      </div>
      <!-- Navbar collapse -->
      <nav class="collapse navbar-collapse order-lg-2" id="navbarCollapse">
        <!-- Search mobile -->
        <div class="input-group-overlay form-group mb-0 d-lg-none d-block">
          <input type="text" class="form-control prepended-form-control rounded-0 border-0" placeholder="Search for products...">
          <div class="input-group-prepend-overlay">
            <span class="input-group-text">
              <i class="cxi-search font-size-lg align-middle mt-n1"></i>
            </span>
          </div>
        </div>
        <!-- Menu -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="index.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Shop</a>
            <ul class="dropdown-menu">
              <li><a href="shop-catalog.html" class="dropdown-item">Catalog with Filters</a></li>
              <li><a href="shop-single.html" class="dropdown-item">Single Product</a></li>
              <li><a href="checkout.html" class="dropdown-item">Checkout</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown mega-dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Megamenu</a>
            <div class="dropdown-menu">
              <div class="container pt-lg-1 pb-lg-3">
                <div class="row">
                  <div class="col-lg-2 col-md-3 py-2">
                    <ul class="list-unstyled">
                      <li><a href="#" class="dropdown-item">New collection</a></li>
                      <li><a href="#" class="dropdown-item">Best sellers</a></li>
                      <li><a href="#" class="dropdown-item">Plus size</a></li>
                      <li><a href="#" class="dropdown-item text-danger">Sale up to 70%</a></li>
                    </ul>
                  </div>
                  <div class="col-lg-2 col-md-3 py-2">
                    <h4 class="font-size-sm text-uppercase pt-1 mb-2">Clothes</h4>
                    <ul class="list-unstyled">
                      <li><a href="#" class="dropdown-item">Coats</a></li>
                      <li><a href="#" class="dropdown-item">Jackets</a></li>
                      <li><a href="#" class="dropdown-item">Suits</a></li>
                      <li><a href="#" class="dropdown-item">Dresses</a></li>
                      <li><a href="#" class="dropdown-item">Cardigans &amp; sweaters</a></li>
                      <li><a href="#" class="dropdown-item">Sweatshirts &amp; hoodies</a></li>
                      <li><a href="#" class="dropdown-item">T-shirts &amp; tops</a></li>
                      <li><a href="#" class="dropdown-item">Pants</a></li>
                      <li><a href="#" class="dropdown-item">Jeans</a></li>
                      <li><a href="#" class="dropdown-item">Shorts</a></li>
                      <li><a href="#" class="dropdown-item">Skirts</a></li>
                      <li><a href="#" class="dropdown-item">Lingerie &amp; nightwear</a></li>
                      <li><a href="#" class="dropdown-item">Sportswear</a></li>
                    </ul>
                  </div>
                  <div class="col-lg-2 col-md-3 py-2">
                    <h4 class="font-size-sm text-uppercase pt-1 mb-2">Shoes</h4>
                    <ul class="list-unstyled">
                      <li><a href="#" class="dropdown-item">Boots</a></li>
                      <li><a href="#" class="dropdown-item">Flat shoes</a></li>
                      <li><a href="#" class="dropdown-item">Heels</a></li>
                      <li><a href="#" class="dropdown-item">Sandals</a></li>
                      <li><a href="#" class="dropdown-item">Mules</a></li>
                      <li><a href="#" class="dropdown-item">Sliders</a></li>
                      <li><a href="#" class="dropdown-item">Slippers</a></li>
                      <li><a href="#" class="dropdown-item">Sneakers</a></li>
                      <li><a href="#" class="dropdown-item">Leather</a></li>
                    </ul>
                  </div>
                  <div class="col-lg-2 col-md-3 py-2">
                    <h4 class="font-size-sm text-uppercase pt-1 mb-2">Accessories</h4>
                    <ul class="list-unstyled">
                      <li><a href="#" class="dropdown-item">Bags &amp; backpacks</a></li>
                      <li><a href="#" class="dropdown-item">Hats &amp; scarves</a></li>
                      <li><a href="#" class="dropdown-item">Hair accessories</a></li>
                      <li><a href="#" class="dropdown-item">Belts</a></li>
                      <li><a href="#" class="dropdown-item">Jewellery</a></li>
                      <li><a href="#" class="dropdown-item">Watches</a></li>
                      <li><a href="#" class="dropdown-item">Sunglasses</a></li>
                      <li><a href="#" class="dropdown-item">Purses</a></li>
                      <li><a href="#" class="dropdown-item">Socks &amp; tights</a></li>
                    </ul>
                  </div>
                  <div class="col-lg-1 d-none d-lg-block py-2">
                    <span class="divider-vertical h-100 mx-auto"></span>
                  </div>
                  <div class="col-lg-3 d-none d-lg-block py-2">
                    <a href="#" class="d-block text-decoration-none pt-1">
                      <!-- <img src="../../assets/img/ecommerce/megamenu.jpg" class="d-block rounded mb-3" alt="Promo banner"> -->
                      <h5 class="font-size-sm mb-3">Back to school. Sale up to 50%</h5>
                      <div class="btn btn-outline-primary btn-sm">
                        See offers
                        <i class="cxi-arrow-right ml-1"></i>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown active">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Account</a>
            <ul class="dropdown-menu">
              <li><a href="account-profile.html" class="dropdown-item">Profile</a></li>
              <li><a href="account-orders.html" class="dropdown-item">My Orders</a></li>
              <li><a href="account-wishlist.html" class="dropdown-item">Wishlist</a></li>
              <li><a href="account-recently-viewed.html" class="dropdown-item">Recently Viewed</a></li>
              <li><a href="account-reviews.html" class="dropdown-item">My Reviews</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
            <ul class="dropdown-menu">
              <li><a href="blog.html" class="dropdown-item">Blog List</a></li>
              <li><a href="blog-single.html" class="dropdown-item">Single Post</a></li>
              <li><a href="contacts.html" class="dropdown-item">Contacts</a></li>
              <li><a href="order-tracking.html" class="dropdown-item">Order Tracking</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="account-profile.html" class="nav-link d-lg-none">
              <i class="cxi-profile font-size-base align-middle mr-1"></i>
              Annette Black
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>
</template>
