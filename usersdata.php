<?php
include "header.php";
require_once "../database/db_connect.php";
?>
<div class="container mt-5">
    <div>
        <h1 class="text-center text-primary">User Data</h1>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `users`";                                                                                                                                                                  
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                        echo "<td>
                        <button class='btn btn-sm btn-primary edit_btn'>Edit</button>
                        <button class='btn btn-sm btn-danger delete_btn'>Delete</button>
                      </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No results found</td></tr>";
                }
                $link->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.edit_btn').on('click', function () {
            console.log('edit clicked');
        });
         $('.delete_btn').on('click', function () {
            console.log('delete clicked');
        });
    });
</script>
<?php include "footer.php"; ?>