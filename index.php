<?php
/** Create a food order form */

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require files
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validate.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function() {

    //Display a view
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define an order route
$f3->route('GET|POST /survey', function($f3) {

    //var_dump($_POST);

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD']=='POST') {

        //Get the data from the POST array
        $userName = $_POST['name'];
        //If the data is valid --> Store in session
        if(validName($userName)) {
            $_SESSION['name'] = $userName;
        }
        //Data is not valid -> Set an error in F3 hive
        else {
            $f3->set('errors["name"]', "You must enter a name to continue");
        }
        if(isset($_POST['options'])) {
            $userOptions = $_POST['options'];

            if(validOptions($userOptions)) {
                $_SESSION['options'] = implode(", ", $userOptions);
            }
            else {
                $f3->set('errors["options"]', "go away!");
            }

        }
        else {
            $f3->set('errors["options"]', "You need to select at least one option to continue");

        }

        //If there are no errors, redirect to /order2
        if(empty($f3->get('errors'))) {
            $f3->reroute('/summary');  //GET
        }
    }

    //var_dump($_POST);
    //$f3->set('meals', getMeals());
    $f3->set('options', getOptions());
    $f3->set('userName', isset($userName) ? $userName : "");

    //Display a view
    $view = new Template();
    echo $view->render('views/survey.html');
});


//Define a summary route
$f3->route('GET|POST /summary', function() {

    //Display a view
    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});

//Run Fat-Free
$f3->run();