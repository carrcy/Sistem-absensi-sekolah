<style>
  .dropdown:hover .nav-link:hover {
  background-color: blue;
}
  .main-sidebar{
  background-color: #2a3140;
}

.main-sidebar::after{
  background-color: #2a3140;
}

  .dropdown .nav-link:active, 
  .dropdown .nav-link:focus {
  background-color: #2a3140; /* Tetap hitam saat di-klik atau fokus */
}
  
</style>

<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper ">
    <div class="sidebar-brand mt-3">
      <a href="index.php">
        <img src="../../assets/img/a.png" alt="logo" width="100">
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm ">
      <a href="index.php">ZW </a>
    </div>
    <ul class="sidebar-menu mt-5">
      <li class="dropdown ">
        <a class="nav-link text-white" href="../dashboard/index.php"><i class="fas fa-th-large text-primary"></i> <span>Dashboard</span></a>
      </li>
      <li class="menu-header">Main Feature</li>
      
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown text-white" data-toggle="dropdown"><i class="fas fa-user-edit text-success"></i>
          <span>Absensi</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link " href="../Absensi">Absensi</a></li>
            <!-- <li><a class="nav-link" href="../../Peminjam/index.php">List Peminjam</a></li> -->
          </ul>
          <ul class="dropdown-menu">
            <li><a class="nav-link " href="../jadwal">Jadwal</a></li>
            <!-- <li><a class="nav-link" href="../../Peminjam/index.php">List Peminjam</a></li> -->
          </ul>
    </ul>
  </aside>
</div>