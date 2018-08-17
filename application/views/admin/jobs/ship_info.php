

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Shipment Info</li>
            </ol>
        </div>

    </div>

    <!-- End Bread crumb and right sidebar toggle -->



    <!-- Start Page Content -->

    <div class="row">
        <div class="col-lg-12">
          <?php $msg = $this->session->flashdata('msg'); ?>
          <?php if (isset($msg)): ?>
              <div class="alert alert-success delete_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> <?php echo $msg; ?> &nbsp;
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
              </div>
          <?php endif ?>

            <?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Job</h4>
                    <h6 class="card-subtitle">Complete all applicable tabs</h6>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/edit/'.$jobs->id) ?>">Job Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="<?php echo base_url('admin/jobs/shipinfo/'.$jobs->id) ?>">Shipment Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/doccontrol/'.$jobs->id) ?>">Doc Control</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="<?php echo base_url('admin/jobs/job_docs/'.$jobs->id) ?>">Doc Upload</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/job_status/'.$jobs->id) ?>">Status & Notifications</a>
                    </li>
                  </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" role="tabpanel">
                            <div class="p-20">

                              <h6 class="card-subtitle">Shipping Information</h6>

    <!--Start of form contenet -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h6 class="m-b-0 text-white">Shipment info</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/jobs/shipinfo/'.$jobs->id) ?>" enctype="multipart/form-data" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Carrier Booking Number</label>
                                        <div class="controls">
                                          <input type="text" name="c_booking_number" class="form-control" placeholder="" value="<?php echo $jobs->c_booking_number; ?>">
                                          <small class="form-control-feedback"></small>
                                        </div>
                                      </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Container Number</label>
                                        <input type="text" name="container_number" class="form-control" placeholder="" value="<?php echo $jobs->container_number; ?>">
                                        <small class="form-control-feedback"></small>
                                      </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Seal Number</label>
                                        <input type="text" name="seal_number" class="form-control" placeholder="" value="<?php echo $jobs->seal_number; ?>">
                                        <small class="form-control-feedback"></small>
                                      </div>
                                </div>
                            </div>
                            <!--/row-->


                            <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="control-label">NVOCC/Carrier</label>
                                      <input type="text" name="carrier" class="form-control" placeholder="" value="<?php echo $jobs->carrier; ?>">
                                      <small class="form-control-feedback"></small>
                                    </div>
                              </div>
                                <!--/span-->


                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label">Vessel/Voyage</label>
                                          <input type="text" name="vessel_voyage" class="form-control" placeholder="" value="<?php echo $jobs->vessel_voyage; ?>">
                                          <small class="form-control-feedback"></small>
                                        </div>
                                  </div>

                                  <div class="col-md-4 controls">
                                      <div class="form-group">
                                          <label class="control-label">Equipment</label>
                                          <div class="controls">
                                             <select class="form-control select2" style="width: 100%" name="equipment_type_id">

                                                 <?php foreach ($equipments as $equipment): ?>
                                                   <?php
                                                       if($equipment['id'] == $jobs->equipment_type_id){
                                                           $selec = 'selected';
                                                       }else{
                                                           $selec = '';
                                                       }
                                                   ?>
                                                     <option <?php echo $selec; ?>  value="<?php echo $equipment['id']; ?>"><?php echo $equipment['type']; ?></option>
                                                 <?php endforeach ?>

                                             </select>
                                           </div>
                                        </div>
                                  </div>



                            </div>
                            <!--/row-->
                            <div class="row">
                              <div class="col-md-4 controls">
                                  <div class="form-group">
                                      <label class="control-label">BL Number <a href="<?php echo base_url('admin/jobs/edit_bl/'.$jobs->id) ?>" data-toggle="tooltip" data-original-title="Create/Edit BL"> <i class="fa fa-folder-open text-info m-r-10"></i> </a></label>
                                      <div class="controls">
                                         <input type="text" name="bl_number" class="form-control" value="<?php echo $jobs->bl_number; ?>">
                                       </div>
                                    </div>
                              </div>
                                <!--/span-->
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Weight(Kgs)</label>
                                        <div class="controls">
                                           <input type="number" step="0.01" name="weight" class="form-control" value="<?php echo $jobs->weight; ?>">
                                         </div>
                                      </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Measure(cbm)</label>
                                        <div class="controls">
                                           <input type="number" step="0.01" name="measure" class="form-control" value="<?php echo $jobs->measure; ?>">
                                         </div>
                                      </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                              <div class="col-md-4 controls">
                                  <div class="form-group">
                                      <label class="control-label">AES ITN</label>
                                      <div class="controls">
                                         <input type="text" name="aes_itn" class="form-control" value="<?php echo $jobs->aes_itn; ?>">
                                       </div>
                                    </div>
                              </div>
                                <!--/span-->
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Sail Date</label>
                                        <div class="controls">
                                           <input type="date" name="sail_date" class="form-control" value="<?php echo $jobs->sail_date; ?>">
                                         </div>
                                      </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">ETA</label>
                                        <div class="controls">
                                           <input type="date" name="eta" class="form-control" value="<?php echo $jobs->eta; ?>">
                                         </div>
                                      </div>
                                </div>
                            </div>
                            <!--/row-->


                            <h3 class="box-title m-t-40">Destination Agent Address</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Agent Name</label>
                                        <input type="text" name="agent_name" class="form-control" value="<?php echo $jobs_addr->agent_name; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Agent Email</label>
                                        <input type="email" name="agent_email" class="form-control" value="<?php echo $jobs_addr->agent_email; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Agent Phone</label>
                                        <input type="text" name="agent_phone" class="form-control" value="<?php echo $jobs_addr->agent_phone; ?>">
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Address 1</label>
                                        <input type="text" name="aga_1" class="form-control" value="<?php echo $jobs_addr->aga_1; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Address 2</label>
                                        <input type="text" name="aga_2" class="form-control" value="<?php echo $jobs_addr->aga_2; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="aga_city" class="form-control" value="<?php echo $jobs_addr->aga_city; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State/Province</label>
                                        <input type="text" name="aga_state_province" class="form-control" value="<?php echo $jobs_addr->aga_state_province; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="aga_country" class="form-control" value="<?php echo $jobs_addr->aga_country; ?>">
                                    </div>
                                </div>
                            </div>
                            <!--/row-->

                            <!-- CSRF token -->
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <button type="button" class="btn btn-inverse">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>







    <!--End Of form -->










                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
      </div>




    <!-- End Page Content -->

</div>
