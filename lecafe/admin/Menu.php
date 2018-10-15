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

//Delete product
    if(isset($_GET['delete'])){
        $id = sanitize($_GET['delete']);
        $db->query("UPDATE orders SET completed = 1 WHERE id = '$id'");
        header('Location: menu.php');
    }

$dbpath = '';
if(isset($_GET['add']) || isset($_GET['edit'])){
    $menuQuery = $db->query("SELECT * FROM menus ORDER BY menuItem");
    //$parentQuery = $db->query("SELECT * FROM ingredientsuseds WHERE menuID ="); //this logic needs fixing // goto bottem page where implemented
    $menuItem = ((isset($_POST['menuItem']) && $_POST['menuItem'] != '')?sanitize($_POST['menuItem']):'');
    //$ingredients = ((isset($_POST['ingredient']) && !empty($_POST['ingredient']))?sanitize($_POST['ingredient']):'');
    //$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
    $category = ((isset($_POST['menuCatagory']) && !empty($_POST['menuCatagory']))?sanitize($_POST['menuCatagory']):'');
    $price = ((isset($_POST['menuPrice']) && $_POST['menuPrice'] != '')?sanitize($_POST['menuPrice']):'');
    //$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
    $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
    $Ingredients = ((isset($_POST['ingredients']) && $_POST['ingredients'] != '')?sanitize($_POST['ingredients']):'');
    //$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');//will be changed to ingredients used
    //$sizes = rtrim($sizes,',');
    $saved_image = '';
    
    if(isset($_GET['edit'])){
        $edit_id = (int)$_GET['edit'];
        $MenuResults = $db->query("SELECT * FROM menus WHERE menuID = '$edit_id'");
        $item = mysqli_fetch_assoc($MenuResults);
        if(isset($_GET['delete_image'])){
            $image_url = $_SERVER['DOCUMENT_ROOT'].$item['image'];
            unlink($image_url);
            $db->query("UPDATE menus SET image = '' WHERE menuID = '$edit_id'");
            header('Location: Menu.php?edit='.$edit_id);
        }
        //$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$item['menuCatagory']);
        $menuItem = ((isset($_POST['menuItem']) && $_POST['menuItem'] != '')?sanitize($_POST['menuItem']):$item['menuItem']);
        $price = ((isset($_POST['menuPrice']) && $_POST['menuPrice'] != '')?sanitize($_POST['menuPrice']):$item['menuPrice']);
        $category = ((isset($_POST['menuCatagory']) && $_POST['menuCatagory'] != '')?sanitize($_POST['menuCatagory']):$item['menuCatagory']);
        $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):$item['menuDescription']);
        //$ingredients = ((isset($_POST['ingredient']) && $_POST['ingredient'] != '')?sanitize($_POST['ingredient']):$product['brand']);
        $ingredientsUsed = $db->query("SELECT * FROM ingredientsuseds WHERE menuID = '$edit_id'");// this may need a loop further down
        $ingredients = mysqli_fetch_assoc($ingredientsUsed);
        $Iid = ((isset($_POST['ingredients']) && $_POST['ingredients'] != '')?sanitize($_POST['ingredients']):$ingredients['ingreID']);        
        //$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):$product['sizes']);
        //$sizes = rtrim($sizes,',');
        $saved_image = (($product['image'] != '')?$product['image']:'');
        $dbpath = $saved_image;    
    }
//    if(!empty($ingredients)){        
//        $ingArray = array();
//        $qArray = array();
//        foreach($ingredients){
//            $iID = $ingredients['ingreID'];
//            $ingrName = $db->query("SELECT * FROM ingredients WHERE ingreID = '$iID");
//            $iname = mysqli_fetch_assoc($ingrName);
//            $ingArray[] = $iname['ingreName'];
//            $qArray[] = $ingredients['quantity'];
//        }        
//    }else{$ingredients = array();}
    
    if($_POST){
        $errors = array();
        $required = array('menuItem', 'menuCatagory', 'menuPrice', 'image');//there is something wrong with my logic here someone please check and fix .... or change whatever
        foreach($required as $field){
            if($_POST[$field] == ''){//this is the line that is picking up an error cant figure out my brain is alredy dead....///the prob may be that the auto loaded db arent Setting auto increment PK ids
                $errors[] = 'All the fields with an astrix are required.';
                break;
            }
        }
        if(!empty($_FILES)){
            $photo = $_FILES['image'];
            $name = $photo['name'];
            $nameArray = explode('.',$name);
            $fileName = $nameArray[0];
            $fileExt = $nameArray[1];
            $mime = explode('/',$photo['type']);
            $mimeType = $mime[0];
            $mimeExt = $mime[1];
            $tmpLoc = $photo['tmp_name'];
            $fileSize = $photo['size'];
            $allowed = array('png', 'jpg', 'jpeg', 'gif');
            $uploadName = md5(microtime()).'.'.$fileExt;
            $uploadPath = BASEURL.'images/products/'.$uploadName;
            $dbpath = '/lecafe/images/products/'.$uploadName;
            if($mimeType != 'image'){
                $errors[] = 'The file must be an image.';
            }
            if(!in_array($fileExt,$allowed)){
                $errors[] = 'The file extension must be png, jpg, jpeg or gif.';
            }
            if($fileSize > 15000000){
                $errors[] = 'The file size must be under 15MB.';
            }
            if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
                $errors[] = 'File extension does not match the file.';
            }
        }
        if(!empty($errors)){
            echo display_errors($errors);
        }else{
            //upload file and insert into db
            if(!empty($_FILES)){
                move_uploaded_file($tmpLoc,$uploadPath);
            }
            $insertMenu = "INSERT INTO `menus` (`menuItem`, `menuPrice`, `menuCatagory`, `menuDescription`, `image`)
            VALUES ('$menuItem', '$price', '$category', '$description', '$dbpath')";
            //$insertIngred = "INSERT INTO `ingredientsuseds` (`ingreID`, `menuID`, `quantity`)
            //VALUES ('','$edit_id','')";//needs a loop for ingred id and quantity
            if(isset($_GET['edit'])){                
                $insertMenu = "UPDATE `menus` SET `menuItem` = '$menuItem', `menuPrice` = '$price', `menuCatagory` = '$category', `menuDescription` = '$description', `image` = '$dbpath'
                WHERE menus.menuID = '$edit_id'";//may need to remove the extra '' in editid
            }
            $db->query($insertMenu);
            header('Location: menus.php');
            //var_dump($insertSql);
        }
    }    
?>
    <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ' : 'Add A New ');?>Menu Item</h2><hr>
    <form action="menu.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?> "method="POST" enctype="multipart/form-data">
        <div class="form-group col-md-3">
            <label for="menuItem">Menu Item Name*:</label>
            <input type="text" name="menuItem" id="menuItem" class="form-control" value="<?=$menuItem;?>">         
        </div>
        <div class="form-group col-md-3">
            <label for="menuCatagory">Categories*:</label>
            <select class="form-control" id="menuCatagory" name="menuCatagory">
                <option value=""<?=(($category == '')?' selected':'');?>></option>                
                <option value="Tea"<?=(($category == 'Tea')?' selected':'');?>>Tea</option>
                <option value="Cofee"<?=(($category == 'Cofee')?' selected':'');?>>Cofee</option>
                <option value="Hot Chocolate"<?=(($category == 'Hot Chocolate')?' selected':'');?>>Hot Chocolate</option>
                <option value="MilkShake"<?=(($category == 'MilkShake')?' selected':'');?>>MilkShake</option>                
            </select>                   
        </div>
        <div class="form-group col-md-3">
            <label for="menuPrice">Price*:</label>
            <input type="text" name="menuPrice" id="menuPrice" class="form-control" value="<?=$price;?>">         
        </div>
<!--
        <div class="form-group col-md-3">
            <label>Ingredients Used:*</label>
            <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;" >Ingredients Used:</button>    rename modal  
        </div>

        <div class="form-group col-md-3">
            <label for="ingredients">Ingredients Used: Preview</label>
            <input type="text" name="Iudes" id="Iused" class="form-control" value="<?=$ingredients;?>" readonly>         
        </div>
-->
        <div class="form-group col-md-6">
            <?php if($saved_image != ''){ ?>
            <div>
                <img src="<?=$saved_image;?>" alt="saved image"/><br>
                <a href="Menu.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
            </div>
            <?php }else{ ?>
                <label for="image">Product Image:</label>
                <input type="file" name="image" id="image" class="form-control">
            <?php }; ?>
        </div>
        <div class="form-group col-md-6">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>       
        </div>
        <div class="form-group pull-right">
        <a href="Menu.php" class="btn btn-default">Cancel</a>
            <input type="submit" value="<?=((isset($_GET['edit']))?'Edit' : 'Add');?> Menu" class="btn btn-success">
        </div><div class="clearfix"></div>
    </form>
    <!--Modal-->
<!-- This modal could be adapted later i was running into problems with the integration of many different tables and inserting the data into the diff db tables....
    <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sizesModalLabel">Ingredients & Quantity</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <php for($i=1;$i <= 12;$i++): ?>
                        <div class="form-group col-md-4">
                            <label for="Ingredient<=$i;?>">Ingredient:</label>
                            <input type="text" name="ingredient<=$i;?>" id="ingredient<=$i;?>" value="<=((!empty($ingArray[$i-1]))?$ingArray[$i-1]:'');?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="qty<=$i;?>">Quantity:</label>
                            <input type="number" name="qty<=$i;?>" id="qty<=$i;?>" style="width:40px;" value="<=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>">
                        </div>
                        <php endfor; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save</button>
                </div>
            </div>
        </div>
    </div>
-->
<?php 
}else{
    $sql = "SELECT * FROM menus";
    $presults = $db->query($sql);
    ?>
<h2 class="text-center">Menu Items:</h2>
<a href="Menu.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
    <thead><th></th><th>Item:</th><th>Price:</th><th>Category:</th><th>Description</th></thead> 
    <tbody>
        <?php while($menuItms = mysqli_fetch_assoc($presults)) :// the current table will need a huge change into displaying menu items not orders but need to go quick atm!!!!
            $mID = $menuItms['menuID'];
            $mNme = $menuItms['menuItem'];
            $mPrice = $menuItms['menuPrice'];
            $mCate = $menuItms['menuCatagory'];
            $mDesc = $menuItms['menuDescription'];
        ?>
    <tr>
        <td>
            <a href="Menu.php?edit=<?=$menuItms['menuID'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a><!-- will leave as is for now change when seperating order from menue items-->
            <a href="Menu.php?delete=<?=$menuItms['menuID'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?=$mNme;?></td>
        <td><?=money($mPrice);;?></td>
        <td><?=$mCate;?></td>
        <td><?=$mDesc;?></td>
        <?php endwhile; ?>
    </tbody>
</table>
<?php } include 'includes/footer.php'; ?>
