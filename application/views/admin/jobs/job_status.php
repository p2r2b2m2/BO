

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
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/edit/'.$jobs->id) ?>">Job Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/shipinfo/'.$jobs->id) ?>">Shipment</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/doccontrol/'.$jobs->id) ?>">Doc Control</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/job_docs/'.$jobs->id) ?>">Uploads</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="<?php echo base_url('admin/jobs/job_status/'.$jobs->id) ?>">Status</a>
                    </li>
                  </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" role="tabpanel">
                            <div class="p-20">
                              <h6 class="card-subtitle">Some status types are configured to send customer email notifications.</h6>
                              <h6 class="card-subtitle">You can use the email queue to trigger emails to the customers to send status updates.</h6>


                              <div class="row">

                                  <div class="col-md-8">
                                    <div class="row">
                                      <div class="col-md-12">
                                      <div class="card card-outline-info">
                                          <div class="card-header">
                                              <h6 class="m-b-0 text-white"> New Status Update
                                          </div>
                                          <div class="card-body">
                                              <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/jobs/job_status/'.$jobs->id) ?>" class="form-horizontal" novalidate>
                                                  <div class="form-body">
                                                      <br>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="form-group row">
                                                                  <label class="control-label text-right col-md-3">New Status <span class="text-danger">*</span></label>
                                                                  <div class="col-md-9 controls">
                                                                      <select class="form-control" name="status_id" required data-validation-required-message=" Status type should be selected">
                                                                          <option  value="">--Select Status Type--</option>

                                                                          <?php foreach ($statuses as $status): ?>
                                                                              <option  value="<?php echo $status['id']; ?>"><?php echo $status['status']; ?></option>
                                                                          <?php endforeach ?>

                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <!--/span-->
                                                      </div>



                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="form-group row">
                                                                  <label class="control-label text-right col-md-3">Comments</label>
                                                                  <div class="col-md-9 controls">
                                                                    <input type="text" name="comment" class="form-control"  >
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
                                                                      <button type="submit" class="btn btn-success">Update Status</button>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>


                                                  </div>

                                              </form>
                                          </div>
                                      </div>

                                      <!-- email queue goes after here -->
                                      </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                        <!-- email queue goes after here -->
                                        <div class="card card-outline-info">
                                            <div class="card-header">
                                                <h6 class="m-b-0 text-white"> Email Queue</h6>
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive m-t-40">
                                                    <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                              <th>Status</th>
                                                              <th>Comments</th>
                                                              <th>From</th>
                                                              <th>To</th>
                                                              <th>Subject</th>
                                                              <th>Content</th>
                                                              <th>Email Sent</th>
                                                              <th>Email Sent On</th>
                                                              <th>Action</th>
                                                          </tr>
                                                        </thead>

                                                        <tbody>
                                                        <?php $i = 1; foreach ($equeue as $row): ?>

                                                            <tr>
                                                                <td><?php echo $row['status']; ?></td>
                                                                <td><?php echo $row['comment']; ?></td>
                                                                <td><?php echo $row['email_from']; ?></td>
                                                                <td><?php echo $row['email_to']; ?></td>
                                                                <td><?php echo $row['subject']; ?></td>
                                                                <td>
                                                                  <?php if ($row['sent'] == 1): ?>
                                                                    <a href="" data-toggle="tooltip" data-original-title="Email Sent"> <i class="fa fa-folder-open-o text-info m-r-10 disabled"></i> </a></th>
                                                                  <?php else: ?>
                                                                    <a href="<?php echo base_url('admin/jobs/edit_email/'.$row['id']) ?>" data-toggle="tooltip" data-original-title="Edit Before Sending"> <i class="fa fa-folder-open text-info m-r-10"></i> </a></th>
                                                                  <?php endif ?>

                                                                <td>
                                                                    <?php if ($row['sent'] == 1): ?>
                                                                      <span class="label label-info">Yes</span>
                                                                    <?php else: ?>
                                                                      <span class="label label-danger">No</span>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td><?php echo $row['sent_date']; ?></td>

                                                                <td class="text-nowrap">

                                                                    <a id="delete" href="<?php echo base_url('admin/jobs/delete_email_queue/'.$row['id']) ?>"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>
                                                                    <?php if ($row['sent'] == 0): ?>
                                                                        <a href="<?php echo base_url('admin/jobs/send_mail/'.$row['id']) ?>" data-toggle="tooltip" data-original-title="Send"> <i class="fa fa-send text-info m-r-10"></i> </a>
                                                                    <?php else: ?>
                                                                        <a href="#" data-toggle="tooltip" data-original-title="Sent"> <i class="fa fa-check-circle text-info m-r-10"></i> </a>
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


                                </div>


                                  <div class="col-md-4">
                                      <div class="card card-outline-info">
                                          <div class="card-header">
                                              <h6 class="m-b-0 text-white"> Status History</h6>
                                          </div>
                                          <div class="card-body">

                                              <div class="table-responsive m-t-40">
                                                  <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                      <thead>
                                                          <tr>
                                                            <th>Status</th>
                                                            <th>Comments</th>
                                                          <!--  <th>Updated By</th>-->
                                                            <th>Updated On</th>
                                                            <th>Action</th>
                                                        </tr>
                                                      </thead>

                                                      <tbody>
                                                      <?php $i = 1; foreach ($status_hist as $row): ?>

                                                          <tr>
                                                              <td><?php echo $row['status']; ?></td>
                                                              <td><?php echo $row['comment']; ?></td>
                                                             
                                                              <td><?php echo $row['updated_on']; ?></td>

                                                              <td class="text-nowrap">

                                                                  <a id="delete" href="<?php echo base_url('admin/jobs/delete_status_history/'.$row['id']) ?>"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>

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


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
      </div>




    <!-- End Page Content -->

</div>
