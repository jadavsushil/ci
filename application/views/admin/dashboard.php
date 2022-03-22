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
      <li class="active"><a href="<?= base_url('/admin/dashboard') ?>">Home</a></li>
      <li><a href="<?= base_url('/admin/products') ?>">Products</a></li>
      
    </ul>
   
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?= base_url('admin/logout'); ?>"> Logout</a></li>
    </ul>
    
  </div>
</nav>
    
    <div class="container-fluid">
       
        <div class="col-sm-4">
            <div class="alert alert-info text-center">
                <b>Total Active Users</b> <br> 
                <?php 
                     echo count($show_active_users);
                ?>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="alert alert-info text-center">
                <b>Total Active Products</b> <br> 
                <?php 
                    echo count($show_active_products);
                ?>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="alert alert-info text-center">
                <b>Active and verified users who have attached active products</b> <br> 
                <?php 
                     echo count($countActVerUserProduct);
                ?>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="alert alert-info text-center">
                <b>Active products which don't belong to any user</b> <br> 
                <?php 
                     echo count($countActProDontUser);
                ?>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="alert alert-info text-center">
                <b> Quantity of all active attached products</b> <br> 
                <?php 
                     echo $CountQTYActiveProductsUser->TotalProduct;
                ?>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="alert alert-info text-center">
                <b> Summarized price of all active attached products</b> <br> 
                <?php 
                     echo $CountPriceActiveProductsUser;
                ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
        <div class="col-sm-8">
                <h3 class="text-center">All Users Summarized Price</h3>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Full Name</th>
                            <th>Summarized Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($getAllUsers as $result){ 
                            $total_summ_price = $this->admin_model->getSumProPrice($result->id);    
                        ?>
                        <tr>
                            <td><?php echo  $i;$i++; ?></td>
                            <td><?php echo $result->name ?></td>
                            <td><?php echo '$'.$total_summ_price; ?></td>
                           
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