

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add New Job</li>
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
                    <h6 class="card-subtitle">Complete this form to proceed to other tabs</h6>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="">Job Info</a>
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
                      <h6 class="m-b-0 text-white">New Job</h6>
                  </div>
                  <div class="card-body">
                      <form method="post" action="<?php echo base_url('admin/jobs/add/0') ?>" enctype="multipart/form-data" class="form-horizontal" novalidate>
                          <div class="form-body">
                              <hr>
                              <div class="row p-t-20">
                                  <div class="col-md-4 controls">
                                      <div class="form-group">
                                          <label class="control-label">Customer<span class="text-danger">*</span></label>
                                          <div class="controls">
                                            <select class="form-control select2" style="width: 90%" name="customer_id" required data-validation-required-message=" Customer should be selected">
                                                <option  value="">select</option>
                                                <?php foreach ($customers as $customer): ?>
                                                  <?php
                                                      if($customer['id'] == $newcustomer){
                                                          $selec = 'selected';
                                                      }else{
                                                          $selec = '';
                                                      }
                                                  ?>
                                                    <option <?php echo $selec; ?>  value="<?php echo $customer['id']; ?>"><?php echo $customer['name']; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <a data-toggle="modal" style="width: 90%" data-target="#editModal_" href="#"  data-original-title="Quick Add"> <i data-toggle="tooltip" data-original-title="Quick Add" class="fa fa-drivers-license-o text-success m-r-10 fa-lg"></i> </a>

                                          </div>
                                          <small class="form-control-feedback"> In format of name and mission. </small>
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
                                                     <option  value="<?php echo $jobtype['id']; ?>"><?php echo $jobtype['type']; ?></option>
                                                 <?php endforeach ?>

                                             </select>
                                           </div>
                                        </div>
                                  </div>


                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label">ASL Reference#</label>
                                          <input type="text" name="asl_reference_no" class="form-control" placeholder="" readonly>
                                          <small class="form-control-feedback"> Will be generated when the job is created.</small>
                                        </div>
                                  </div>


                                  <!--/span-->
                              </div>
                              <!--/row-->
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label">Invoice Number</label>
                                          <div class="controls">
                                             <input type="text" name="invoice_number" class="form-control">
                                           </div>
                                      </div>
                                  </div>
                                  <!--/span-->

                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">HBL Number</label>
                                        <input type="text" name="hbl_number" class="form-control" placeholder="" readonly>
                                        <small class="form-control-feedback"> Will be generated when the job is created.</small>
                                      </div>

                                  </div>

                                  <div class="col-md-4">
                                      <div class="form-group has-success">
                                          <label class="control-label">Job Class</label>
                                          <div class="controls">
                                              <div class="form-check">
                                                  <label class="custom-control custom-radio">
                                                      <input name="job_class" type="radio" value="Moving" class="custom-control-input">
                                                      <span class="custom-control-indicator"></span>
                                                      <span class="custom-control-description">Moving</span>
                                                  </label>
                                                  <label class="custom-control custom-radio">
                                                      <input name="job_class" type="radio" value="Commercial" class="custom-control-input">
                                                      <span class="custom-control-indicator"></span>
                                                      <span class="custom-control-description">Commercial</span>
                                                  </label>
                                                  <label class="custom-control custom-radio">
                                                      <input name="job_class" type="radio" value="" class="custom-control-input" checked>
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
                                           <input type="text" name="load_port" class="form-control">
                                         </div>
                                      </div>
                                </div>
                                  <!--/span-->
                                  <div class="col-md-4 controls">
                                      <div class="form-group">
                                          <label class="control-label">Port Of Discharge</label>
                                          <div class="controls">
                                             <input type="text" name="discharge_port" class="form-control">
                                           </div>
                                        </div>
                                  </div>
                                  <!--/span-->
                                  <div class="col-md-4 controls">
                                      <div class="form-group">
                                          <label class="control-label">Final Destination</label>
                                          <div class="controls">
                                             <input type="text" name="final_destination" class="form-control">
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
                                          <input type="text" name="pa_1" class="form-control">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label>Address 2</label>
                                          <input type="text" name="pa_2" class="form-control">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>City</label>
                                          <input type="text" name="pa_city" class="form-control">
                                      </div>
                                  </div>
                                  <!--/span-->
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>State</label>
                                          <input type="text" name="pa_state" class="form-control">
                                      </div>
                                  </div>
                                  <!--/span-->
                              </div>
                              <!--/row-->
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>Zip Code</label>
                                          <input type="text" name="pa_zip" class="form-control">
                                      </div>
                                  </div>
                                  <!--/span-->
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>Country</label>
                                          <input type="text" name="pa_country" class="form-control">
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
                                          <input type="text" name="da_1" class="form-control">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label>Address 2</label>
                                          <input type="text" name="da_2" class="form-control">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label>City</label>
                                          <input type="text" name="da_city" class="form-control">
                                      </div>
                                  </div>
                                  <!--/span-->
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label>State/Province</label>
                                          <input type="text" name="da_state_province" class="form-control">
                                      </div>
                                  </div>
                                  <!--/span-->
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label>Country</label>
                                          <input type="text" name="da_country" class="form-control">
                                      </div>
                                  </div>
                              </div>
                              <!--/row-->

                              <!-- CSRF token -->
                              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                          </div>
                          <div class="form-actions">
                              <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
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


<div class="modal fade" id="editModal_">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Quick Add Customer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <form method="post" action="<?php echo base_url('admin/customers/easy_customer') ?>" class="form-horizontal" novalidate>
            <div class="form-body">
                <br>

                <div class="form-group">
                    <label for="name" class="control-label">Name:<span class="text-danger"></span></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="name"  required data-validation-required-message=" Customer name is required" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">Email:</label>
                    <div class="controls">
                    <input type="text" name="email" class="form-control" required data-validation-required-message=" Email is required"  >
                    </div>
                </div>

                <div class="form-group has-success">
                    <label class="control-label">Mission</label>
                    <select class="form-control select2" style="width: 100%" name="mission_id">

                        <?php foreach ($missions as $mission): ?>
                            <option  value="<?php echo $mission['id']; ?>"><?php echo $mission['mission_name']; ?></option>
                        <?php endforeach ?>

                    </select>
                    <small class="form-control-feedback"> Select Mission</small> </div>

                <!-- CSRF token -->
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="hidden" name="id" value="0">




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger waves-effect waves-light">Create</button>
            </div>

        </form>


      </div>

    </div>
  </div>
</div>
