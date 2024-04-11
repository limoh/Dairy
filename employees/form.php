<a href='index.php' class='btn btn-primary'>Back To Employees</a>
<form action='' method='POST'> 
    <div class="control-group"> 
        <label class="control-label" for="e_name">Name:</label >
            <div class="controls">  
                <?php
                    if(isset($row) && !is_null($row)) {
                        $name_value = isset($row['e_name']) ? stripslashes($row['e_name']) : '';
                    } else {
                        $name_value = '';
                    }
                ?>
                <input class="input-xlarge" type="text" name="e_name" value="<?php echo $name_value; ?>" />
            </div> 
    </div>
    <div class="control-group">    
        <label class="control-label" for="e_mail">E-Mail:</label >
        <div class="controls">
            <?php
                if(isset($row) && !is_null($row)) {
                    $email_value = isset($row['e_mail']) ? stripslashes($row['e_mail']) : '';
                } else {
                    $email_value = '';
                }
            ?>
            <input class="input-xlarge" type="email" name="e_mail" value="<?php echo $email_value; ?>" /> 
        </div> 
    </div>
    <div class="control-group">    
        <label class="control-label" for="e_pass">Pass:</label >
        <div class="controls">  
            <input class="input-xlarge" type="text" name='e_pass' value='' /> 
        </div> 
    </div>
    <div class="control-group">     
    <label class="control-label" for="e_role">Role:</label > 
    <div class="controls">            
        <?php
            if(isset($row) && !is_null($row)) {
                $role_value = isset($row['e_role']) ? stripslashes($row['e_role']) : '';
            } else {
                $role_value = '';
            }
        ?>
        <select class="input-xlarge" name="e_role"> 
            <option <?php echo $selected = ($role_value == 'Clerk') ? 'selected' : ''; ?>>Clerk</option>
            <option <?php echo $selected = ($role_value == 'Supervisor') ? 'selected' : ''; ?>>Supervisor</option>
            <option <?php echo $selected = ($role_value == 'Manager') ? 'selected' : ''; ?>>Manager</option>
        </select> 
    </div> 
</div>
<div class="control-group">    
    <label class="control-label" for="e_payroll_no">Payroll No:</label >   
    <div class="controls">        
        <?php
            if(isset($row) && !is_null($row)) {
                $payroll_no_value = isset($row['e_payroll_no']) ? stripslashes($row['e_payroll_no']) : '';
            } else {
                $payroll_no_value = '';
            }
        ?>
        <input class="input-xlarge" type="text" name="e_payroll_no" value="<?php echo $payroll_no_value; ?>" /> 
    </div>
</div>
    <div class="control-group">    
        <input class="btn btn-large btn-success" type='submit' value='Save' />
        <input type='hidden' value='1' name='submitted' /> 
    </div>
</form>