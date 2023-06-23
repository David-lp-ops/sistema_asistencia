<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center"><b><span class="employee_name"></span></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="schedule_employee_edit.php">
                    <input type="hidden" id="empid" name="id">
                    <input type="hidden" id="dias_tardados" name="dias_tardados">
                    <div class="row" style="width: 900px; height:600px; display: flex; align-items: center; justify-content: center;">
  <div class="col-sm-5 text-center">
    <div style="text-align:center;">
      <span  style="font-weight:bold;">Foto de perfil</span><br>
      <img id="profile_image" src="../images/profile.jpg" width="400px" height="400px" class="perfil">
    </div>
  </div>
  <div class="col-sm-7 text-center">
    <div class="form-group">
      <label for="edit_schedule" class="control-label">
                <div class="form-group" style="margin-top: 40px; padding-top: 50px;">
                    <label for="employee_val" class="col-sm-3 control-label">Código de Practicante</label>

                    <div class="col-sm-9">
                      <input  type="text" class="form-control" name="employee_val" id="employee_val" readonly>
                      </input>
                    </div>
                </div>
        
                <div class="form-group">
                    <label for="negocio" class="col-sm-3 control-label">Area</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="negocio" id="negocio_valv2" readonly>
                        
                      </input>
                    </div>
                </div>

                <div class="form-group">
                    <label for="position_valv2" class="col-sm-3 control-label">Cargo</label>

                    <div class="col-sm-9">
                      <input  type="text" class="form-control" name="position" id="position_valv2" readonly>
                      </input>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0px;">
                    <label for="dias_trabajados" class="col-sm-3 control-label">Dias Trabajados</label>

                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="dias_trabajados" id="dias_trabajados" readonly>
                      </input>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0px;">
                    <label for="dias_faltados" class="col-sm-3 control-label">Dias Faltados</label>

                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="dias_faltados" id="dias_faltados" readonly>
                      </input>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0px;">
                    <label for="sum_num_hr" class="col-sm-3 control-label">Horas de Trabajo</label>

                    <div class="col-sm-9">
                      <input  type="text" class="form-control" name="sum_num_hr" id="sum_num_hr" readonly>
                      </input>
                    </div>
                </div>
                <div class="form-group">
                  <div>
                    <canvas id="myChart" width="375" height="375" style="box-sizing: border-box; display: block; height: 300px; width: 300px; padding-top: 0px; margin: 10px 50px 50px;"></canvas>
                  </div>
                </div>
      </label>
      
    </div>
  </div>
</div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
                 


