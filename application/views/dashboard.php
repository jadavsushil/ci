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
      <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">User</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
      
    </ul>
   
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#"> Welcoem, <?php echo $user_details->name ?> </a></li>
        <li><a href="<?= base_url('logout'); ?>"> Logout</a></li>
    </ul>
    
  </div>
</nav>
  
    <div class="container">
        <?php if ($user_details->active == '0') { ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="alert alert-info text-center">
                        Please Verify your email
                    </div>
                </div>
            </div>
        <?php } ?>

        <table class="table">
            <thead>
                <th>Sl No.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($show_product as $result) { ?>
                    <tr>
                        <td><?php echo $i;
                            $i++; ?></td>
                        <td><?php echo $result->title ?></td>
                        <td><?php echo $result->description ?></td>
                        <td><img src="<?= base_url('uploads/' . $result->image) ?>" alt="" style="width:110px;"></td>
                        <td><input type="number" name="quantity" class="form-control" id="qty_<?php echo $result->id ?>" ></td>
                        <td><input type="number" name="price" class="form-control" id="price_<?php echo $result->id ?>"></td>
                        <td>
                            <button class="btn btn-primary" id="<?php echo $result->id; ?>" onclick="addProduct(this)">Add</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

    <div class="container">
        <section style="background-color: #eee;">
            <div class="container py-5">
                <div class="row">
                    <?php foreach($show_userProduct as $result){ ?>
                    <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                        <div class="card text-black">
                            <center>
                                <img src="<?= base_url('/uploads/'.$result->image) ?>" class="card-img-top" style="width:110px;"/>
                                </center>
                            <div class="card-body">
                                <div class="text-center mt-1">
                                    <h4 class="card-title"><?php echo $result->title ?></h4>
                                    <h6 class="text-primary mb-1 pb-3" style="font-size:16px;">Quantity: <?php echo $result->qty ?></h6>
                                    <h6 class="text-primary mb-1 pb-3" style="font-size:16px;">Price: $<?php echo $result->price ?></h6>
                                </div>

                             
                               
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function addProduct(e) {
            var id = e.id;
            var qty = document.getElementById('qty_' + id).value;
            var price = document.getElementById('price_' + id).value;

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('/user_addProduct'); ?>",
                data: {
                    id: id,
                    qty: qty,
                    price: price
                },
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    swal({
                        title: "Product Added",
                        icon: "success",
                        button: "Ok",
                    });
                    setTimeout(function() {
                        location.reload(true);
                    }, 2000);
                }
            });
        }
    </script>
</body>

</html>