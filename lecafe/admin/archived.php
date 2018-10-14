<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/lecafe/core/init.php';
if(!is_logged_in()){
    login_error_redirect();
}
if(!has_permission('editor')){
    permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

if(isset($_GET['arc'])){
    $id = sanitize($_GET['arc']);
    $db->query("UPDATE orders SET completed = 0 WHERE id = '$id'");
    header('Location: archived.php');
    
}
$sql = "SELECT * FROM orders WHERE completed = 1";
$presults = $db->query($sql);

?>
<table class="table table-bordered table-condensed table-striped">
    <thead><th></th><th>Product</th><th>Price</th><th>CollectionTime</th></thead>
    <tbody>
        <?php while($orders = mysqli_fetch_assoc($presults)) :
            $childID = $orders['mID'];
            $catSql = "SELECT * FROM menues WHERE menuID = '$childID'";
            $result = $db->query($catSql);
            $menu = mysqli_fetch_assoc($menu);
            $menuitm = $menu['menuItem'];
        ?>
    <tr>
        <td>
            <a href="archived.php?arc=<?=$orders['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh"></span></a>
        </td>
        <td><?=$menu['menuItem'];?></td>
        <td><?=money($menu['menuPrice']);?></td>
        <td><?=$order['orderCollection'];?></td>
    </tr>
        <?php endwhile; ?>
    </tbody>
</table>


<?php  include 'includes/footer.php'; ?>