 <li class="nav-item">
                <a href="<?php echo APP_URL."dashboard/" ?>" class="nav-link <?php if ($url[0]=='dashboard') echo 'active'; else echo ''; ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo APP_URL."afiliadoList/" ?>" class="nav-link <?php if ($url[0]=='afiliadoList') echo 'active'; else echo ''; ?>">
                  <i class="nav-icon far fa-address-card text-info"></i>
                  <p>Afiliados</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo APP_URL."agenda/" ?>" class="nav-link <?php if ($url[0]=='agenda') echo 'active'; else echo ''; ?>">
                  <i class="nav-icon fa fa-sticky-note text-info"></i>
                  <p>Agenda</p>
                </a>
              </li>
              <li class="nav-header">Seguridad</li>
              <li class="nav-item <?php if ($url[0]=='userList' || $url[0]=='roList') echo 'menu-open'; else echo ''; ?>">
                <a href="#" class="nav-link <?php if ($url[0]=='userList' || $url[0]=='roList') echo 'active'; else echo ''; ?>">
                  <i class="nav-icon fas fa-key"></i>
                  <p>Seguridad<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href=<?php echo APP_URL."userList/";?> class="nav-link <?php if ($url[0]=='userList') echo 'active'; else echo ''; ?>" >
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p>Usuarios</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo APP_URL."roList/" ?>" class="nav-link <?php if ($url[0]=='roList') echo 'active'; else echo ''; ?>" >
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p>Roles</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo APP_URL."userMenu/" ?>" class="nav-link <?php if ($url[0]=='userMenu') echo 'active'; else echo ''; ?>" >
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p>Menú</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-header">Configuración</li>
              <li class="nav-item <?php if ($url[0]=='escuelaNew' || $url[0]=='sedeList' || $url[0]=='tablasNew' || $url[0]=='catalogosNew') echo 'menu-open'; else echo ''; ?>">
                <a href="#" class="nav-link <?php if ($url[0]=='escuelaNew' || $url[0]=='sedeList' || $url[0]=='tablasNew' || $url[0]=='catalogosNew') echo 'active'; else echo ''; ?>">
                  <i class="nav-icon far fa-edit"></i>
                  <p>Configuración<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo APP_URL."escuelaNew/" ?>" class="nav-link <?php if ($url[0]=='escuelaNew') echo 'active'; else echo ''; ?>" >
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p>Escuela</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo APP_URL."sedeList/" ?>" class="nav-link <?php if ($url[0]=='sedeList') echo 'active'; else echo ''; ?>" >
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p>Sedes</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo APP_URL."tablasNew/" ?>" class="nav-link <?php if ($url[0]=='tablasNew') echo 'active'; else echo ''; ?>" >
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p>Tablas</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo APP_URL."catalogosNew/" ?>" class="nav-link <?php if ($url[0]=='catalogosNew') echo 'active'; else echo ''; ?>" >
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p>Catálogos</p>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="nav-header">Salir</li>
              <li class="nav-item">
                <a href=<?php echo APP_URL."logOut/";?> class="nav-link" id="btn_exit">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p class="text">Salir</p>
                </a>
              </li>
            