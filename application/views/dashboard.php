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
    <h1>User Dashboard</h1>
    <a href="<?= base_url('logout'); ?>">Logout</a>

    <div class="container">
        <?php if($user_details->active=='0'){ ?>
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
          
        </thead>
        <tbody>
            <?php $i=1; foreach($show_product as $result){ ?>
            <tr>
                <td><?php echo $i;$i++; ?></td>
                <td><?php echo $result->title ?></td>
                <td><?php echo $result->description ?></td>
                <td><img src="<?= base_url('uploads/'.$result->image) ?>" alt=""></td>
                
            </tr>
            <?php } ?>
        </tbody>
    </table>

    </div>
</body>
</html>