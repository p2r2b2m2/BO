

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Mission</li>
            </ol>
        </div>

    </div>

    <!-- End Bread crumb and right sidebar toggle -->



    <!-- Start Page Content -->

    <div class="row">
        <div class="col-lg-12">

            <?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>

            <div class="card card-outline-info">
                <div class="card-header">
                    <h5 class="m-b-0 text-white"> Edit Mission <a href="<?php echo base_url('admin/missions') ?>" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Back</a></h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/missions/edit/'.$mission->id) ?>" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Mission Name <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" value="<?php echo $mission->mission_name; ?>" name="mission_name" class="form-control" required data-validation-required-message="Mission Name cannot be emmty">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Street </label>
                                        <div class="col-md-9 controls">
                                            <input type="text"class="form-control" name="street" value = "<?php echo $mission->street; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <div class="row">

                                  <div class="col-md-12">
                                      <div class="form-group row">
                                          <label class="control-label text-right col-md-2">City </label>
                                          <div class="col-md-9 controls">
                                              <input type="text" class="form-control" name="city" value = "<?php echo $mission->city; ?>">
                                          </div>
                                      </div>
                                  </div>
                                  <!--/span-->

                                <!--/span-->
                            </div>




                            <div class="row">

                                  <div class="col-md-12">
                                      <div class="form-group row">
                                          <label class="control-label text-right col-md-2">State </label>
                                          <div class="col-md-9 controls">
                                              <input type="text" class="form-control" name="state" value = "<?php echo $mission->state; ?>">
                                          </div>
                                      </div>
                                  </div>
                                  <!--/span-->

                                <!--/span-->
                            </div>

                            <div class="row">

                                  <div class="col-md-12">
                                      <div class="form-group row">
                                          <label class="control-label text-right col-md-2">Zip </label>
                                          <div class="col-md-9 controls">
                                              <input type="text" class="form-control" name="zip" value = "<?php echo $mission->zip; ?>">
                                          </div>
                                      </div>
                                  </div>
                                  <!--/span-->

                                <!--/span-->
                            </div>


                            <!-- CSRF token -->
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2"></label>
                                        <div class="controls">
                                            <button type="submit" class="btn btn-success">Save Mission</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End Page Content -->

</div>
