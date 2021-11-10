<nav class="position-sticky navbar navbar-expand-lg navbar-dark bg-primary ">
  <div class="container-fluid">
    <a class="navbar-brand fs-4 fw-bold bg-light text-primary rounded-3" href="?classe=Postagem&metodo=listarPostagens">Karaboqui</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!--<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>-->
      <?php  if(DataValidator::isLogado()){?>
        <li class="nav-item">
          <a class="nav-link " href="#" tabindex="-1"><?php echo 'Seja bem vindo '.$_SESSION['nm_user']; ?></a>
        </li>
                <li class="nav-item">
         
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Opções
        </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">--------</a>
            <a class="dropdown-item" href="?classe=Usuario&metodo=configu">Configurações</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="?classe=Usuario&metodo=deslogar" tabindex="-1" >
              Deslogar
            </a>
          </div>
        </li>
      <?php } ?>
      </ul>
      <!--
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>-->
    </div>
  </div>
</nav>