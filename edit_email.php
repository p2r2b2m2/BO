
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?= base_url()?>global/admin//bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>


  <!-- Bootstrap core CSS -->
  <link href="<?= base_url()?>global/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->

  <script type="text/javascript" src="<?= base_url() ?>global/admin/ckeditor/ckeditor.js"></script>


<script>
    $(document).ready(function(){

        CKEDITOR.replace( 'textEditor', {
        disallowedContent : 'img{width,height}',
        customConfig: '../ckeditor/config.js',
        uiColor: '#3592E0',
        codeSnippet_theme: 'atelier-dune.light'
    });
    });

</script>

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

    <div class="col-sm-9 col-sm-offset-3 col-md-6 col-md-offset-2 main">
        <h1 class="page-header">Edit Email Template</h1>

        <?= form_open_multipart(base_url('admin/jobs/edit_email/'.$id), array('class' => 'form-horizontal')) ?>



        <div class="form-group">
            <label class="control-label" for="activation_mail">From Mail</label>
            <input type="text" name="email_from" class="form-control" value="<?= set_value('email_from', $email_from) ?>"
                   placeholder="email_from">

            <p class="text-red"><?= form_error('email_from'); ?></p>
        </div>

        <div class="form-group">
            <label class="control-label" for="activation_mail">To Mail</label>
            <input type="text" name="email_to" class="form-control" value="<?= set_value('email_from', $email_to) ?>"
                   placeholder="email_to">

            <p class="text-red"><?= form_error('email_from'); ?></p>
        </div>

        <div class="form-group">
            <label class="control-label" for="activation_subject">Subject</label>
            <input type="text" name="subject" class="form-control"  value="<?= set_value('subject', $subject) ?>"
                   placeholder="activation_subject">

            <p class="text-red"><?= form_error('subject'); ?></p>
        </div>

        <div class="form-group">
            <label class="control-label" for="activation_content">Content</label>
            <textarea  rows="5" cols="30" id="textEditor" name="content" class="form-control"
                                           placeholder="activation_content"><?= set_value('content',$content) ?></textarea>
            <p class="text-red"><?= form_error('content'); ?></p>
        </div>

        <input class="btn btn-primary" type="submit" name="save" value="Edit mail template"/>

        <a class="btn btn-info" href="<?= base_url('admin/jobs/job_status/'.$jobid) ?>">Go Back To Status Tab</a>

        <?php echo form_close(); ?>
    </div>
</div>

<script src="<?= base_url()?>global/bootstrap/assets/js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url()?>global/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
