

<?php
    
session_start();
    
//error reporting code
error_reporting(E_ALL);
ini_set('display_errors', '1');
    
require_once("connect.php"); //get database connection script
$conn = db_connect(); // connect to database
    
/* This class  takes the input from the user checks it against the records in the database and either logs or refuses to log the user in */
    
class log_user {
        
// variables for log in
public $db_connect;
$userid = variable_clean_up($_POST['userid']); //userid is useremail. the var is cleaned by the fn and assigned to userid
$password = variable_clean_up(md5($_POST['password'])); // get user id
$login_ip = $_SERVER['REMOTE_ADDR'];  // get log_in IP address


/* -------------------------------------------------------------------------------  */
    
function __construct($conn)//constructor
    {
        $this->$db_connect = $conn;
        
    }


/*----------------------------------------------------------------------------------- */
    
function get_user_db_info()
/* this function goes to db and gets the log in information of a user */
    {
if(isset($userid) && !empty($userid) AND isset($password) && !empty($password)){ //if statement makes sure does not log in when fields are empty
    
$query = $query = 'select * from registered_users'// query to get user credentials from db
."where email ='$userid'"
." and password = '$password'";
            
$result = $db_conn->query($query); //get results of querry and puts in results variable
$row = $result->fetch_assoc(); // fetches the whole row from database and puts it in an assosicate array
$goodpwd = $row['password'];  //  goes to the row, gets the password and assigns it to the variable  goodpwd
    
    }// ends get_user_db_info
/*----------------------------------------------------------------------------------  */
        
        
function regis_login_to_db()
/* this function writes to the database whenever a user logs in. it helps admin to monitor login activity. if connection fails, write error to errors page  */
        {
$log_date = date("Y/m/d");      //pass current date to log_date variable
$log_time =  date("h:i:sa");   //pass current time to log_time variable

// insert log activity to db
$query = "insert into log_activity (username, useremail, log_ip, log_date, log_time)
values  ('".$row['firstname']."', '".$row['email']."', '".$ip."', '".$log_date."', '".$log_time."')";
            
$result = $db_conn->query($query);   // pass query to results variable
if (!$result) {  // if no results
//printf("Errormessage: %s\n", $db_conn->error);  // print error message to error file
return false;
        
        }
    }// ends regis_login_to_db function
/*------------------------------------------------------------------------------------- */

function log_in_user()
/*this function logs the user either to the homepage or the page they   */

{
$lastpage = $_COOKIE['lastpage'];  //get cookie  for last visited page
$log_out_url = 'http://www.catalico.com/logout.php'; // url for log out page
    
if(isset($lastpage) &&!empty($lastpage) && $lastpage!= $log_out_url )//if user last visited  an item, send them to that item's page
//if user last visited log out page do not return there
{
header("Location: $lastpage");  // redirect user to the page they where on
}
else
header("Location: /customised_page.php"); // Redirect browser  to homepage if last viewed page was not a product or was log out page
    
} // ends log_in_user

/* -------------- ---------------------------------------------------------------------------*/
        
function failed_log_in()
/* function to redirect user if they attempt to log in and fail  */
{
header("Location: /failed_login.php"); // Redirect browser to failed log in page if log in failed
        
}



?>