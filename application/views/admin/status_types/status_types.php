

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Status Types</li>
            </ol>
        </div>

    </div>

    <!-- End Bread crumb and right sidebar toggle -->



    <!-- Start Page Content -->

    <div class="row">

        <div class="col-md-12">
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

        <div class="col-md-6">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h6 class="m-b-0 text-white"> New Status Type
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/statustypes/add') ?>" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Status<span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="status" class="form-control" required data-validation-required-message=" Status Type is required">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Email Notifications</label>
                                        <div class="col-md-9 controls">
                                          <div class="controls">
                                              <div class="form-check">
                                                  <label class="custom-control custom-radio">
                                                      <input name="enable_email" type="radio" value="1" class="custom-control-input" required data-validation-required-message="Email Notifications flag should be Yes or No" aria-invalid="false">
                                                      <span class="custom-control-indicator"></span>
                                                      <span class="custom-control-description">Yes</span>
                                                  </label>
                                                  <label class="custom-control custom-radio">
                                                      <input checked name="enable_email" type="radio" value="0" class="custom-control-input" required data-validation-required-message="Email Notifications flag should be Yes or No" aria-invalid="false">
                                                      <span class="custom-control-indicator"></span>
                                                      <span class="custom-control-description">No</span>
                                                  </label>
                                              </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <!-- CSRF token -->
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="col-md-9 controls">
                                            <button type="submit" class="btn btn-success">Add Status Type</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h6 class="m-b-0 text-white"> All Status Types</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive m-t-40">
                        <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                  <th>Status</th>
                                  <th>Send Email Notifications</th>
                                  <th>Active/Inactive</th>
                                  <th>Action</th>
                              </tr>
                            </thead>

                            <tbody>
                            <?php $i = 1; foreach ($statustypes as $row): ?>

                                <tr>
                                    <td><?php echo $row['status']; ?></td>

                                    <td>
                                        <?php if ($row['enable_email'] == 1): ?>
                                          <span>Yes</span>
                                        <?php else: ?>
                                          <span>No</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($row['active_ind'] == 1): ?>
                                          <span class="label label-info">Active</span>
                                        <?php else: ?>
                                          <span class="label label-danger">Inactive</span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">

                                        <a data-toggle="modal" data-target="#editModal_<?php echo $row['id'];?>" href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10"></i> </a>

                                        <a id="delete" href="<?php echo base_url('admin/statustypes/delete/'.$row['id']) ?>"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>

                                        <?php if ($row['active_ind'] == 1): ?>
                                            <a href="<?php echo base_url('admin/statustypes/deactive/'.$row['id']) ?>" data-toggle="tooltip" data-original-title="Deactive"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                        <?php else: ?>
                                            <a href="<?php echo base_url('admin/statustypes/active/'.$row['id']) ?>" data-toggle="tooltip" data-original-title="Active"> <i class="fa fa-check text-info m-r-10"></i> </a>
                                        <?php endif ?>


                                    </td>
                                </tr>

                            <?php $i++; endforeach ?>

                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- End Page Content -->

</div>



<!-- Start Edit User Power Modal  -->
<?php foreach ($statustypes as $row): ?>

<div class="modal fade" id="editModal_<?php echo $row['id'];?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Status Types</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <form method="post" action="<?php echo base_url('admin/statustypes/edit') ?>" class="form-horizontal" novalidate>
            <div class="form-body">
                <br>

                <div class="form-group">
                    <label for="type" class="control-label">Status:<span class="text-danger"></span></label>
                    <div class="controls">
                    <input type="text" class="form-control" name="status" value="<?php echo $row['status']; ?>" required data-validation-required-message=" Type Code is required" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="long_description" class="control-label">Email Notifications:</label>
                    <div class="controls">
                        <div class="form-check">
                            <label class="custom-control custom-radio">
                                <input <?php if($row['enable_email'] == 1){echo "checked";}else{echo "";} ?> name="enable_email" type="radio" value="1" class="custom-control-input" required data-validation-required-message="Email Notifications flag should be set to Yes or No" aria-invalid="false">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Yes</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input <?php if($row['enable_email'] == 0){echo "checked";}else{echo "";} ?> name="enable_email" type="radio" value="0" class="custom-control-input" required data-validation-required-message="Email Notifications flag should be set to Yes or No" aria-invalid="false">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">No</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- CSRF token -->
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger waves-effect waves-light">Save changes</button>
            </div>

        </form>


      </div>

    </div>
  </div>
</div>

<?php endforeach ?>

<!-- End Edit User Power Modal  -->
