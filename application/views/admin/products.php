<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?= base_url('/admin/dashboard') ?>">Admin</a>
    </div>
    <ul class="nav navbar-nav">
      <li ><a href="<?= base_url('/admin/dashboard') ?>">Home</a></li>
      <li class="active"><a href="<?= base_url('/admin/products') ?>">Products</a></li>
      
    </ul>
   
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?= base_url('admin/logout'); ?>"> Logout</a></li>
    </ul>
    
  </div>
</nav>
    
  
  
    
    <div class="container" id="add_products">
        <div class="row">
            <div class="col-sm-4">
                <?php
                    if($this->session->flashdata('message')){
                        ?>
                        <div class="alert alert-info text-center">
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                        <?php
                        unset($_SESSION['message']);
                    }	
                ?>

                <h3 class="text-center">Add Product</h3>
                <form method="post" action="<?= base_url('admin/add_product') ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email">Title</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>
                    <div class="form-group">
                        <label for="password">Description:</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">Image:</label>
                        <input type="file" name="product_image" id="product_image" class="form-control">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </form>
            </div>
            <div class="col-sm-8">
                <h3 class="text-center">Products Table</h3>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($show_product_records as $result){ ?>
                        <tr>
                            <td><?php echo $i;$i++; ?></td>
                            <td><?php echo $result->title ?></td>
                            <td><?php echo $result->description ?></td>
                            <td><img src="<?= base_url('uploads/'.$result->image) ?>" alt="" style="width:60px;"></td>
                            <td>
                                <?php if($result->status=='1'){ ?>
                                    <button class="btn btn-success" id="<?php echo $result->id ?>" onclick="updateStatus(this)">Active</button>
                                <?php }else{ ?>
                                    <button class="btn btn-danger" id="<?php echo $result->id ?>" onclick="updateStatus(this)">De-active</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function updateStatus(e) {
            var id = e.id;

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('/admin/updateProductStatus'); ?>",
                data: {
                    id: id
                },
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                   window.location.reload();
                }
            });
        }
    </script>

</body>

</html>