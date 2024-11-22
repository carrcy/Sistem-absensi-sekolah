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
  <aside id="sidebar">
    <div class="sidebar-brand mt-3">
      <a href="index.php">
        <img src="../assets/img/a.png" alt="logo" width="100">
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm ">
      <a href="index.php">ZW</a>
    </div>
    <ul class="sidebar-menu mt-5 pt-2">
      <li class="dropdown">
        <a class="navsid nav-link text-dark mb-3 bg-light " href="../"><i class="fas fa-th-large " style='font-size:19px'></i> <span>Dashboard</span></a>
      </li>
      <li class="dropdown">
        <a href="#" class="navsid nav-link has-dropdown text-white" data-toggle="dropdown"><i class="fas fa-user " style='font-size:19px'></i>
          <span>Guru</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../guru/index.php">Data Guru</a></li>
          <li><a class="nav-link" href="../guru/create.php">Tambah Guru Piket</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="navsid nav-link has-dropdown text-white" data-toggle="dropdown"><i class="fas fa-columns " style='font-size:19px'></i> <span>Kelas</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../kelas/index.php">List</a></li>
          <li><a class="nav-link" href="../kelas/create.php">Tambah Kelas</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="navsid nav-link has-dropdown text-white" data-toggle="dropdown"><i class="fas fa-users " style='font-size:19px'></i>
          <span>Siswa</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../siswa/index.php">Data Siswa</a></li>
          <li><a class="nav-link" href="../siswa/create.php">Tambah Siswa</a></li>
        </ul> 
      </li>
      <li class="dropdown">
        <a href="#" class="navsid nav-link has-dropdown text-white" data-toggle="dropdown"><i class='far fa-calendar-alt' style='font-size:19px'></i>
          <span>Jadwal</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../jadwal/index.php">Data Jadwal</a></li>
          <li><a class="nav-link" href="../jadwal/create.php">Tambah Jadwal</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="navsid nav-link has-dropdown text-white" data-toggle="dropdown"><i class="fas fa-book "style='font-size:19px'></i>
          <span>Rekap</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../rekap/index.php">Data Rekap Absensi</a></li>
        </ul>
      </li>
    </ul>
  </aside>
</div>

