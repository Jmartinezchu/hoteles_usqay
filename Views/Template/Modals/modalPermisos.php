<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Permisos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
            <div class="modal-body">
                <form id="formPermisos" name="formPermisos">
                <input type="hidden" id="idtipo_usuario" name="idtipo_usuario" value="<?= $data['idtipo_usuario']; ?>" required="">
                    <div class="row">                                
                        <div class="table-responsive">
                            <table id="tableHabitacion" class="table dt-responsive nowrap w-100">
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
                        </div> <!-- end preview-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button onclick="fntSavePermisos()" type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div> <!-- end tab-content-->
                </form>
            </div>
    </div>
</div>
</div>