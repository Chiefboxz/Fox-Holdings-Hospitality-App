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
    //get ingredients from database
    $sql = "SELECT * FROM ingredients ORDER BY ingreName";
    $results = $db->query($sql);
    $errors = array();
    
    //Edit ingredient
    if(isset($_GET['edit']) && !empty($_GET['edit'])){
        $edit_id = (int)$_GET['edit'];
        $edit_id = sanitize($edit_id);
        $sql2 = "SELECT * FROM ingredients WHERE ingreID = '$edit_id'";
        $edit_result = $db->query($sql2);
        $eingre = mysqli_fetch_assoc($edit_result);
        
        
    }
    //Delete ingredient
    if(isset($_GET['delete']) && !empty($_GET['delete'])){ // would like extra validation in order to have a check prompt before deleting a column
        $delete_id = (int)$_GET['delete'];
        $delete_id = sanitize($delete_id);
        $sql = "DELETE FROM ingredients WHERE id = '$delete_id'";
        $db->query($sql);
        header('Location: ingredients.php');
        
    }
    
    //If add form is submitted
    if(isset($_POST['add_submit'])){
        $ingred = sanitize($_POST['ingreName']);
        $ingDesc = sanitize($_POST['ingreDescription']);
        //check if ingredient is blank
        if($_POST['ingreName'] == ''){ //can add ectra functionality in case you want to make sure the description cant be null
            $errors[] .= 'You must enter an ingredient!';
        }
        //check if ingredient exists in database
        $sql = "SELECT * FROM ingredients WHERE ingreName = '$ingred'";
        if(isset($_GET['edit'])){
            $sql = "SELECT * FROM ingredients WHERE ingreName = '$ingred' AND ingreID != '$edit_id'";
        }
        $result = $db->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0){
            $errors[] .= $ingred .' already exists';
        }
        
        //display errors
        if(!empty($errors)){
            echo display_errors($errors);
        }else{
            //Add ingredient to database
            $sql = "INSERT INTO ingredients (ingreName, ingreDescription) VALUES ('$ingred', '$ingDesc')";
            if(isset($_GET['edit'])){
                $sql = "UPDATE ingredients SET `ingreName` = '$ingred', `ingreDescription` = '$ingDesc' WHERE ingreID = '$edit_id'";
            }
            $db->query($sql);
            header('Location: ingredients.php');
        }
        
    }
?>
<h2 class="text-center">Ingredients:</h2><hr>
<!-- Ingredients Form-->
<div class="text-center">
    <form class="form-inline" action="ingredients.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?> "method="post">
        <div class="form-group">
            <?php
            $ingred_value='';
            $ingred_Desc='';
            ?>
            <?php if(isset($_GET['edit'])){
                $ingred_value = $eingre['ingreName'];
                $ingred_Desc = $eingre['ingreDescription'];
            }else{
                if(isset($_POST['ingredients'])){
                    $ingred_value = sanitize($_POST['ingreName']);
                    $ingred_Desc = sanitize($_POST['ingreDescription']);
                    
                }
            } ?>
            <label for="ingredients"><?=((isset($_GET['edit']))?'Edit' : 'Add a'); ?> Ingredient:</label>
            <input type="text" name="ingreName" id="ingreName" class="form-control" value="<?= $ingred_value; ?>">
            <input type="text" name="ingreDescription" id="ingreDescription" class="form-control" value="<?= $ingred_Desc; ?>">
            <?php if(isset($_GET['edit'])): ?>
            <a href="ingredients.php" class="btn btn-default">Cancel</a>
            <?php endif; ?>
            <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit' : 'Add'); ?> Ingredient" class="btn btn-success">
        </div>
    </form>
</div><hr>
<table class="table table-bordered table-striped table-auto table-condensed">
    <thead>
        <th></th><th>Ingredient:</th><th></th>
    </thead>
    <tbody>
        <?php while($ingred = mysqli_fetch_assoc($results)) : ?>
            <tr>
                <td><a href="ingredients.php?edit=<?= $ingred['ingreID'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
                <td><?= $ingred['ingreName']; ?></td>
                <td><a href="ingredients.php?delete=<?= $ingred['ingreID'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>