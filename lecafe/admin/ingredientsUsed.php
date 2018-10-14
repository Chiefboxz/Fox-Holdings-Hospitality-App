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

    $sql = "SELECT * FROM ingredientsuseds";
    $result = $db->query($sql);
    $errors = array();
    $category = '';
    $post_parent = '';

//Edit Ingredient used
    if(isset($_GET['edit']) && !empty($_GET['edit'])){
        $edit_id = (int)$_GET['edit'];
        $edit_id = sanitize($edit_id);
        $edit_sql =  "SELECT * FROM ingredientsuseds WHERE MenuID = '$edit_id'";// this is a pointless statment just keping for safety
        $edit_result = $db->query($edit_sql);
        $edit_category = mysqli_fetch_assoc($edit_result);
        
        //point of below code is to get the ingredients id related to the used ingredient in menue item...
        $edit_Iused_sql =  "SELECT * FROM ingredientsuseds WHERE id = '$edit_id'"; //hopefully this edit id is selected from the physical id of ingreused table not FK data
        $edit_Iused_sql2 = $db->query($edit_Iused_sql);
        $edit_Iused_sql3 = mysqli_fetch_assoc($edit_Iused_sql2);
        $inID = $edit_Iused_sql3['ingreID'];
        $menItmID = $edit_Iused_sql3['menuID'];
        
        //point of below code is to get the details of the ingredient that was used from the above statement.....
        $edit_Ing_sql =  "SELECT * FROM ingredients WHERE ingreID = '$inID'";
        $edit_Ing_sql2 = $db->query($edit_Ing_sql);
        $edit_Ing_sql3 = mysqli_fetch_assoc($edit_Ing_sql2);
        $inName = $edit_Iused_sql3['ingreName'];
        
        //point of below code is to get the details of menu item which would be the parent file in this case....
        $edit_Menu_sql =  "SELECT * FROM menus WHERE MenuID = '$menItmID'";
        $edit_Menu_sql2 = $db->query($edit_Menu_sql);
        $edit_Menu_sql3 = mysqli_fetch_assoc($edit_Menu_sql2);
        $MnuName = $edit_Menu_sql3['menuItem'];

    }

//Delete used ingredient
    if(isset($_GET['delete']) && !empty($_GET['delete'])){//check what id this is pulling as a comparison...
        $delete_id = (int)$_GET['delete'];
        $delete_id = sanitize($delete_id);
        $sql = "SELECT * FROM ingredientsuseds WHERE id = '$delete_id'";
        $result = $db->query($sql);
        //id like to have a confirmation box to prevent accidental deletion here!!!!!!!!!!
        $dsql = "DELETE * FROM ingredientsuseds WHERE id = '$delete_id'";//make sure that the statement is getting the ingredusdid and not the fk id fields...
        $db->query($dsql);
        header('Location: ingredientsUsed.php');
    }


//proccess form   
    if(isset($_POST) && !empty($_POST)){
    $post_parent = sanitize($_POST['parent']);   //this needs to be the menuid from the menu table 
    $category = sanitize($_POST['category']);//need to make sure the ingred id is posted here whenever it is posted...
    
    $sqlform = "SELECT * FROM ingredientsuseds WHERE ingreID = '$category' AND menuID = '$post_parent'";
    if(isset($_GET['edit'])){
        $id = $edit_category['id'];    
        $sqlform = "SELECT * FROM ingredientsuseds WHERE ingreID = '$category' AND parent != '$post_parent' AND id != '$id'";
        }
    $fresult = $db->query($sqlform);
    $count = mysqli_num_rows($fresult);
      if($category == ''){
          $errors[] .= 'You must enter a ingredient used!';
       }
        
    if($count > 0){
        $errors[] .= $category. 'this already exists';
    }
    //display errors
    if(!empty($errors)){
        echo display_errors($errors);        
        } else { // There is some error with the adding to ingredients someone cat try debug if they want...
        $updatesql = "INSERT INTO ingredientsuseds (ingreID, menuID, quantity) VALUES ('$category','$post_parent', $quantity)"; // the quantity fienld must still be created to add the amount used for that ingredient in that item
        
        if(isset($GET['edit'])){
            $updatesql = "UPDATE ingredientsuseds SET ingreID = '$category', menuID = '$post_parent', quantity = '$quantity' WHERE id = '$edit_id'";
        }
        $db->query($updatesql);
        header('location: ingredientsUsed.php');
    }
}
    $ingred_value = '';
    $ingred_qty = '';
    $parent_value = 0;
    if(isset($_GET['edit'])){
        $ingred_value = $inName;
        $ingred_qty = $edit_Iused_sql3['quantity'];
        $parent_value = $MnuName;
    }else{
        if(isset($_POST)){
            $ingred_value = $category;
            $ingred_qty = '';
            $parent_value = $post_parent;
        }
    }
?>      


<h2 class="text-center">Ingredients Used Per Menu Item:</h2><hr>
<div class="row">
    
    <!--FORM-->  
    <div class="col-md-6">
        <form class="form" action="ingredientsUsed.php<?= ((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
            <legend><?=((isset($_GET['edit']))?'Edit' : 'Add an'); ?> Ingredient</legend>
            <div id="errors"></div>
            <div class="form-group">
                <label for="parent">Menu Items:</label>
                <select class="form-control" name="Menuitem" id="Menuitem">
                    <?php
                        $MenuSql =  "SELECT * FROM menus";
                        $MenuResult = $db->query($MenuSql);
                        //$MenuItm = mysqli_fetch_assoc($MenuResult);
                    ?>
                    <option value="0"<?=(($parent_value == 0)?'selected="selected"':''); ?>>Menu Item</option>
                    <?php while($menuItem = mysqli_fetch_assoc($MenuResult)) : ?>
                        <option value="<?=$menuItem['menuID']; ?>"<?=(($parent_value == $menuItem['menuID'])?' selected="selected"':''); ?>><?=$menuItem['menuItem'];?></option><!-- whats happening here is  hopefully option box displaying all menue items as items and then when an item is selected it selects the menu items menuID-->
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Ingredient Used:</label>                
                <input type="text" class="form-control" id="category" name="category" value="<?= $ingred_value; ?>">
                <label for="category">Quantity:</label> 
                <input type="text" class="form-control" id="quantity" name="quantity" value="<?= $ingred_qty; ?>">
            </div>
            <div class="form-group">
                <input type="submit" value="<?=((isset($_GET['edit']))?'Edit' : 'Add'); ?> Category" class="btn btn-success">
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
                <th>Ingredients Used:</th><th>Menu Item:</th><th></th>
            </thead>
            <tbody>
                <?php 
                        $MenuSql = "SELECT * FROM menus";
                        $MenuResult = $db->query($MenuSql);
                    while($parent = mysqli_fetch_assoc($MenuResult)): 
                        $parent_id = (int)$parent['menuID'];
                        $sql2 = "SELECT * FROM ingredientsuseds WHERE menuID = '$parent_id'";
                        $cresult = $db->query($sql2);
                ?>
                    <tr class="bg-primary">
                        <td><?=$parent['menuItem'];?></td>
                        <td>Quantity:</td>
                        <td>

                        </td>
                    </tr>
                    <?php while($child = mysqli_fetch_assoc($cresult)): ?>
                    <tr class="bg-info">
                        <td><?php
                            $chilId = $child['ingreID'];
                            $inm = "SELECT * FROM ingredients WHERE ingreID = '$chilId'";
                            $inName = $inm['ingreName'];
                            echo $inName;?></td><!--Ingredients used in order-->
                        <td><?= $child['quantity'] ;?></td><!--Quantity of each ingreadient used-->
                        <td>
                            <a href="ingredientsUsed.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="ingredientsUsed.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a> 
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endwhile;?>
            </tbody>
        </table>
    </div>
</div>
<script>
function confirm()
{
    return alert("Are you sure you want to submit the form"?);//this was an attempt in order to print a warning before editing or deleting data......
}
</script>


<?php
    include 'includes/footer.php';
?>