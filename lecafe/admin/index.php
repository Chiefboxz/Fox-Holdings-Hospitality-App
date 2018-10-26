<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/lecafe/core/init.php';
//require_once 'lecafe/admin/core/init.php';
if(!is_logged_in()){
    header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
    if(isset($_GET['delete'])){
        $id = sanitize($_GET['delete']);
        $db->query("UPDATE orders SET completed = 1 WHERE id = '$id'");
        header('Location: index.php');
    }

    $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
	$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
    $userQuery = $db->query("SELECT * FROM user ORDER BY full_name");	
?>
<h4 class="text-center">Administrator Home</h4><br><br>


<table class="table table-bordered table-condensed table-striped">
    <thead><th></th><th>Customer</th><th>Beverage</th><th>Price</th><th>Quantity</th><th>Collection Time</th><th>Total Price</th></thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM orders WHERE completed = 0";
            $presults = $db->query($sql);
        while($order = mysqli_fetch_assoc($presults)) :
            $cID = $order['cID'];
            $custSql = $db->query("SELECT * FROM customers WHERE cID = '$cID'");
            $Cname = mysqli_fetch_assoc($custSql);
            $Cust = $Cname['cFirstname'] + " "+$Cname['cLastname'];
            $mID = $order['menuID'];
            $menSql = "SELECT * FROM menus WHERE menuID = '$mID'";
            $result = $db->query($menSql);
            $item = mysqli_fetch_assoc($result);
            $Beverage = $item['menuItem'];
            $MenuPrice = $item['menuPrice'];
            $quant = $order['orderQuantity'];
            $Collect = $order['orderCollection'];
            $totP = $MenuPrice * $quant;
        ?>
    <tr>
        <td>
            <a href="index.php?delete=<?=$order['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?=$Cust;?></td>
        <td><?=$Beverage;?></td>
        <td><?=money($MenuPrice);?></td>
        <td><?=$quant;?></td>
        <td><?=$Collect;?></td>
        <td><?=$totP;?></td>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php';

?>
