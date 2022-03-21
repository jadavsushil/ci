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
    <h1>Admin Dashboard</h1>
    <a href="<?= base_url('admin/logout'); ?>">Logout</a>

    <div class="container">
        <div class="col-sm-2">
            <div class="alert alert-info text-center">
                <b>Total Active Users</b> <br> 
                <?php 
                     echo count($show_active_users);
                ?>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="alert alert-info text-center">
                <b>Total Active Products</b> <br> 
                <?php 
                     echo count($show_active_products);
                ?>
            </div>
        </div>

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
        </div>
    </div>

    <form method="post" action="<?= base_url('admin/add_product') ?>" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <th>Title</th>
                <td>
                    <input type="text" name="title" id="title">
                </td>
            <tr>

            </tr>
            <tr>
                <th>Description</th>
                <td>
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                    <input type="file" name="product_image" id="product_image">
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit">
                </td>
            </tr>

        </table>
    </form>

    <table class="table">
        <thead>
            <th>Sl No.</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
        </thead>
        <tbody>
            <?php $i=1; foreach($show_product_records as $result){ ?>
            <tr>
                <td><?php echo $i;$i++; ?></td>
                <td><?php echo $result->title ?></td>
                <td><?php echo $result->description ?></td>
                <td><img src="<?= base_url('uploads/'.$result->image) ?>" alt=""></td>
                <td>
                    <?php if($result->status='1'){ ?>
                        <button class="btn btn-success">Active</button>
                    <?php }else{ ?>
                        <button class="btn btn-danger">De-active</button>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>