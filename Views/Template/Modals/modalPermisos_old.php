<style>
  .roles::-webkit-scrollbar{
        width: 5px;
        background: lightblue;
    }
    .roles::-webkit-scrollbar-thumb{
        background: #0F4B81;
        border-radius:5px;
    }
</style>

<div class="newmodal-container">
  <div class="newmodal-permisos newmodal-modalclose">
    <div class="roles" style="overflow-y:scroll">
        <h2 id="habitacion"></h2>
        <br>
        <form action="" id="formPermisos" name="formPermisos">
                 <input type="hidden" id="idtipo_usuario" name="idtipo_usuario" value="<?= $data['idtipo_usuario']; ?>" required="">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Módulo</th>
                            <th>Ver</th>
                            <th>Crear</th>
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                               $no=1;
                               $modulos = $data['modulos'];
                               for ($i=0; $i < count($modulos); $i++) { 

                                   $permisos = $modulos[$i]['permisos'];
                                   $rCheck = $permisos['r'] == 1 ? " checked " : "";
                                   $wCheck = $permisos['w'] == 1 ? " checked " : "";
                                   $uCheck = $permisos['u'] == 1 ? " checked " : "";
                                   $dCheck = $permisos['d'] == 1 ? " checked " : "";

                                   $idmod = $modulos[$i]['idmodulo'];
                              ?>
                           <tr>
                            <td>
                                <?= $no; ?>
                                <input type="hidden" name="modulos[<?= $i; ?>][idmodulo]" value="<?= $idmod ?>" required >
                            </td>
                            <td>
                                <?= $modulos[$i]['titulo']; ?>
                            </td>
                            <td><div class="toggle-flip">
                                  <label class="custom-switch">
                                    <input type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rCheck ?> class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                  </label>
                                </div>
                            </td>
                            <td><div class="toggle-flip">
                                 <label class="custom-switch">
                                    <input type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wCheck ?> class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                  </label>
                                </div>
                            </td>
                            <td><div class="toggle-flip">
                                  <label class="custom-switch">
                                    <input type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uCheck ?> class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                  </label>
                                </div>
                            </td>
                            <td><div class="toggle-flip">
                                  <label class="custom-switch">
                                    <input type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dCheck ?> class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                  </label>
                                </div>
                            </td>
                          </tr>
                          <?php 
                                $no++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="text-center">
                    <button  class="modalguardar"type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i> Guardar</button>
                        <p class="modalclose"><i class="fa fa-times-circle" aria-hidden="true"></i> Cancelar</p>
                    </div>
                </form>
                
      </div>
  </div>
</div>
