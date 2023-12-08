<?php 
require_once '../functions/function.php';
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  logout();
}
?> 
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-2 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Phone Specs Hub</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="index.php?action=logout">Sign out</a>
    </li>
  </ul>
</nav>