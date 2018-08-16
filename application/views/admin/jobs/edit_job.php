

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Job</li>
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
                      <a class="nav-link active" href="<?php echo base_url('admin/jobs/edit/'.$jobs->id) ?>">Job Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/shipinfo/'.$jobs->id) ?>">Shipment Info</a>
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

                              <h6 class="card-subtitle">Level one information for shipment</h6>

    <!--Start of form contenet -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h6 class="m-b-0 text-white">Edit Job</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/jobs/edit/'.$jobs->id) ?>" enctype="multipart/form-data" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Customer<span class="text-danger">*</span></label>
                                        <div class="controls">
                                          <select class="form-control select2" style="width: 100%" name="customer_id" required data-validation-required-message=" Customer should be selected">
                                              <option  value="">select</option>
                                              <?php foreach ($customers as $customer): ?>
                                                <?php
                                                    if($customer['id'] == $jobs->customer_id){
                                                        $selec = 'selected';
                                                    }else{
                                                        $selec = '';
                                                    }
                                                ?>
                                                  <option <?php echo $selec; ?>  value="<?php echo $customer['id']; ?>"><?php echo $customer['name']; ?></option>
                                              <?php endforeach ?>
                                          </select>
                                          <small class="form-control-feedback"> In format of first name last name and mission. </small>
                                        </div>
                                      </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Job Type<span class="text-danger">*</span></label>
                                        <div class="controls">
                                           <select class="form-control select2" style="width: 100%" name="job_type_id" required data-validation-required-message=" Job type should be selected">
                                               <option  value="">select</option>
                                               <?php foreach ($jobtypes as $jobtype): ?>
                                                 <?php
                                                     if($jobtype['id'] == $jobs->job_type_id){
                                                         $selec = 'selected';
                                                     }else{
                                                         $selec = '';
                                                     }
                                                 ?>
                                                   <option <?php echo $selec; ?>  value="<?php echo $jobtype['id']; ?>"><?php echo $jobtype['type']; ?></option>
                                               <?php endforeach ?>

                                           </select>
                                         </div>
                                      </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">ASL Reference#</label>
                                        <input type="text" name="asl_reference_no" class="form-control" placeholder="" value="<?php echo $jobs->asl_reference_no; ?>"readonly>
                                        <small class="form-control-feedback"> Will be generated when the job is created.</small>
                                      </div>
                                </div>


                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Invoice Number</label>
                                        <div class="controls">
                                           <input type="text" name="invoice_number" class="form-control" value="<?php echo $jobs->invoice_number; ?>">
                                         </div>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-2">

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-success">
                                        <label class="control-label">Job Class</label>
                                        <div class="controls">
                                            <div class="form-check">
                                                <label class="custom-control custom-radio">
                                                    <input <?php if($jobs->job_class == 'Moving'){echo "checked";}else{echo "";} ?> name="job_class" type="radio" value="Moving" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Moving</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input <?php if($jobs->job_class == 'Commercial'){echo "checked";}else{echo "";} ?>  name="job_class" type="radio" value="Commercial" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Commercial</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input <?php if($jobs->job_class == ''){echo "checked";}else{echo "";} ?>  name="job_class" type="radio" value="" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Not Sure</span>
                                                </label>
                                              <!--  <button type="button" class="btn btn-inverse">Reset</button> -->
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                              <div class="col-md-4 controls">
                                  <div class="form-group">
                                      <label class="control-label">Port Of Loading</label>
                                      <div class="controls">
                                         <input type="text" name="load_port" class="form-control" value="<?php echo $jobs->load_port; ?>">
                                       </div>
                                    </div>
                              </div>
                                <!--/span-->
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Port Of Discharge</label>
                                        <div class="controls">
                                           <input type="text" name="discharge_port" class="form-control" value="<?php echo $jobs->discharge_port; ?>">
                                         </div>
                                      </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4 controls">
                                    <div class="form-group">
                                        <label class="control-label">Final Destination</label>
                                        <div class="controls">
                                           <input type="text" name="final_destination" class="form-control" value="<?php echo $jobs->final_destination; ?>">
                                         </div>
                                      </div>
                                </div>
                            </div>
                            <!--/row-->
                            <h3 class="box-title m-t-40">Pick Up Address</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Address 1</label>
                                        <input type="text" name="pa_1" class="form-control" value="<?php echo $jobs_addr->pa_1; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Address 2</label>
                                        <input type="text" name="pa_2" class="form-control" value="<?php echo $jobs_addr->pa_2; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="pa_city" class="form-control" value="<?php echo $jobs_addr->pa_city; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="pa_state" class="form-control" value="<?php echo $jobs_addr->pa_state; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Zip Code</label>
                                        <input type="text" name="pa_zip" class="form-control" value="<?php echo $jobs_addr->pa_zip; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="pa_country" class="form-control" value="<?php echo $jobs_addr->pa_country; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <h3 class="box-title m-t-40">Destination Address</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Address 1</label>
                                        <input type="text" name="da_1" class="form-control" value="<?php echo $jobs_addr->da_1; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Address 2</label>
                                        <input type="text" name="da_2" class="form-control" value="<?php echo $jobs_addr->da_2; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="da_city" class="form-control" value="<?php echo $jobs_addr->da_city; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State/Province</label>
                                        <input type="text" name="da_state_province" class="form-control" value="<?php echo $jobs_addr->da_state_province; ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="da_country" class="form-control" value="<?php echo $jobs_addr->da_country; ?>">
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
