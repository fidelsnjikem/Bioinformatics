


<?php
/* this is a class that keeps track of user state. the class holds functions that checks if user is logged_in, etc

     
*/
    
class user_state {
    
//define class variables
    
    
    
    
    
//------------------------------------- define class functions ------------------------------------------------
    
public function is_logged() {
// this is a function that will check if user is logged in and returns true or false if user is not logged in
if (isset($_SESSION['valid_user'])) {  // if session vaid user exist then user is logged in
    
  return true;
    } else {
        
   return false;
    }
        } // ends is_logged function
//--------------------------------------------------------------------------------------------------------------
    
    
public function unactivated_user(){
//this function checks if user has created account but did not activate thier account by clicking on the link sent to thier emails
    
//query to check if user acct is activated
$query = "select active from registered_users where active = '1' ";
$result = $conn->query($query);  // pass query results to result variable

    if($result->num_rows==1){ // if 1 then user account has been activated
      return true;
    }
    else  {                 // if user acct is not activated write a message to user informing them
    echo"<h3 style='color:red'> <br><br> Sorry!!! You created an account but did not activate it by clicking on the link that part of </h3>"";
        return false;        // return false and exit
    } //end else bracket
    
}//ends unactivated_user function

//---------------------------------------------------------------------------------------------------------------
    

        
public function is_frequent_user(){
            
            
            
            
        }
    
public function is_valid_user(){
    
    
    
    }
        
        
        
public function redirect(){
            
            
            
            
        }
        
        
    }
        
        
      ?>