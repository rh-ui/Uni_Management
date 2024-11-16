<?php
include('connection.php');
?>
<div class="responsive-table">
    <table class="w-full">
        <thead>
            <tr>
                <td>fichier</td>
                <td>size</td>
                <td>Action</td>
                <td>modification</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $get_tp = mysqli_query($connection, "SELECT * FROM files WHERE destination='uploads/TP3.pdf'");
            if ($get_tp) {
                while ($tp = mysqli_fetch_assoc($get_tp)) {
                    ?>
                    <tr>
                        <td>
                            <?php
                            $extension = pathinfo($tp['name'], PATHINFO_EXTENSION);
                            if (in_array($extension, ['zip'])) {
                                ?>
                                <div class='file p-10 rad-10 '>
                                    <div class='txt-c between-block'>
                                        <img class='mt-15 mb-15 item-c' src='imgs/zip.svg'>
                                        <div class='mb-10 fs-14'>
                                            <?php echo $tp['name'] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } elseif (in_array($extension, ['pdf'])) {
                                ?>
                                <div class='file p-10 rad-10 '>
                                    <div class='txt-c between-block'>
                                        <img class='mt-15 mb-15 item-c' src='imgs/pdf.svg'>
                                        <div class='mb-10 fs-14'>
                                            <?php echo $tp['name'] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } elseif (in_array($extension, ['png']) || in_array($extension, ['jpg']) || in_array($extension, ['jpeg'])) {
                                ?>
                                <div class='file p-10 rad-10 '>
                                    <div class='txt-c between-block'>
                                        <img class='mt-15 mb-15 item-c' src='imgs/png.svg'>
                                        <div class='mb-10 fs-14'>
                                            <?php echo $tp['name'] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $tp['size'] / 1000 . " Kbs"; ?>
                        </td>
                        <td>
                            <div class="vn-green" style="text-align: center; text-decoration: none;color:grey">
                                <a href="download.php?id_file=<?php echo $tp['id'] ?> "
                                    class="btn btn-circle btn-primary text-white" role="button">download
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="vn-green" style="text-align: center; text-decoration: none;color:grey">
                                <a href="modification.php?id_file=<?php echo $tp['id'] ?> "
                                    class="btn btn-circle btn-primary text-white" role="button">modification
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>