<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">User Settings</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->session->userdata('name'); ?></a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Change Password</h4>
                                <h6 class="card-subtitle">Please use a strong Password </h6>
                                <form method="post" action="<?php echo base_url('admin/user/changepass') ?>" enctype="multipart/form-data" class="m-t-40" novalidate>
                                  <div class="form-body">
                                      <hr>
                                  <div class="form-group">
                                      <h5>Current Password <span class="text-danger">*</span></h5>
                                      <div class="controls">
                                          <input type="password" name="password" class="form-control" required data-validation-required-message="Current password is required"> </div>

                                  </div>


                                    <div class="form-group">
                                        <h5>New Password <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="password" name="password1" class="form-control" required data-validation-required-message="This field is required" minlength="8" maxlength="12"> </div>
                                        <div class="form-control-feedback"><small>New password should be 8-12 characters.</small></div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Repeat New Password <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="password" name="password2" data-validation-match-match="password1" class="form-control" required> </div>
                                    </div>

                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                        <button type="reset" class="btn btn-inverse">Clear</button>
                                    </div>
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
