<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "customersdb";


$conn = new mysqli($dbServername , $dbUsername, $dbPassword, $dbName);

extract($_POST);

if(isset($_POST['readcustomer']))
{

    $data = '<table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Titel</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Handy Number</th>
                    <th>Address</th>
                    <th>Edit Section</th>
                    <th>Delete Section</th>
                </tr>';


    $displayquery = "SELECT * FROM customers";
    $result = $conn->query( $displayquery );

    if( $result->num_rows > 0){

        $number = 1;
        while ( $row = $result->fetch_assoc() )
        {

            $data .='<tr>
                <td>' .$number.'</td>
                <td>' .$row['titel'].'</td>
                <td>' .$row['firstname'].'</td>
                <td>' .$row['lastname'].'</td>
                <td>' .$row['email'].'</td>
                <td>' .$row['mobile'].'</td>
                <td>' .$row['address'].'</td>
                <td>
                    <button onclick="GetUserDetail(' .$row['Personid'].')" class="btn btn-success">Edit Profile</button>
                </td>
                <td>
                    <button onclick="DeleteCustomer(' .$row['Personid']. ')" class="btn btn-warning">Delete Profile</button>
                </td>
            </tr>';
            $number++;
        }
    }
    $data .= '</table>';
        echo $data;
}



if(isset($_POST['titel']) && isset($_POST['firstname']) && isset($_POST['lastname']) &&
isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['address']) )
{
    $query = " INSERT INTO `customers`(`titel`, `firstname`, `lastname`, `email`, `mobile`, `address`) VALUES ( '$titel', '$firstname', '$lastname', '$email', '$mobile', '$address' )";
    $conn->query($query);
}


//delete customer

if(isset($_POST['deleteID']))
{
    $userid = $_POST['deleteID'];
    $deletequery = "delete from customers where Personid='$userid' ";
    $conn->query( $deletequery);
}


// get customer id for update 
    if(isset($_POST['id']) && isset($_POST['id']) != "")
    {
        $user_id = $_POST['id'];
        $query = "SELECT * FROM `customers` WHERE Personid = '$user_id' ";
        if (!$result = $conn->query($query))
        {
            exit( $conn->error );
        }

        $response = array();

        if( $result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc() )
            {
                $response = $row;
            }

            echo json_encode($response);
        }
        else
        {
            $response['status'] = 200;
            $response['message'] = "Invalid Request!";
        }
    }

    // update table and history

    if(isset($_POST['hidden_user_updid']))
    {
        $hidden_user_updid = $_POST['hidden_user_updid'];
        $updtitel = $_POST['updtitel'];
        $updfirstname = $_POST['updfirstname'];
        $updlastname = $_POST['updlastname'];
        $updemail = $_POST['updemail'];
        $updmobile = $_POST['updmobile'];
        $updaddress = $_POST['updaddress'];

        $fetchLastQuerry = " SELECT * FROM `customers` WHERE Personid = '$hidden_user_updid' ";
        $result =  $conn->query($fetchLastQuerry );
        $From = "";

        if( $result->num_rows > 0 )
        {
             $row = $result->fetch_assoc();
             $From .= $row['titel'] . ', '
                    . $row['firstname'] . ', '
                    . $row['lastname'] . ', '
                    . $row['email'] . ', '
                    . $row['mobile'] . ', '
                    . $row['address'];
        }
		
		// fixed here
        $To = $updtitel . ', '
            . $updfirstname . ', '
            . $updlastname . ', '
            . $updemail . ', '
            . $updmobile . ', '
            . $updaddress;


        $updateQuery = " UPDATE `customers` SET `titel`='$updtitel',`firstname`='$updfirstname',`lastname`='$updlastname',`email`='$updemail',`mobile`='$updmobile',`address`='$updaddress' WHERE Personid= '$hidden_user_updid' ";
        $conn->query($updateQuery);



        $insertQuery = " INSERT INTO `history`(`Personid`, `ChangedFrom`, `ChangedTo`) VALUES( $hidden_user_updid, $From, $To )";
        $conn->query($insertQuery);
    }


?>
