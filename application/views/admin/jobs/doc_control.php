

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Document Control</li>
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
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/edit/'.$jobs->job_id) ?>">Job Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/shipinfo/'.$jobs->job_id) ?>">Shipment Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="<?php echo base_url('admin/jobs/doccontrol/'.$jobs->job_id) ?>">Doc Control</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="<?php echo base_url('admin/jobs/job_docs/'.$jobs->job_id) ?>">Doc Upload</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/job_status/'.$jobs->job_id) ?>">Status & Notifications</a>
                    </li>
                  </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" role="tabpanel">
                            <div class="p-20">

                              <h6 class="card-subtitle">Leave the date as blank if the section is not applicable</h6>

    <!--Start of form contenet -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h6 class="m-b-0 text-white">Document Control</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/jobs/doccontrol/'.$jobs->job_id) ?>" enctype="multipart/form-data" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <hr>
                            <div class="row p-t-20">
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>AES</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->aes == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="aes" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="aes_date" class="form-control" value = "<?php echo $jobs->aes_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Insurance</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->ins == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="ins" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="ins_date" class="form-control" value = "<?php echo $jobs->ins_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Packing List</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->pl == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="pl" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="pl_date" class="form-control" value = "<?php echo $jobs->pl_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Dock Receipt</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->dr == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="dr" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="dr_date" class="form-control" value = "<?php echo $jobs->dr_date; ?>">
                                      </div>
                                  </div>
                              </div>

                            </div>
                            <!--/row-->



                            <div class="row">

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>MLB Copy Sent</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->mlb_sent == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="mlb_sent" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="mlb_sent_date" class="form-control" value = "<?php echo $jobs->mlb_sent_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>MLB Approved</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->mlb_approved == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="mlb_approved" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="mlb_approved_date" class="form-control" value = "<?php echo $jobs->mlb_approved_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Customer Invoiced</h5>
                                      <div >
                                          <h6 class="card-subtitle">Date customer was invoiced</h6>
                                      </div>
                                      <div >
                                              <input type="date"  name="invoiced_date" class="form-control" value = "<?php echo $jobs->invoiced_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Payment Received</h5>
                                      <div >
                                              <input type="date"  name="payment_date" class="form-control" value = "<?php echo $jobs->payment_date; ?>">
                                      </div>
                                      <div >
                                              <input type="text"  name="payment_comment" class="form-control" placeholder="comments related to payments.ie.partialy paid" value = "<?php echo $jobs->payment_comment; ?>">
                                      </div>

                                  </div>
                              </div>

                            </div>
                            <!--/row-->
                            <div class="row">

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Line Paid</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->line_paid == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="line_paid" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="line_paid_date" class="form-control" value = "<?php echo $jobs->line_paid_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>MLB Received</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->mlb_received == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="mlb_received" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="mlb_received_date" class="form-control" value = "<?php echo $jobs->mlb_received_date; ?>">
                                      </div>
                                      <div >
                                              <input type="text"  name="mlb_received_comment" class="form-control" placeholder="additional comments.ie.Express" value = "<?php echo $jobs->mlb_received_comment; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Docs Sent To Customer</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->ds_to_customer == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="ds_to_customer" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="ds_to_customer_date" class="form-control" value = "<?php echo $jobs->ds_to_customer_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Docs Sent To Agent</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->ds_to_agent == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="ds_to_agent" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="ds_to_agent_date" class="form-control" value = "<?php echo $jobs->ds_to_agent_date; ?>">
                                      </div>
                                  </div>
                              </div>

                            </div>
                            <!--/row-->
                            <div class="row">
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Agent Paid</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->agent_paid == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="agent_paid" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="agent_paid_date" class="form-control" value = "<?php echo $jobs->agent_paid_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>Signed Delivery Order</h5>
                                      <div class="controls">
                                          <label class="custom-control custom-checkbox">
                                              <input <?php if($jobs->signed_do == 'N'){echo "checked";}else{echo "";} ?> type="checkbox"  value="N" name="signed_do" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">N/A</span> </label>
                                      </div>
                                      <div >
                                              <input type="date"  name="signed_do_date" class="form-control" value = "<?php echo $jobs->signed_do_date; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <h5>File Closed</h5>
                                      <div >
                                          <h6 class="card-subtitle">After filling this field, job will no longer appear under open jobs.</h6>
                                      </div>
                                      <div >
                                              <input type="date"  name="file_closed" class="form-control" value = "<?php echo $jobs->file_closed; ?>">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-3">
                              </div>

                            </div>
                            <!--/row-->







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
