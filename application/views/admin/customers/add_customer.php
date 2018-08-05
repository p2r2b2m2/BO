<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
   <!-- ============================================================== -->
   <!-- Bread crumb and right sidebar toggle -->
   <!-- ============================================================== -->
   <div class="row page-titles">
       <div class="col-md-5 col-8 align-self-center">
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
               <li class="breadcrumb-item active">Add Customer</li>
           </ol>
       </div>

   </div>
   <!-- ============================================================== -->
   <!-- End Bread crumb and right sidebar toggle -->
   <!-- ============================================================== -->
   <!-- ============================================================== -->
   <!-- Start Page Content -->
   <!-- ============================================================== -->
   <!-- Row -->
   <div class="row">
       <!-- Column -->

       <!-- Column -->
       <!-- Column -->
       <div class="col-lg-12">
           <div class="card">
               <!-- Nav tabs -->
               <ul class="nav nav-tabs profile-tab" role="tablist">
                   <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><strong>Contact</strong></a> </li>
              </ul>
               <!-- Tab panes -->
               <div class="tab-content">

                 <div class="tab-pane active" id="home" role="tabpanel">
                     <div class="card-body">
                       <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/customers/add') ?>" class="form-horizontal form-material" novalidate>
                            <div class="form-group">
                                 <label class="col-md-12">First Name <span class="text-danger">*</span></label>
                                 <div class="col-md-12">
                                     <input type="text" name="first_name"  required="" class="form-control">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-12">Last Name <span class="text-danger">*</span></label>
                                 <div class="col-md-12">
                                     <input type="text"  name="last_name"  required="" class="form-control">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-12">Mission</label>
                                 <div class="col-sm-12">
                                   <select class="form-control custom-select" name="mission_id" aria-invalid="false">
                                       <?php foreach ($missions as $mission): ?>
                                           <option value="<?php echo $mission['id']; ?>"><?php echo $mission['mission_name']; ?></option>
                                       <?php endforeach ?>
                                   </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="example-email" class="col-md-12">Email <span class="text-danger">*</span></label>
                                 <div class="col-md-12">
                                     <input type="email" name="email" placeholder="johnathan@admin.com" required="" class="form-control" name="example-email">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-12">Phone No</label>
                                 <div class="col-md-12">
                                     <input type="text" name="phone" class="form-control">
                                 </div>
                             </div>

                             <!-- CSRF token -->
                             <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />


                             <div class="form-group">
                                 <div class="col-sm-12">
                                     <button class="btn btn-success">Save Customer</button>
                                 </div>
                             </div>

                         </form>
                     </div>
                 </div>

                   <!--second tab-->
               </div>
           </div>
       </div>
       <!-- Column -->
   </div>
   <!-- Row -->
   <!-- ============================================================== -->
   <!-- End PAge Content -->
   <!-- ============================================================== -->

</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
