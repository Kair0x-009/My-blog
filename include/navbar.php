<nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container">
        <a class="navbar-brand" href="#">R0shit Pokharel</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Contact</a>
            </li>
            
          </ul>
          <?php if (isset($_SESSION['isLogin'])) {    ?>
            <a href="logout.php" class=" btn btn-danger">Logout</a>
            <?php } else {?>
                <div class="d-flex">
            <a href="register.php" class="btn btn-primary">Register</a>
          <a href="login.php" class="btn btn-outline-primary ms-1">Login</a>
          </div>
            
            <?php } ?>
       
          
        </div>
      </div>
    </nav>