<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 10/28/16
 * Time: 9:17 AM
 */
header("content-type:application/json");

//create connection
$conn = new mysqli('localhost', 'root', 'afribaba2016', 'timesheets');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = isset($_POST['username'])?$_POST['username']:"";
$info = $_SERVER['REMOTE_ADDR']." , ".$_SERVER["HTTP_USER_AGENT"];

//start date
if (isset($_POST['action']) && $_POST['action'] == "start") {

    $id = uniqid();
    $sql = "INSERT INTO timesheet (id, username, start_datime, lastest, start_info) VALUES ('$id', '$username', NOW(), '1' ,'$info')";

    if ($conn->query($sql) == TRUE) {
        echo "New record created successfully";
    } else {
        echo "Err: " . $sql . "<br>" . $conn->error;
    }
}

//end date
if (isset($_POST['action']) && $_POST['action'] == "end") {

    $sql = "SELECT start_datime FROM timesheet WHERE username = '" . $username . "' AND lastest = 1";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
       $st = $row['start_datime'];break;
    }

    $datetime1 = strtotime($st);
    $datetime2 = strtotime(date("Y-m-d H:i:s"));
    $secs = $datetime2 - $datetime1;
    $hour = floor($secs / 3600);

    if($hour>1){
        $sql = "UPDATE timesheet SET end_datime = NOW(), lastest = 0, end_info = '" . $info . "'
         WHERE username = '" . $username . "' AND lastest = 1";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }else{
        echo"1";
    }
}

//search
if (isset($_POST['action']) && $_POST['action'] == "search") {

    $sql = "SELECT id, username, start_datime, end_datime, start_info, end_info, connexion_time, timestamp FROM timesheet WHERE username = '" . $username . "'";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {

        $datetime1 = strtotime($row["start_datime"]);
        $datetime2 = strtotime($row["end_datime"]);
        if($datetime2!=null || !empty($datetime2)){
            $secs = $datetime2 - $datetime1;// == return sec in difference
            $hour = floor($secs / 3600);
            $dt2format=date("H:i",strtotime($row["end_datime"]));
        }else{
            $hour=0;
            $dt2format="null";
        }
        $title =  " - ". $dt2format ."(". $hour ." h)";

        if($hour < 8){
            $klass = "red";
        }else{
            $klass = "blue";
        }

        $url = "</br> username: ".$row["username"]."</br></br>";
        $url = $url."start datetime: ".$row["start_datime"]."</br></br>";
        $url = $url."end datetime: ".$row["end_datime"]."</br></br>";
        $url = $url."start computer info: ".$row["start_info"]."</br></br>";
        $url = $url."end computer info: ".$row["end_info"]."</br></br>";
        $url = $url."connexion time: ".$row["connexion_time"]."</br></br>";
        $url = $url."timestamp: ".$row["timestamp"];


        array_push($data, array('id' => $url, 'title' => $title,
            'start' => $row["start_datime"], 'end' => $row["end_datime"], 'color' => $klass));
    }

    echo json_encode($data);

}

//check
if (isset($_POST['action']) && $_POST['action'] == "check") {

    $sql = "SELECT id, username, lastest FROM timesheet WHERE username = '" . $username . "' AND lastest = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo"1";
    }else{
        echo"0";
    }

}


$conn->close();
exit();