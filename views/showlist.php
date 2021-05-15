<?php
    require_once('../inc/navbar.php');
    if($_SESSION['posts'] !== false && count($_SESSION['posts']) > 0){
        ?>
            <div class="container">
                <div class="row">
                    <div class="card shadow rounded-3 px-2">
                        <div class="card-body">
                            <table class="table table-striped">
                            <tr>
                                <td>ID</td>
                                <td>Title</td>
                                <td>Body</td>
                                <td>Status</td>
                            </tr>

                        <?php
                        foreach($_SESSION['posts'] as $value){
                            ?>
                            <tr>
                                <td><?php echo $value['id']++;?></td>
                                <td><?php echo $value['title'];?></td>
                                <td><?php echo $value['body'];?></td>
                                <td><?php echo ($value['approved'] === 0) ? 'Not Approved' : 'Approved' ;?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <?php
    require_once ('../inc/script.php');

    }else{
        echo 'No posts to views';
    }

?>