<style>
    .dropdown:hover .nav-link:hover {
    background-color: #0B192C;
  }
    .main-sidebar{
    background-color: #2a3140;
  }
  
  .main-sidebar::after{
    background-color: #2a3140;
  }
  
    .dropdown .nav-link:active, 
    .dropdown .nav-link:focus {
    background-color: #2a3140; 
  }
  
  .navsid{
    border-radius: 5px;
    background-color: #2a3140;
  }
  
</style>

<div class="main-sidebar sidebar-style-2 p-1">
  <aside id="sidebar-wrapper ">
    <div class="sidebar-brand mt-3">
      <a href="index.php">
        <img src="../../assets/img/a.png" alt="logo" width="100">
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm ">
      <a href="index.php">ZW </a>
    </div>
    <ul class=" sidebar-menu mt-5 pt-2">
      <li class="dropdown">
        <a class="navsid nav-link text-dark mb-3 bg-light " href="../dashboard/index.php"><i class="fas fa-th-large " style='font-size:19px'></i> <span>Dashboard</span></a>
      </li>
      <li class="dropdown">
        <a href="#" class="navsid nav-link has-dropdown text-white" data-toggle="dropdown"><i class="fas fa-user-edit" style='font-size:19px'></i>
          <span>Kelas</span></a>
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