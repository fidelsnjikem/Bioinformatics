

<?php
  
    session_start();
    
    //error reporting code
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    require_once("connect.php");          //get database connection script
    $conn = db_connect();                // connect to database
   
    // class that handles user registration
    //implementation of user registration using an Object oriented approach.
    class register {
        
        // variables for registration
        public $db_connect;
        
        //create short variable names
        $_SESSION['firstname'] = $_POST['firstname'];
        $_SESSION['lastname']  = $_POST['lastname'];
        $_SESSION['email']     = $_POST['email'];
        $_SESSION['password']  = $_POST['password'];
        $_SESSION['password2'] = $_POST['password2'];
        $_SESSION['day']       = $_POST['day'];
        $_SESSION['month']     = $_POST['month'];
        $_SESSION['year']      = $_POST['year'];
        $_SESSION['gender']    = $_POST['gender'];
        $space = ' ';
        $_SESSION['bdate']     = $_POST['month'].$space.$_POST['day'].$space.$_POST['year'];
        $_SESSION['telephone'] = $_POST['areacode'].$_POST['telephone'];
        $_SESSION['ip']        = $_SERVER['REMOTE_ADDR'];
        $_SESSION['sell_intr'] = $_POST['answer'];
        $_SESSION['country']   = $_POST['country'];
        $_SESSION['buy_intr']  = $_POST['buy'];
        $_SESSION['base_cntr'] = $_POST['base_country'];
        $_SESSION['hash']      =  md5( rand(0,1000) );   // Generate random 32 character hash and assign it to a local variable.
        // Example output: f4552671f8909587cf485ea990207f3b
        
        
        
        function __construct($conn)
        {
            $this->$db_connect = $conn;
            
        }
        
        
        public function change_name($name)
        {
            $this->myname = $name;
        }
        
        
        public function getname()
        {
            return $this->myname;
        }
        
        
        
// FUNCTIONS THAT WILL BE USED FOR THE REGISTRATION PROCESS
        
/*-------------------------------------------------------------------------------------------------------------*/
       //validate form inputs
       public function form_entries_validate()
       /* this function validates the entries to the form during the sign up process*/
        {
        
            if (empty($_POST["firstname"])){
                return "<h3 style='color:red'>PLEASE PROVIDE A FIRSTNAME </h3>";
            }
            
            
            if (empty($_POST["lastname"])){
                return "<h3 style='color:red'>PLEASE PROVIDE A LASTNAME </h3>";
            }
            
            if (empty($_POST["email"])){
                return  "<h3 style='color:red'>PLEASE PROVIDE AN E-MAIL ADDRESS </h3>";
            }
            
            if (empty($_POST["password"])){
                return "<h3 style='color:red'>PLEASE PROVIDE THE FIRST PASSWORD</h3>";
            }
            
            if (empty($_POST["password2"])){
                return "<h3 style='color:red'>PLEASE PROVIDE THE SECOND PASSWORD </h3>";
            }
            
            if (empty($_POST["gender"])){
                return "<h3 style='color:red'>PLEASE PROVIDE A GENDER </h3>";
            }
            
            
            if (empty($_POST["month"])){
                return "<h3 style='color:red'>PLEASE PROVIDE YOUR 'MONTH' OF BIRTH </h3>";
            }
            
            if (empty($_POST["year"])){
                return "<h3 style='color:red'> PLEASE PROVIDE YOUR 'YEAR' OF BIRTH</h3>";
            }
            
            if (empty($_POST["day"])){
                return "<h3 style='color:red'>PLEASE PROVIDE YOUR 'DAY' OF BIRTH </h3>";
            }
            
            if (empty($_POST["answer"])){
                return "<h3 style='color:red'>PLEASE TELL US IF YOU ARE INTERESTED IN SELLING ITEMS IN AFRICA</font>";
            }
            
            if ( ($_POST["answer"]== 'yes') &&(empty($_POST["country"]) )){
                return "<h3 style='color:red'> YOU SAID 'yes' TO SELLING ITEMS TO AFRICA SO PLEASE SELECT A COUNTRY YOU WANT TO SELL TO</font>";
            }
            
            
            if (empty($_POST["buy"])){
                return "<h3 style='color:red'> PLEASE TELL US IF YOU ARE INTERESTED IN BUYING/VIEWING ITEMS BIENG SOLD </h3></font>";
            } 
            
            if (($_POST["buy"]=='yes_buy') &&(empty($_POST["base_country"]))){
                return "<h3 style='color:red'> YOU SAID YOU ARE INTERESTED IN BUYING/VIEW ITEMS SO PLEASE SELECT YOUR BASE COUNTRY</h3>";
                
            } 
            
            //check that categories are not left empty	
            if (!isset($_POST['category']) || (count($_POST['category']) < 1)){
            return "<h3 style='color:red'>PLEASE SELECT CATEGORIES YOU ARE INTERESTED IN BUYING/VIEWING </h3>";
            } 
            
            return true;
        }
        
/*-------------------------------------------------------------------------------------------------------------*/
        //check email validity
       public function valid_email($email)
        {
            // check an email address is possibly valid
            if (preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $email)) {
                return true;
            } else {
                echo'Email is Invalid. Please Check and Try again';
                return false;
            }
            
        } // end valid_email function
        
/*------------------------------------------------------------------------------------------------------------ */
        
        //check password
        public function check_password()
        {
        
         if($password!= $password2){ // if passwords not the same echo error and return false
            echo'<h3 style='color:red'>the passwords you entered do not match - please go back and try again.</h3>';
            return false;
            }
                                    // if length of passwords is less than 6 or more than 16 echo error msg
         else if ((strlen($password) < 6) || (strlen($password) > 16)) {
            echo'<h3 style='color:red'> Pour password must be between 6 and 16 characters Please go back and try again.</h3>';
            return false;
            }
            
            else return true;
            
        }// end  check_password
        
/*--------------------------------------------------------------------------------------------------------- */
        
        public function variable_clean_up($given_var)
        /* this function will clean up the variables  recieved from the user and remove any malicious inserts
         */
        {
         $given_var = htmlentities($given_var);         //pass variable through html entities
         $given_var = $conn-> real_escape_string($given_var); // escape to prevent injections
         return $given_var;                                // returns given variable
        }
        
/*----------------------------------------------------------------------------------------------------------- */
        public function check_user_repeat()
        /* function to check if user that wants to register already exist in the records(database)
         */
        {
         
         //query to check if same email already exist in the database
        $query = "select *
        from registered_users
        where email ='".$email."'";
        $result = $conn->query($query);  // pass query results to result variable
        if ($result->num_rows!=0) {      // if user(email) already in database(num_rows!=0)
        
           echo" <h3 style='color:red'> <br><br> Sorry!!! same email already exist in our records. <br> You can simply <a href=\"forgot_form.php\">reset your password </a> <br>if you forgot your password <br> or <a href='javascript:window.history.back()'> << Go Back</a>  and sign up with a  different email </</h3>";
                return false;
            }
        }// ends check_user_repeat() function
        
        
 /*----------------------------------------------------------------------------------------------------------- */
        public function reg_user_DB()
        /*
         function to  register new user to the database
         */
        {
        // inserts information into the database
        $query = "INSERT INTO registered_users (firstname,  lastname,  email, password , gender, categories, hash,telephone,target_country,sell_interest,buying_interest,birthdate, base_country ,birthday, birthmonth,birthyear, ip_add)
        VALUES ('{$_POST['firstname']}', '{$_POST['lastname']}' ,'{$_POST['email']}', '$password' , '{$_POST['gender']}' , '{$cc}' , '$hash','$telephone','$target_country', '$sell_interest','$buying_interest','$bdate','$base_country', '$birthday','$birthmonth', '$birthyear' , '$ip'  )";
            
        }// ends reg_user_DB() function

/*----------------------------------------------------------------------------------------------------------- */
        
        public function email_acct_activate()
        /*
         function sends email for user to activate their accounts
         */
        {
            
        //here and email is sent to verify email and activate account
        $to      = $email; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject
        $mail_content = '
        Thanks for creating an account  on  CATALICO
        Your account has been created, you can login with the following credentials after
        you have activated your account by clicking the url or link  below.
        ------------------------
        email: '.$email.'
        Password: **********
        ------------------------
        Please click this link to activate your account:
        http://www.catalico.com/verify.php?email='.$email.'&hash='.$hash.'';
        mail($to, $subject, $mail_content);
            
        }//  ends email_acct_activate
/*----------------------------------------------------------------------------------------------------------- */
        
        public function  send_admin_phne_msg()
        // sends message to admin's phone when a user registers
        {
        
        $phone_msg = '
        A new user has registered to the site below is the info
        email: '.$email.'
        firstname:'.$firstname.'
        lastname: '.$lastname.'
        ip: '.$ip.'
            ';
        mail('8195807428@fido.ca', '',$phone_msg);
        }
        
/*----------------------------------------------------------------------------------------------------------- */
      
        
        public function failed_regis()
        /*
         function that prints message if registration fails
         */
        {
            
            
            
        }
        
        public function succeed_regis()
        /*
         function that prints message if registration succeeds
         */
        {
            
            
            
        }
        
        
        
    }  // end class register
    
    
    ?>