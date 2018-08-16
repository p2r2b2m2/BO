
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

        <?= form_open_multipart(base_url('admin/mailing_settings/edit/'.$id), array('class' => 'form-horizontal')) ?>



        <div class="form-group">
            <label class="control-label" for="activation_mail">Template From Mail</label>
            <input type="text" name="activation_mail" class="form-control" value="<?= set_value('activation_mail', $activation_mail) ?>"
                   placeholder="activation_mail">

            <p class="text-red"><?= form_error('activation_mail'); ?></p>
        </div>

        <div class="form-group">
            <label class="control-label" for="activation_subject">Template Subject</label>
            <input type="text" name="activation_subject" class="form-control"  value="<?= set_value('activation_subject', $activation_subject) ?>"
                   placeholder="activation_subject">

            <p class="text-red"><?= form_error('activation_subject'); ?></p>
        </div>

        <div class="form-group">
            <label class="control-label" for="activation_content">Template Content</label>
            <textarea  rows="5" cols="30" id="textEditor" name="activation_content" class="form-control"
                                           placeholder="activation_content"><?= set_value('activation_content',$activation_content) ?></textarea>
            <p class="text-red"><?= form_error('activation_content'); ?></p>
        </div>

        <input class="btn btn-primary" type="submit" name="save" value="Edit mail template"/>

        <a class="btn btn-info" href="<?= base_url('admin/mailing_settings/send_mail/'.$id) ?>">Send Test Email</a>

        <?php echo form_close(); ?>
    </div>
</div>

<script src="<?= base_url()?>global/bootstrap/assets/js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url()?>global/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
