<?php
include_once('includes/navbar.php');
include('app/indexhandler.php');

?>
            <div class="container">
                <h2 class="text-center">Themes</h2>
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created at</th>
                            <th>Created by</th>
                        </tr>
                    </thead>
                 <tbody>
                  <tr>
                    <?php
                    if ($fetch_themes->rowCount() > 0) {
                        $rows = $fetch_themes->fetchAll();
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            echo '<td><a href="theme.php?id='.$id.'">'.$row['title'].'</td>';
                            echo '<td>'.$row['description'].'</td>';
                            echo '<td>'.$row['created_at'].'</td>';
                            echo '<td>'.$row['username'].'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>

                    </tbody>
                </table>
            </div>

<?php
include('includes/footer.php');
?>