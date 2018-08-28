

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Pending Emails</li>
            </ol>
        </div>
    </div>

    <!-- End Bread crumb and right sidebar toggle -->



    <!-- Start Page Content -->

    <div class="row">
        <div class="col-12">

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

            <div class="card">

                <div class="card-body">


                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                  <th>ASL Ref #</th>
                                  <th>Status</th>
                                  <th>Comments</th>
                                  <th>From</th>
                                  <th>To</th>
                                  <th>Subject</th>
                                  <th>Content</th>
                                  <th>Email Sent</th>
                                  <th>Email Sent On</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                  <th>ASL Ref #</th>
                                  <th>Status</th>
                                  <th>Comments</th>
                                  <th>From</th>
                                  <th>To</th>
                                  <th>Subject</th>
                                  <th>Content</th>
                                  <th>Email Sent</th>
                                  <th>Email Sent On</th>

                                </tr>
                            </tfoot>

                            <tbody>
                            <?php $i = 1; foreach ($emails as $row): ?>

                                <tr>
                                  <td><a href="<?php echo base_url('admin/jobs/job_status/'.$row['asl_reference_no']) ?>" data-toggle="tooltip" data-original-title="Edit Job"><?php echo $row['asl_reference_no']; ?> </a></td>

                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['comment']; ?></td>
                                    <td><?php echo $row['email_from']; ?></td>
                                    <td><?php echo $row['email_to']; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td>
                                      <?php if ($row['sent'] == 1): ?>
                                        <a href="#" data-toggle="tooltip" data-original-title="Email Sent"> <i class="fa fa-folder-open-o text-info m-r-10 disabled"></i> </a></th>
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



<?php foreach ($emails as $email): ?>

<div class="modal fade" id="confirm_delete_<?php echo $email['id'];?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

            <div class="form-body">

                Are you sure want to delete? <br> <hr>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?php echo base_url('admin/jobs/delete_email_queue_2/'.$email['id']) ?>" class="btn btn-danger"> Delete</a>

            </div>

      </div>


    </div>
  </div>
</div>


<?php endforeach ?>
