<?php include('filesLogic.php'); ?>


<!DOCTYPE HTML>
<html>
    <head>
        <title>Downloads files</title>
        <style>
            form{
                width:  30%;
                margin: 100px auto;
                padding: 30px;
                border: 1px solid #555;
            }
            input{
                width:100%;
                border: 1px solid #f1e1e1;
                display: block;
                padding: 5px 10px;
            }
            button{
                border: none;
                padding: 10px;
                border-radius: 10px;
            }
            table{
                width: 60%;
                border-collapse: collapse;
                margin: 100px auto;
            }
            th,td{
                height: 5Opx;
                vertical-align: center;
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <form action="#" method='post' enctype="multipart/form-data">
                    <h3>Uploads files</h3>
                    <input type="file" name="myfile"><br>
                    <button type="submit" name="save">Upload</button>
                </form>
            </div>
            <div class="row">
                <table>
                    <thead>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Size (mb)</th>
                        <th>Downloads</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($connection,"SELECT * FROM files;");
                        while($file = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><?php echo $file['id_file']; ?></td>
                            <td><?php echo $file['name']; ?></td>
                            <td><?php echo $file['size']/1000; ?></td>
                           
                            <td>
                                <a href="download.php?file_id=<?php echo $file['id_file'];?>">Downloads</a>
                            </td>
                        </tr>
                        <?php };?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

